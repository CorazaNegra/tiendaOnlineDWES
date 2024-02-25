<?php

require_once ("global/seguridad.php");
require_once ("global/funciones.php");
require_once ("carrito.php");
require_once ("templates/cabecera.php");

$con = conectar_pdo();

?>

<div class="row">
    <div class="col">
        <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["dni"])) {

                $total=0;
                $SID=session_id();
                $dni=$_POST['dni'];

                foreach($_SESSION['CARRITO'] as $indice=>$producto) {

                    $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);
                }

                $sentencia=$con->prepare("INSERT INTO `pedidos` 
                                    (`idPedido`, `claveTransaccion`, `paypalDatos`, `fecha`, `codUsuario`, `total`, `estado`) 
                VALUES (NULL, :claveTransaccion, NULL, NOW(), :dni, :total, 'Pago pendiente'); ");
                
                $sentencia->bindParam(":claveTransaccion",$SID);
                $sentencia->bindParam(":dni",$dni);
                $sentencia->bindParam(":total",$total);
                $sentencia->execute();
                $idPedido=$con->lastInsertId();

                foreach($_SESSION['CARRITO'] as $indice=>$producto) {

                    $sentencia=$con->prepare("INSERT INTO `detallepedido` 
                        (`id`, `idPedido`, `codigoArticulo`, `precioUnitario`, `cantidad`, `estado`) 
                    VALUES (NULL, :idPedido, :codigoArticulo, :precioUnitario, :cantidad, 'Pago pendiente');");

                    $sentencia->bindParam(":idPedido",$idPedido);
                    $sentencia->bindParam(":codigoArticulo",$producto['ID']);
                    $sentencia->bindParam(":precioUnitario",$producto['PRECIO']);
                    $sentencia->bindParam(":cantidad",$producto['CANTIDAD']);
                    $sentencia->execute();

                }
                //echo "<h3>".$total. "</h3>";
            }
        ?>

        

        <div class="jumbotron text-center">
            <h1 class="display-4">!Paso Final¡</h1>
            <br>
            <hr class="my-4">
            <p class="lead"> Estas a punto de pagar con PaiPal la cantidad de:
                <h4><?php echo number_format($total,2)?>€</h4> 
                <form action="verificado.php" method="post">
                    <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>">
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <input type="hidden" name="claveTransaccion" value="<?php echo $SID; ?>">
                    <button class="btn btn-warning btn-lg btn-block btn-outline-primary"
                        name="btnAccion" 
                        type="submit" 
                        value="proceder"
                        >
                        Pagar con PaiPal >>
                    </button>
                </form>
            </p>
            <p>El pedido se empezara a procesar una vez se confirme el pago<br>
            <strong>- Para aclaraciones :vidaparacasa@vidaparacasa.com -</strong>
            </p>
        </div>
    </div>
        
</div>




<?php 
 include "templates/pie.php";
 ?>