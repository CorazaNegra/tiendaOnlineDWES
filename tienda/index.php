<?php

include "global/funciones.php";
include "carrito.php";
include "templates/cabecera.php";

if(isset ($_GET["mensaje"])){
    $mensaje = $_GET["mensaje"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["volver"])) {

    if ($_POST['volver'] == true){
        $_SESSION['indexBusqueda'] = null;
        $_POST['volver'] = false;
    }

    header("Location: index.php");
    exit();
}


$PAGS = 6;
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
$inicio = ($pagina - 1) * $PAGS;

$con = conectar_pdo();

buscarArticulosIndex($con);

?>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <img id="banner" src="archivos/banner1.png" alt="vidaparacasa" style="max-width: 100%; height: auto; border-radius: 5px; margin-bottom: 20px;">
    </div>  
</div>
<div class="row">
    <div class="col table-responsive">
        <table class="table table-light">
            <tbody>
                <tr> 
                    <td class="align-middle"> <!-- Añadido -->
                        <form class="form-inline justify-content-center" action="index.php" method="POST">
                            <input class="form-control mr-sm-2 mb-sm-0" type="search" name="busqueda" placeholder="Nombre artículo" required aria-label="Search">
                            <button class="btn my-2 my-sm-0" type="submit" style="background-color: #487317; color: white;">Buscar</button>
                            <input type='hidden' name='action' value='buscar'>
                        </form>    
                    </td>
                </tr>    
            </tbody>
        </table>
    </div>
</div>

<div class="row justify-content-center mt-2">
    <div class="col text-center">
        <?php if(isset($mensaje) && $mensaje!="") { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>  
    </div>  
</div>

<div class="row mt-1">
    
        <?php

            $categoria=isset($_GET['categoria']) ? $_GET['categoria'] : null;
            $activo = 1;
            if($categoria){

                $sentencia=$con->prepare("SELECT * FROM articulos 
                        WHERE categoria IN 
                            (SELECT codigo FROM categorias 
                            WHERE (codigo = :categoria OR codCategoriaPadre = :categoria) AND activo = :activo) AND activo = :activo");
                $sentencia->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                

            }else{
                
                $sentencia=$con->prepare("SELECT * FROM articulos WHERE activo = :activo");
                
            }
            
            $sentencia->bindParam(':activo', $activo, PDO::PARAM_INT);
            $sentencia->execute();
            $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProductos);
            
            $resultados = (isset($_SESSION['indexBusqueda']) && !empty($_SESSION['indexBusqueda'])) ? $_SESSION['indexBusqueda'] : $listaProductos;
            $num_total_registros = count($resultados);
            $total_paginas = ceil($num_total_registros / $PAGS);
            $result_pagina = array_slice($resultados, $inicio, $PAGS);
        
        ?>

        <?php foreach($result_pagina as $producto){ ?>

            <div class="col-4">
                <div class="card my-2" style="width: 18rem;">
                    <img 
                    title="<?php echo $producto['nombre']; ?>"
                    class="card-img-top img-fluid" 
                    src="<?php echo $producto['imagen']; ?>" 
                    alt="Título"
                    data-toggle="popover"
                    data-trigger="hover"
                    data-content="<?php echo $producto['descripcion']; ?>"
                    style="max-height: 300px;"
                    >
                    <div class="card-body">
                        <span><?php echo $producto['nombre']; ?></span>
                        <h5 class="card-title"><?php echo $producto['precio']; ?>€</h5>
                        <!--<p class="card-text">Descripción</p>-->
                        <hr>
                        
                        <form action="" method="post">

                            <input type="hidden" name="codigo" id="codigo" value="<?php echo openssl_encrypt($producto['codigo'],COD,KEY); ?>">
                            <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['nombre'],COD,KEY); ?>">
                            <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['precio'],COD,KEY); ?>">
                            <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,KEY); ?>">

                            <button class="btn btn-success" name="btnAccion" type="submit" value="agregar">
                                Agregar al Carrito
                            </button>
                        
                        </form>
                        
                        
                    </div>
                </div>
            </div>

        <?php } ?>       
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col text-center">        
            <?php
                if ($total_paginas > 1) {
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        $activo = ($i == $pagina) ? "class='activo'" : "";
                        echo "<a href='index.php?pagina=$i' $activo>$i</a> ";
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
                <form action="index.php" method="POST">
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