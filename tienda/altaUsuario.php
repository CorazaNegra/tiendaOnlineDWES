<?php

    require_once("global/funciones.php");
    require_once ("carrito.php");
    require_once ("templates/cabecera.php");

    $con = conectar_pdo();

    $formato = "";
    $error = "";
    $fallo ="";
    $nombre = "";
    $apellidos="";
    $direccion = "";
    $localidad = "";
    $provincia = "";
    $telefono = "";
    $email = "";
    $clave = "";

    gestionarGET('dni', $formato);


    if ($formato){
        $error = "El DNI ya existe en la BBDD";
        $formato = "border: 2px solid red";
    }

    gestionarGET('fallo', $fallo);
    gestionarGET('nombre', $nombre);
    gestionarGET('nombre', $apellidos);
    gestionarGET('direccion', $direccion);
    gestionarGET('localidad', $localidad);
    gestionarGET('provincia', $provincia);
    gestionarGET('telefono', $telefono);
    gestionarGET('email', $email);
    gestionarGET('clave_usuario', $clave);

    if ($fallo == true) {
        $error = "El DNI introducido no es correcto";
        $formato = "border: 2px solid red";
    }

    if(isset($_GET['pagar'])){
        if($_GET['pagar'] != null){
            $pagar = $_GET['pagar'];
            $_GET['pagar'] = null;    
        }
    }


    insertarCliente($con);
    
?>

<div class="row justify-content-center mt-4">
    <div class="col-8">
        <form class="form-group" action="altaUsuario.php" method ="post">
            <fieldset>
                <legend class="text-center" style="color: #487317;">Alta Usuario</legend>
                
                <label for="DNI">DNI: </label>
                <input class="form-control" type="text" name="DNI" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" maxlength="9" style="<?php echo $formato; ?>"  placeholder="<?php echo $error; ?>" size="25" required >
                
                <label for="nombre">Nombre: </label>
                <input class="form-control" type="text" name="nombre" required pattern="^\S.*$" maxlength="30" value="<?php echo $nombre; ?>"> 
                
                <label for="apellidos">Apellidos: </label>
                <input class="form-control" type="text" name="apellidos" required pattern="^\S.*$" maxlength="30" value="<?php echo $apellidos; ?>"> 
                
                <label for="direccion">Dirección: </label>
                <input class="form-control" type="text" name="direccion" required pattern="^\S.*$" maxlength="50" value="<?php echo $direccion; ?>">
                
                <label for="localidad">Localidad: </label>
                <input class="form-control" type="text" name="localidad" required pattern="^\S.*$" maxlength="30" value="<?php echo $localidad; ?>">
                
                <label for="provincia">Provincia: </label>
                <input class="form-control" type="text" name="provincia" required pattern="^\S.*$" maxlength="30" value="<?php echo $provincia; ?>">
                
                <label for="telefono">Teléfono: </label>
                <input class="form-control" type="text" name="telefono" pattern="[0-9]{9}" maxlength="9" required value="<?php echo $telefono; ?>">
                
                <label for="email">email: </label>
                <input class="form-control" type="email" name="email" maxlength="30" required value="<?php echo $email; ?>">
                
                <label for="clave">Contraseña: </label>
                <input class="form-control" type="password" name="clave_usuario" required value="<?php echo $email; ?>"> 

                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-block" value="   Enviar" style="background-color: #487317; color: white;">
                </div>
             
                <input type="hidden" name="pagar" value="<?php echo $pagar ?>">

                <div class="form-group">
                    <button type="button" class="btn btn-block" style="background-color: #487317;">
                        <a href="registro.php" style="text-decoration: none; color: white; padding: 10px 300px 10px 300px;">Volver</a>
                    </button>
                </div>
            
            </fieldset>   
        </form> 
    </div>
</div>

<?php

include "templates/pie.php";

?>