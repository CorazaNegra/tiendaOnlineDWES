<?php

require_once ("global/funciones.php");
require_once ("carrito.php");
require_once ("templates/cabecera.php");

if(isset($_SESSION['update'])){
    if($_SESSION['update'] != null){
        $mensaje = $_SESSION['update'];
        $_SESSION['update'] = null;    
    }
}

if(isset($_GET['alta'])){
    if($_GET['alta'] != null){
        $mensaje = $_GET['alta'];
        $_GET['alta'] = null;    
    }


    if(isset($_GET['alta'])){
        if($_GET['alta'] != null){
            $mensaje = $_GET['alta'];
            $_GET['alta'] = null;    
        }
    }

    if (isset($_GET['fallo'])){
        if($_GET['fallo'] == true){
            $mensaje = "El DNI introducido no es correcto";
        }  
    }
}

if(isset($_GET['pagar']) ){
    $pagar = $_GET['pagar'];   
}


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

<div class="row">
    <div class="col-6">
        
            <div class="newsletter-content">
                <h3 class="display-5">Nuevo Cliente</h3>
                
                <p class="lead">¿Quieres unirte a nuestra familia?</p>
                <br>
                <p class="display-6">¡Crea una cuenta en VidaParaCasa y disfruta de compras rápidas, seguimiento de pedidos y acceso a tu historial de compras en un solo lugar! </p>
                <hr class="my-4">
                 
                <a href="altaUsuario.php?pagar=<?php echo $pagar; ?>" class="btn btn-block" style="background-color: #487317; color:white;">Registrarse</a>
            </div>
               
    </div>

    <div class="col-6">
                    
            <div class="newsletter-content">
                <h3 class="display-5">¿Quién Eres?</h3>
                <!--<p>Subscribe to receive updates, access to exclusive deals, and more.</p>-->
                <form action="global/conexion.php" method="post">
                    <label for="name">Usuario:</label>
                    <input type="text"  name="user" placeholder="Tu dni aquí" pattern="[0-9]{8}[A-Za-z]{1}" maxlength="9" required aria-required="true" autofocus>
                    <label for="email">Contraseña:</label>
                    <input type="password" name="key" placeholder="Tu contraseña aquí" required aria-required="true">
                    <?php

                        if(isset($pagar) && $pagar == "carrito"){
                            echo "<input type='hidden' name='pagar' value='<?php echo $pagar ?>''>";
                        }
                        
                    ?>
                    <br><br>
                    <button type="submit">Enviar</button>
                </form>
                <a href="passwordOlvidado.php">Olvidé mi contraseña</a>
            </div>
        
    </div>
</div>

<?php 
 include "templates/pie.php";
?>  