<?php
    session_start();

    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once("global/Categorias.php");
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
            $_SESSION['resultados_busqueda_categorias'] = null;
            $_POST['volver'] = false;
        }

        header("Location: categorias.php");
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

    buscarCategoria($con);
    insertarCategoria($con);
    bajaCategoria($con);
?>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <h1 style="color:#487317">Gestión de Categorías</h1>
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
                        <form class="form-inline justify-content-center" action="categorias.php" method="POST">
                            <input class="form-control mr-sm-2 mb-sm-0" type="search" name="busqueda" placeholder="Nombre categoria" required aria-label="Search">
                            <input type='hidden' name='action' value='buscar'>
                            <button class="btn my-2 my-sm-0" type="submit" style="background-color: #487317; color: white;">Buscar</button>
                        </form>    
                    </td>
                </tr>    
            </tbody>
        </table>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <h2 style="color: #487317;">Añadir Categoría</h2>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col d-flex justify-content-center">
        <form action="categorias.php" method="post" class="form-inline">
            <table>
                <tr>
                    <td class="align-middle">
                        <div class="form-group mr-2 mb-2">
                            <label for="nombre" class="my-1 mr-2">Nombre de la Categoría:</label>
                            <input type="text" class="form-control form-control-sm my-1 mr-sm-2" id="nombre" name="nombre" required>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="form-group mr-2 mb-2">
                            <label for="activo" class="my-1 mr-2">Activo:</label>
                            <select class="form-control form-control-sm my-1 mr-sm-2" id="activo" name="activo">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </td>
                    <td class="align-middle">
                        <div class="form-group mr-2 mb-2">
                            <label for="codCategoriaPadre" class="my-1 mr-2">Categoría Padre:</label>
                            <select class="form-control form-control-sm my-1 mr-sm-2 mt-2" id="codCategoriaPadre" name="codCategoriaPadre">
                                <?php 
                                    $query = "SELECT codigo, nombre FROM categorias WHERE codCategoriaPadre IS NULL";
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($categorias as $categoria) {
                                        echo "<option value='" . $categoria['codigo'] . "'>" . $categoria['nombre'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </td>
                    <td class="align-middle">
                        <button type="submit" class="btn btn-sm my-1 mr-sm-2 mb-2" style="background-color: #487317; color: white;">Guardar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>





<br>

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
                <th>Activo</th>
                <th>Cod. Cat. Padre</th>
                <th>Editar</th>
            </thead>
        <?php

            if (isset($nombre)){
                echo "<p id='p'>Se ha eliminado correctamente el artículo con nombre: " . $nombre . "</p>";
            }
            
            if (isset($order)){
                $resultados = (isset($_SESSION['resultados_busqueda_categorias'])) ? $_SESSION['resultados_busqueda_categorias'] : (new Categoria($con))->obtenerCategoriasOrdenados($con, $order);
                $num_total_registros = count($resultados);
                $total_paginas = ceil($num_total_registros / $PAGS);
                $result_pagina = array_slice($resultados, $inicio, $PAGS);
            }else {
                $resultados = (isset($_SESSION['resultados_busqueda_categorias'])) ? $_SESSION['resultados_busqueda_categorias'] : (new Categoria($con))->obtenerCategorias();
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
                echo "<td>";
                // Formulario para actualizar el estado de la categoría
                echo "<form action='categorias.php' method='post' class='form-inline'>";
                echo "<select name='activo' class='form-control-sm mr-2'>";
                echo "<option value='1' " . ($res["activo"] == 1 ? "selected" : "") . ">Activo</option>";
                echo "<option value='0' " . ($res["activo"] == 0 ? "selected" : "") . ">No Activo</option>";
                echo "</select>";
                echo "<input type='hidden' name='codigo_categoria' value='{$res['codigo']}'>";
                echo "<input type='hidden' name='nombre_categoria' value='{$res['nombre']}'>";
                echo "<button class='btn btn-sm' type='submit' style='background-color: #487317; color: white;'>Actualizar</button>";
                echo "</form>";
                echo "</td>";
                echo "<td>{$res["codCategoriaPadre"]}</td>";
                echo "<td class='text-center'><a href='editarCategoria.php?codigo_categoria={$res['codigo']}'><i class='far fa-edit fa-lg' style='color: #487317;'></a></td>";
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
                        $activo = ($i == $pagina) ? "class='activo'" : "";
                        echo "<a href='categorias.php?pagina=$i' $activo>$i</a> ";
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
                <form action="categorias.php" method="POST">
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