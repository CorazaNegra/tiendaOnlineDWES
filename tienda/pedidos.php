<?php
    session_start();

    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once("global/Pedidos.php");
    require_once ("templates/cabecera.php");

    $dni = $_SESSION['dni'];
    $rol = $_SESSION['rol'];

    //$enlaceInicio = ($rol === 'admin') ? 'articulosAdminEditor.php' : 'articulosAdminEditor.php';
    //$enlaceMisDatos = ($rol === 'admin') ? 'indexAdmin.php' : 'indexEditorUsuario.php';

    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

    $con = conectar_pdo();
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

    $PAGS = 3;
    $pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
    $inicio = ($pagina - 1) * $PAGS;

    /*if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["volver"])) {

        if ($_POST['volver'] == true){
            $_SESSION['resultados_busqueda_pedidos'] = null;
            $_POST['volver'] = false;
        }
    }*/

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["volver"])) {
        if ($_POST['volver'] == true){
            $_SESSION['resultados_busqueda_pedidos'] = null;
            $_POST['volver'] = false;
        }
        
        header("Location: pedidos.php");
        exit();
    }
    

    if(isset ($_GET["nombre"])){
        $nombre = $_GET["nombre"];
    }

    if(isset ($_GET["mensaje"])){
        $mensaje = $_GET["mensaje"];
    }

    if(isset($_GET['buscar'])){
        if($_GET['buscar'] != null){
            $mensaje = $_GET['buscar'];
            $_GET['buscar'] = null;    
        }
    }

    $rolesPermitidos = ['admin', 'empleado', 'usuario'];

    // Verificar autenticación y roles permitidos
    verificarAutenticacion($rolesPermitidos);

    buscarPedido($con, $rol, $dni);
    actualizarPedido($con);
