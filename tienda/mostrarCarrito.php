<?php
//include "global/config.php";
include "global/funciones.php";
include "carrito.php";
include "templates/cabecera.php";

if (isset($_SESSION['dni'])) {
    $dni= $_SESSION['dni'];
}

$pagar = "carrito";
$enlacePagar = (isset($dni)) ? "pagar.php" : "registro.php?pagar=$pagar";

if(isset ($_GET["mensaje"])){
    $mensaje = $_GET["mensaje"];
}

?>


<div class="row justify-content-center">
    <div class="col text-center">
        <?php if(isset($mensaje) && $mensaje!="") { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>  
    </div>  
</div>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <h3 style="color:#487317">Cesta de la Compra</h3>
        <hr>
    </div>
</div>

<div class="row mt-4">
    <div class="col">
        
        <?php if(!empty($_SESSION['CARRITO'])) { ?>
        <table class="table table-sm">
            <thead class="table-dark" style="background-color: #487317;">
                <tr>
                    <th width="40%">Descripción</th>
                    <th width="15%" class="text-center">Cantidad</th>
                    <th width="20%" class="text-center">Precio</th>
                    <th width="20%" class="text-center">Total</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody>

                <?php 
                
                $total=0;

                foreach($_SESSION['CARRITO'] as $indice=>$producto) {
                    
                ?>

                <tr>
                    <td width="40%"><?php echo $producto['NOMBRE'] ?></td>
                    <td width="19%" class="text-center">
                        <form action="" method="post">
                            <input 
                                type="hidden" 
                                name="ID" 
                                id="ID" 
                                value="<?php echo openssl_encrypt($producto['ID'],COD,KEY); ?>"
                            >

                            <div class="input-group">
                                <input 
                                    type="number" 
                                    name="CANTIDAD" 
                                    value="<?php echo $producto['CANTIDAD'] ?>"
                                    class="form-control form-control-sm"
                                >
                                <div class="input-group-append" style="z-index: 0;">
                                    <button 
                                        class="btn btn-sm" 
                                        type="submit"
                                        name="btnAccion"
                                        value="actualizar"
                                        style="background-color: #487317; color: white;"
                                    >Actualizar</button>
                                </div>
                            </div>

                        </form>
                    </td>
                    <td width="18%" class="text-center"><?php echo $producto['PRECIO'] ?>€</td>
                    <td width="18%" class="text-center"><?php echo number_format($producto['PRECIO']*$producto['CANTIDAD'],2); ?>€</td>
                    <td width="5%">
                        <form action="" method="post">
                            <input 
                                type="hidden" 
                                name="ID" 
                                id="ID" 
                                value="<?php echo openssl_encrypt($producto['ID'],COD,KEY); ?>"
                            >
                            <button 
                                class="btn btn-danger" 
                                type="submit"
                                name="btnAccion"
                                value="eliminar"
                            >Eliminar</button>
                        </form>
                    </td>
                </tr>

                <?php
            
                $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);

                } 
            
                ?>

            </tbody>
            <tfoot>

                <tr >
                    <td colspan="3" align="right"><h3>Total</h3></td>
                    <td align="right"><h3><?php echo number_format($total,2); ?>€</h3></td>
                    <td></td>
                </tr>

                <tr>
                <?php if (!isset($_SESSION['dni']) && isset($_SESSION['dni'])) { ?>
                    <td colspan="5">
                        <form action="pagar.php" method="post">
                            <div class="alert alert-success" role="alert"> 
                                <div class="form-group">
                                    <label for="my-input">NIF Usuario</label>
                                    <input 
                                        id="dni" 
                                        class="form-control" 
                                        type="text" 
                                        name="dni" 
                                        pattern="[0-9]{8}[A-Za-z]{1}"
                                        maxlength="9"
                                        placeholder="Por favor introduce tu dni"
                                        required
                                    >
                                </div>
                                <small 
                                    id="textHelp"
                                    class="form-text text-muted"
                                    >
                                    Los productos se enviaran a la dirección asociada.
                                </small>                    
                            </div>
                            <button class="btn btn-primary btn-lg btn-block"
                                name="btnAccion" 
                                type="submit" 
                                value="proceder"
                                >
                                Proceder a pagar >>
                            </button>
                        </form>
                    </td>
                    <?php } ?>
                </tr>

            </tfoot>
        </table>

        <?php }else{ ?>
            <div class="alert alert-success" role="alert">
                No hay productos en el carrito...
            </div>
        <?php } ?>
    </div>

</div>

<div class="row">
    <div class="col-6 text-right">
        <a href="index.php" class="btn" style="background-color: #487317; color:white">Seguir Comprando</a>
    </div>
    <div class="col-6 text-left">
        <?php if (isset($_SESSION['dni'])) { ?>
            
            <form method="post" action="pagar.php">
                <input type="hidden" name="dni" value="<?php echo $dni ?>">
                <button class="btn" type="submit" style="background-color: #487317; color:white">Realizar Pedido</button>
            </form>
        
        <?php }else{ ?>

            <a href="<?php echo $enlacePagar ?>" class="btn" style="background-color: #487317; color:white">Realizar Pedido</a>
        
        <?php } ?>
    </div>
</div>

<?php 
 include "templates/pie.php";
 ?>           