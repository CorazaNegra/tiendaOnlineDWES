<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once ("global/seguridad.php");
require_once ("global/funciones.php");
require_once ("global/Cliente.php");
require_once ("templates/cabecera.php");

$con = conectar_pdo();

    $dni= $_SESSION['dni'];
    $rol= $_SESSION['rol'];
    
    $nombreUsuario = $_SESSION['nombre'];
    
    
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
    
    if(isset ($_GET["nombre"])){
        $nombre = $_GET["nombre"];
    } 

    if(isset($_GET['alta'])){
        if($_GET['alta'] != null){
            $mensaje = $_GET['alta'];
            $_GET['alta'] = null;    
        }
    }

    if(isset($_GET['buscar'])){
        if($_GET['buscar'] != null){
            $mensaje = $_GET['buscar'];
            $_GET['buscar'] = null;    
        }
    }

    $PAGS = 5;
    $pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
    $inicio = ($pagina - 1) * $PAGS;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["volver"])) {
        if ($_POST['volver'] == true){
            $_SESSION['resultados_busqueda'] = null;
            $_POST['volver'] = false;
        }
    }

    if(isset ($_GET["mensaje"])){
        $mensaje = $_GET["mensaje"];
    }

    $rolesPermitidos = ['admin'];

    // Verificar autenticación y roles permitidos
    verificarAutenticacion($rolesPermitidos);

    buscarClientes($con);

?>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <h1 style="color:#487317">Gestión de Usuarios</h1>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col table-responsive">
        <table class="table table-light">
            <tbody>
                <tr>
                    <td class="align-middle"> <!-- Añadido -->
                        <form class="form-inline justify-content-center" id="ordenar" method="get">
                            <label class="my-1 mr-2" for="order">Nombre:</label>
                            <select class="custom-select my-1 mr-sm-2" id="order" name="order">
                                <option value="asc" <?php echo ($order === 'asc') ? 'selected' : ''; ?>>Ascendente</option>
                                <option value="desc" <?php echo ($order === 'desc') ? 'selected' : ''; ?>>Descendente</option>
                            </select>
                            <button type="submit" class="btn my-1" style="background-color: #487317; color: white;">Aplicar</button>
                        </form>
                    </td>    
                    <td class="align-middle"> <!-- Añadido -->
                        <form class="form-inline justify-content-center" action="administrador.php" method="POST">
                            <input class="form-control mr-sm-2 mb-sm-0" type="search" name="DNI" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" maxlength="9" placeholder="dni del cliente" required aria-label="Search">
                            <button class="btn my-2 my-sm-0" type="submit" style="background-color: #487317; color: white;">Buscar</button>
                        </form>    
                    </td>
                    <td class="align-middle"> <!-- Añadido -->
                        <button type="button" id="nuevo" class="btn" style="background-color: #487317; color: white;"><a href="altaUsuarioAdmin.php" style="color: white; text-decoration:none; padding: 10px 40px 10px 40px;">Añadir Usuario</a></button>
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
    <div class="col-12">
        <table class="table table-sm">
            <thead class="table-dark" style="background-color: #487317;">
                <th id="1">DNI</th>
                <th id="2">Nombre</th>
                <th id="3">Apellidos</th>
                <th id="4">Dirección</th>
                <th id="5">Localidad</th>
                <th id="6">Provincia</th>
                <th id="7">Teléfono</th>
                <th id="8">e-mail</th>
                <th id="">rol</th>
                <th id="">Activo</th>
                <th id="9">Editar</th>
                <th id="10">Baja</th>
            </thead>
            <?php

            if (isset($order)){
                $resultados = (isset($_SESSION['resultados_busqueda'])) ? $_SESSION['resultados_busqueda'] : (new Cliente($con))->obtenerClientesOrdenados($con, $order);
                $num_total_registros = count($resultados);
                $total_paginas = ceil($num_total_registros / $PAGS);
                $result_pagina = array_slice($resultados, $inicio, $PAGS);
            }else {
                $resultados = (isset($_SESSION['resultados_busqueda'])) ? $_SESSION['resultados_busqueda'] : (new Cliente($con))->obtenerClientes();
                $num_total_registros = count($resultados);
                $total_paginas = ceil($num_total_registros / $PAGS);
                $result_pagina = array_slice($resultados, $inicio, $PAGS);
            }

            if (isset($nombre)){
                echo "<p id='p'>Se ha eliminado correctamente el cliente con nombre: " . $nombre . "</p>";
            }

            foreach($result_pagina as $cliente) { 
                echo "<tr>";
                echo "<tr><td>{$cliente["dni"]}</td>
                    <td>{$cliente["nombre"]}</td>
                    <td>{$cliente["apellidos"]}</td>
                    <td>{$cliente["direccion"]}</td>
                    <td>{$cliente["localidad"]}</td>
                    <td>{$cliente["provincia"]}</td>
                    <td>{$cliente["telefono"]}</td>
                    <td>{$cliente["email"]}</td>
                    <td>{$cliente["rol"]}</td>
                    <td class='text-center'>{$cliente["activo"]}</td>
                    <td class='editar' ><a href ='editarUsuario.php?cliente_DNI={$cliente['dni']}'><i class='far fa-edit fa-lg' style='color: #487317;'></a></td>
                    <td class='eliminar'>";
                    if ($rol == 'admin' && $dni != $cliente['dni']){
                    echo "<a href ='bajaUsuario.php?cliente_DNI={$cliente['dni']}'><i class='far fa-trash-alt fa-lg' style='color: #487317;'></a>";
                    }
                    
                echo "</td>";
                echo "</tr>";
            }
                
        ?>
        </table>
        
    </div>
</div>
<div class="container">
<div class="row">
    <div class="col text-center">
        <?php

            if ($total_paginas > 1) {
                for ($i = 1; $i <= $total_paginas; $i++) {
                    $activo = ($i == $pagina) ? "style='color: black;'" : "style='color: #487317;'";
                    echo "<a href='administrador.php?pagina=$i' $activo>$i</a> ";
                }
            }

            //echo "<br> Registros encontrados: $num_total_registros<br>";
            echo "Página $pagina de $total_paginas <p>";

        ?>
    </div>
</div>
    
<div class="row">
    <div class="col text-center">
        <section>
            <form id="mostrar" action="administrador.php" method="post">
                <input type="hidden" name="volver" value="true">
                <button class="btn" type="submit" style="background-color: #487317; color:white;">Mostrar todos los registros</button>
            </form>
        </section>
    </div>
</div>
</div>
       
        
<?php 
 include "templates/pie.php";
?>  