<?php

    require_once("global/funciones.php");
    require_once ("carrito.php");
    require_once ("templates/cabecera.php");
    
    if(isset ($_GET["mensaje"])){
        $mensaje = $_GET["mensaje"];
    }

    $con = conectar_pdo();
    restablecerPassword($con);
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
    <div class="col-6">
        <form action="passwordNuevo.php" method="post"> 
            <fieldset>
                <legend class="text-center" style="color: #487317;">Recuperar Contraseña</legend>
            
                
                <label for="DNI">Nueva Contraseña: </label>
                <input class="form-control" type="password" name="key1" placeholder="Introduzca Contraseña" required >
                
                <label for="email">Confirmar Contraseña: </label>
                <input class="form-control" type="password" name="key2" placeholder="Introduzca Contraseña" required>
                
                <br>

                <div class="form-group">
                    <input type="submit" class="btn btn-block" value="Restablecer" style="background-color: #487317; color: white;">
                </div>
                
                <div class="form-group">
                    <button type="button" class="btn btn-block" style="background-color: #487317;">
                        <a href="passwordOlvidado.php" style="text-decoration: none; color: white; padding: 10px 200px 10px 200px;">Volver</a>
                    </button>
                </div>
          
            </fieldset>   
        </form>  
    </div>
</div>

<?php 
 include "templates/pie.php";
?> 