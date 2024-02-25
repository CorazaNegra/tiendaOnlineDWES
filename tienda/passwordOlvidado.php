<?php 

require_once("global/funciones.php");
require_once ("carrito.php");
require_once ("templates/cabecera.php");

if(isset ($_GET["mensaje"])){
    $mensaje = $_GET["mensaje"];
}

$con = conectar_pdo();
comprobarUsuEmail($con);

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
        <form action="passwordOlvidado.php" method="post"> 
            <fieldset>
                <legend class="text-center" style="color: #487317;">Recuperar Contraseña</legend>
            
                
                <label for="DNI">Usuario: </label>
                <input class="form-control" type="text" name="DNI" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" placeholder="Introduzca dni" maxlength="9" required >
                
                <label for="email">email: </label>
                <input class="form-control" type="email" name="email" placeholder="Introduzca email" maxlength="30" required>
                
                <br>

                <div class="form-group">
                    <input type="submit" class="btn btn-block" value="Recuperar" style="background-color: #487317; color: white;">
                </div>
                
                <div class="form-group">
                    <button type="button" class="btn btn-block" style="background-color: #487317;">
                        <a href="registro.php" style="text-decoration: none; color: white; padding: 10px 200px 10px 200px;">Volver</a>
                    </button>
                </div>
          
            </fieldset>   
        </form>  
    </div>
</div>

<?php 
 include "templates/pie.php";
?> 