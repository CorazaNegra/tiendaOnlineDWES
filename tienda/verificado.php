<?php
    
    require_once ("global/seguridad.php");
    require_once ("global/funciones.php");
    require_once ("carrito.php");
    require_once ("templates/cabecera.php");

    $con = conectar_pdo();

    if (isset($_SESSION['dni'])) {
        $dni= $_SESSION['dni'];
    }

    $sentencia=$con->prepare("SELECT * FROM usuarios WHERE dni= :dni");
    $sentencia->bindParam(":dni",$dni);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    /*print_r($usuario);*/
?>

<?php
ob_start();
    if(isset($_POST['idPedido']) && ($_POST['total']) && ($_POST['claveTransaccion'])) {

        
        $idPedido=$_POST['idPedido'];
        $total=$_POST['total'];
        $SID=$_POST['claveTransaccion'];
        $mensajePago="<h3>Pago aprobado por importe de: ".$total. " €</h3>";
        
        $sentencia=$con->prepare("UPDATE `pedidos` 
                SET `estado` = 'aprobado' 
                WHERE `pedidos`.`idPedido` = :idPedido;");  

        $sentencia->bindParam(":idPedido",$idPedido);
        $sentencia->execute();

        $sentencia=$con->prepare("UPDATE `pedidos` SET `estado`= 'Pago confirmado' 
                WHERE `claveTransaccion`= :claveTransaccion 
                AND `total`=:total 
                AND `idPedido`=:idPedido");

        $sentencia->bindParam(":claveTransaccion",$SID);
        $sentencia->bindParam(":total",$total);
        $sentencia->bindParam(":idPedido",$idPedido);
        $sentencia->execute();

        $completado=$sentencia->rowCount();
        
        
        if($completado){
            unset($_SESSION['CARRITO']);
        }
        

    }else{

        $mensajePago="<h3>Hay un problema con el pago</h3>";

    }

    
ob_end_flush();
?>

<div class="row mt-4">
    <div class="col">
        <div class="jumbotron text-center">
            <h1 class="display-4">¡Gracias por su compra!</h1>
            
            <hr class="my-4">
            
            <p class="lead"><?php echo $mensajePago; ?></p>

            

            <p>
                <?php

                    if($completado >= 1){

                        
                    
                        $sentencia=$con->prepare("SELECT * FROM detallepedido,articulos 
                                WHERE detallepedido.codigoArticulo=articulos.codigo 
                                AND detallepedido.idPedido=:idPedido;");

                        $sentencia->bindParam(":idPedido",$idPedido);
                        $sentencia->execute();

                        $listaArticulos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

                        /*print_r($listaArticulos);*/
                    
                    }
                
                ?>
                <div class="row justify-content-center align-items-stretch">
                    <?php foreach($listaArticulos as $producto){?>
                    <div class="col-3">
                        <div class="card h-100">
                            <img class="card-img-top img-fluid" src="<?php echo $producto['imagen']; ?>" alt="">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                            </div>
                        </div>
                        
                    </div>
                    <?php } ?>
                </div>
            </p>
            <hr class="my-4">
            <p>Los productos se enviaran a: </p>
            <ul style="list-style-type: none;">
                <li><?php echo $usuario['nombre']. " " . $usuario['apellidos']; ?></li>
                <li><?php echo $usuario['direccion']. ", " . $usuario['localidad']. ", " . $usuario['provincia']; ?></li>
                <li><?php echo $usuario['telefono']; ?></li>
            </ul>
        </div>
    </div>
</div>

<?php 
    include "templates/pie.php";
 ?>