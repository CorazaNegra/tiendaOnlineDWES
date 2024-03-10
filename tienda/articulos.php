<?php
    session_start();

    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once("global/Articulos.php");
    require_once ("templates/cabecera.php");

    $dni = $_SESSION['dni'];
    $rol = $_SESSION['rol'];

    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

    $con = conectar_pdo();
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

    $PAGS = 3;
    $pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
    $inicio = ($pagina - 1) * $PAGS;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["volver"])) {

        if ($_POST['volver'] == true){
            $_SESSION['resultados_busqueda_Articulos'] = null;
            $_POST['volver'] = false;
        }

        header("Location: articulos.php");
        exit();
    }

    if(isset ($_GET["nombre"])){
        $nombre = $_GET["nombre"];
    }

    if(isset($_GET['buscar'])){
        if($_GET['buscar'] != null){
            $mensaje = $_GET['buscar'];
            $_GET['buscar'] = null;    
        }
    }

    if(isset ($_GET["mensaje"])){
        $mensaje = $_GET["mensaje"];
    }

    $rolesPermitidos = ['admin', 'empleado'];

    // Verificar autenticación y roles permitidos
    verificarAutenticacion($rolesPermitidos);

    buscarArticulos($con);
    bajaArticulo($con);
    
?>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <h1 style="color:#487317">Gestión de Artículos</h1>
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
                            <label class="my-1 mr-2" for="order">Código:</label>
                            <select class="custom-select my-1 mr-sm-2" id="order" name="order">
                                <option value="asc" <?php echo ($order === 'asc') ? 'selected' : ''; ?>>Ascendente</option>
                                <option value="desc" <?php echo ($order === 'desc') ? 'selected' : ''; ?>>Descendente</option>
                            </select>
                            <button type="submit" class="btn my-1" style="background-color: #487317; color: white;">Aplicar</button>
                        </form>
                    </td>    
                    <td class="align-middle"> <!-- Añadido -->
                        <form class="form-inline justify-content-center" action="articulos.php" method="POST">
                            <input class="form-control mr-sm-2 mb-sm-0" type="search" name="busqueda" placeholder="Nombre artículo" required aria-label="Search">
                            <button class="btn my-2 my-sm-0" type="submit" style="background-color: #487317; color: white;">Buscar</button>
                            <input type='hidden' name='action' value='buscar'>
                        </form>    
                    </td>
                    <td class="align-middle"> <!-- Añadido -->
                        <button type="button" id="nuevo" class="btn" style="background-color: #487317; color: white;"><a href="altaArticulo.php" style="color: white; text-decoration:none; padding: 10px 40px 10px 40px;">Añadir Artículo</a></button>
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
    <div class="col">
        
    
    <table class="table table-sm">
        <thead class="table-dark" style="background-color: #487317;">
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Activo</th>
            <th>Editar</th>
        </thead>
        <?php

            if (isset($nombre)){
                echo "<p id='p'>Se ha eliminado correctamente el artículo con nombre: " . $nombre . "</p>";
            }
            
            if (isset($order)){
                $resultados = (isset($_SESSION['resultados_busqueda_Articulos'])) ? $_SESSION['resultados_busqueda_Articulos'] : (new Articulo($con))->obtenerArticulosOrdenados($con, $order);
                $num_total_registros = count($resultados);
                $total_paginas = ceil($num_total_registros / $PAGS);
                $result_pagina = array_slice($resultados, $inicio, $PAGS);
            }else {
                $resultados = (isset($_SESSION['resultados_busqueda_Articulos'])) ? $_SESSION['resultados_busqueda_Articulos'] : (new Articulo($con))->obtenerArticulos();
                $num_total_registros = count($resultados);
                $total_paginas = ceil($num_total_registros / $PAGS);
                $result_pagina = array_slice($resultados, $inicio, $PAGS);
            }
            
            // $resultados = (isset($_SESSION['resultados_busqueda'])) ? $_SESSION['resultados_busqueda'] : (new Articulo($con))->obtenerArticulos();
            // $num_total_registros = count($resultados);
            // $total_paginas = ceil($num_total_registros / $PAGS);
            // $result_pagina = array_slice($resultados, $inicio, $PAGS);

            foreach ($result_pagina as $res) {
                echo "<tr>";
                echo "<td>{$res["codigo"]}</td>";
                echo "<td>{$res["nombre"]}</td>";
                //echo "<td>{$res["descripcion"]}</td>";
                // Truncar la descripción a un máximo de 10 caracteres
                $descripcion = strlen($res["descripcion"]) > 10 ? substr($res["descripcion"], 0, 10) . '...' : $res["descripcion"];
                echo "<td>{$descripcion}</td>";
                echo "<td>{$res["categoria"]}</td>";
                echo "<td>{$res["precio"]}</td>";
                $imagen = $res['imagen'];
                echo "<td><img src='$imagen' width='75' height='75' alt='Imagen del Artículo'></td>";

                // Celda de la columna "Activo" con formulario para actualizar el estado
                echo "<td>";
                echo "<form action='articulos.php' method='post' class='form-inline'>";
                echo "<select name='activo' class='form-control-sm mr-2'>";
                echo "<option value='1' " . ($res["activo"] == 1 ? "selected" : "") . ">Activo</option>";
                echo "<option value='0' " . ($res["activo"] == 0 ? "selected" : "") . ">No Activo</option>";
                echo "</select>";
                echo "<input type='hidden' name='codigo_articulo' value='{$res['codigo']}'>";
                //echo "<input type='hidden' name='action' value='buscar'>";
                echo "<button class='btn btn-sm' type='submit' style='background-color: #487317; color: white;'>Actualizar</button>";
                echo "</form>";
                echo "</td>";
                //echo "<td>{$res["activo"]}</td>";
                echo "<td class='text-center' ><a href ='editarArticulo.php?codigo_articulo={$res['codigo']}'><i class='far fa-edit fa-lg' style='color: #487317;'></a></td>";
                echo "</tr>";
            }
        ?>
    
</table>
    </div>
</div>

<br>
<div class="container">
    <div class="row">
        <div class="col text-center">        
            <?php
                if ($total_paginas > 1) {
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        $activo = ($i == $pagina) ? "style='color: black;'" : "style='color: #487317;'";
                        echo "<a href='articulos.php?pagina=$i' $activo>$i</a> ";
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
                <form action="articulos.php" method="POST">
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