?>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <h1 style="color:#487317">Gestión de Pedidos</h1>
        <hr>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col table-responsive">
        <table class="table table-light table-sm">
            <tbody>
                <tr>
                    <td class="align-middle"> <!-- Añadido -->
                        <form class="form-inline justify-content-center" id="ordenar" method="get">
                            <label class="my-1 mr-2" for="order">Id Pedido:</label>
                            <select class="custom-select my-1 mr-sm-2" id="order" name="order">
                                <option value="asc" <?php echo ($order === 'asc') ? 'selected' : ''; ?>>Ascendente</option>
                                <option value="desc" <?php echo ($order === 'desc') ? 'selected' : ''; ?>>Descendente</option>
                            </select>
                            <button type="submit" class="btn my-1" style="background-color: #487317; color: white;">Aplicar</button>
                        </form>
                    </td>    
                    <td class="align-middle"> <!-- Añadido -->
                        <form class="form-inline justify-content-center" action="pedidos.php" method="POST">
                            <input class="form-control mr-sm-2 mb-sm-0" type="search" name="id"  maxlength="11" placeholder="Id del Pedido" required aria-label="Search">
                            <input type='hidden' name='action' value='buscar'>
                            <button class="btn my-2 my-sm-0" type="submit" style="background-color: #487317; color: white;">Buscar</button>
                        </form>    
                    </td>
                </tr>    
            </tbody>
        </table>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col text-center">
        <?php if(isset($mensaje) && $mensaje!="") { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>  
    </div>  
</div>
<div class="row justify-content-center">
    <div class="col-12 text-center">
        
        
        <table id="admin" class="table table-sm">
            <thead class="table-dark" style="background-color: #487317;">
                <th>Id Pedido</th>
                <th>Clave Transacción</th>
                <th>Fecha</th>
                <th>Cod. Usuario</th>
                <th>Total</th>
                <th>Estado</th>
            </thead>
        <?php

            if (isset($nombre)){
                echo "<p id='p'>Se ha eliminado correctamente el artículo con nombre: " . $nombre . "</p>";
            }
            
            if (isset($order)){
                $resultados = (isset($_SESSION['resultados_busqueda_pedidos'])) ? $_SESSION['resultados_busqueda_pedidos'] : (new Pedido($con, $rol, $dni))->obtenerPedidosOrdenados($order);
                
            }else {
                $resultados = (isset($_SESSION['resultados_busqueda_pedidos'])) ? $_SESSION['resultados_busqueda_pedidos'] : (new Pedido($con, $rol, $dni))->obtenerPedidos();

            }
            $num_total_registros = count($resultados);
            $total_paginas = ceil($num_total_registros / $PAGS);
            $result_pagina = array_slice($resultados, $inicio, $PAGS);
            // $resultados = (isset($_SESSION['resultados_busqueda'])) ? $_SESSION['resultados_busqueda'] : (new Articulo($con))->obtenerArticulos();
            // $num_total_registros = count($resultados);
            // $total_paginas = ceil($num_total_registros / $PAGS);
            // $result_pagina = array_slice($resultados, $inicio, $PAGS);

            foreach ($result_pagina as $res) {
                echo "<tr>";
                echo "<td>{$res["idPedido"]}</td>";
                echo "<td>{$res["claveTransaccion"]}</td>";
                echo "<td>{$res["fecha"]}</td>";
                echo "<td>{$res["codUsuario"]}</td>";
                echo "<td>{$res["total"]}</td>";
                echo "<td>";
                
                // Formulario para actualizar el estado del pedido
                echo "<form action='pedidos.php' method='post' class='form-inline'>";
                echo "<select name='estado' class='form-control-sm mr-2'>";
                
                // Opción por defecto con el estado actual del pedido
                echo "<option value='{$res["estado"]}'>{$res["estado"]}</option>";
                
                // Verificar el rol del usuario
                if ($_SESSION['rol'] === 'usuario') {
                    // Si el rol es usuario, mostrar solo la opción Cancelado
                    echo "<option value='Cancelado'>Cancelar</option>";
                } else {
                    // Si el rol es otro, mostrar todas las opciones
                    echo "<option value='Pedido recibido'>Pedido recibido</option>";
                    echo "<option value='Pago pendiente'>Pago pendiente</option>";
                    echo "<option value='Pago confirmado'>Pago confirmado</option>";
                    echo "<option value='En preparación'>En preparación</option>";
                    echo "<option value='Enviado'>Enviado</option>";
                    echo "<option value='Entregado'>Entregado</option>";
                    echo "<option value='Cancelado'>Cancelado</option>";
                    echo "<option value='Reembolsado'>Reembolsado</option>";
                    echo "<option value='En espera de stock'>En espera de stock</option>";
                    echo "<option value='En espera de confirmación'>En espera de confirmación</option>";
                }
                
                echo "</select>";
                echo "<input type='hidden' name='codigo_pedido' value='{$res['idPedido']}'>";
                echo "<input type='hidden' name='clave_transaccion' value='{$res['claveTransaccion']}'>";
                echo "<button class='btn btn-sm' type='submit' style='background-color: #487317; color: white;'>Actualizar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            
            
            
        ?>
        </table>
        
    </div>
</div>
<div class="row justify-content-center">
    <div class="col text-center">
    <?php
            if ($total_paginas > 1) {
                for ($i = 1; $i <= $total_paginas; $i++) {
                    $activo = ($i == $pagina) ? "style='color: black;'" : "style='color: #487317;'";
                    echo "<a href='pedidos.php?pagina=$i' $activo>$i</a> ";
                }
            }

            //echo "<br> Registros encontrados: $num_total_registros<br>";
            //echo "<br>";
            echo "Página $pagina de $total_paginas <p>";
        ?>
    </div>
</div>
<div class="row">
    <div class="col text-center">
        <section>
            <form action="pedidos.php" method="POST">
                <input type="hidden" name="volver" value="true">
                <input type="hidden" name="no_mensaje" value="true">
                <button class="btn" type="submit" style="background-color: #487317; color:white;">Mostrar todos los registros</button>
            </form>
        </section>
    </div>
</div>
        
<?php 
 include "templates/pie.php";
?> 