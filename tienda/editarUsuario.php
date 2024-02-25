<?php
    
    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once ("templates/cabecera.php");

    $con = conectar_pdo();

    $dni = $_GET["cliente_DNI"];
    $rol = $_SESSION['rol'];
    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

    $enlaceVolver = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';
    
    try{
    $stmt = $con->prepare("SELECT dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, rol, activo FROM usuarios WHERE dni = '$dni'");
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_NUM);
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage(); 
    }

    actualizarCliente($con);
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <form action="editarUsuario.php" method="post">
            <fieldset>
                <legend class="text-center" style="color: #487317;">Modificar datos Usuario</legend>
                
                <div class="form-group">
                    <label for="DNI">DNI: </label>
                    <input class="form-control" type="text" name="DNI" pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra" maxlength="9" required value="<?php echo $res[0] ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input class="form-control" type="text" name="nombre" required pattern="^\S.*$" maxlength="30" value="<?php echo $res[1] ?>"> 
                </div>
                
                <div class="form-group">
                    <label for="apellidos">Apellidos: </label>
                    <input class="form-control" type="text" name="apellidos" required pattern="^\S.*$" maxlength="30" value="<?php echo $res[2] ?>"> 
                </div>
                
                <div class="form-group">
                    <label for="direccion">Dirección: </label>
                    <input class="form-control" type="text" name="direccion" required pattern="^\S.*$" maxlength="50" value="<?php echo $res[3] ?>">
                </div>
                
                <div class="form-group">
                    <label for="localidad">Localidad: </label>
                    <input class="form-control" type="text" name="localidad" required pattern="^\S.*$" maxlength="30" value="<?php echo $res[4] ?>">
                </div>
                
                <div class="form-group">
                    <label for="provincia">Provincia: </label>
                    <input class="form-control" type="text" name="provincia" required pattern="^\S.*$" maxlength="30" value="<?php echo $res[5] ?>">
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono: </label>
                    <input class="form-control" class="form-control" type="text" name="telefono" pattern="[0-9]{9,15}" maxlength="9" required value="<?php echo $res[6] ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">email: </label>
                    <input class="form-control" type="email" name="email" maxlength="30" required value="<?php echo $res[7] ?>">
                </div>
                
                <?php if ($_SESSION['rol'] === 'admin') { ?>
                <!-- Permitir cambiar el rol solo si el rol de la sesión es "admin" y no es el propio usuario -->
                <?php if ($_SESSION['dni'] !== $res[0]) { ?>
                    <div class="form-group">
                        <span>Rol actual: <?php echo $res[8] ?></span>
                        <select name="rol" class="form-control" required>
                            <option value="" disabled>Seleccionar nuevo rol</option>
                            <option value="admin" <?php echo ($res[8] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="usuario" <?php echo ($res[8] === 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                            <option value="empleado" <?php echo ($res[8] === 'empleado') ? 'selected' : ''; ?>>Editor</option>
                        </select>
                    </div>
                <?php } else { ?>
                    <!-- Mostrar un campo de texto readonly si es el propio usuario -->
                    <div class="form-group">
                        <label for="rol">Rol actual: </label>
                        <input class="form-control" type="text" name="rol" value="<?php echo $res[8] ?>" readonly>
                    </div>
                <?php } ?>
                <?php } else { ?>
                    <!-- Mostrar un campo de texto readonly si no es administrador -->
                    <div class="form-group">
                        <label for="rol">Rol actual: </label>
                        <input class="form-control" type="text" name="rol" value="<?php echo $res[8] ?>" readonly>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['rol'] === 'admin') { ?>
                    <!-- Permitir cambiar el rol solo si el rol de la sesión es "admin" y no es el propio usuario -->
                    <?php if ($_SESSION['dni'] !== $res[0]) { ?>
                        <div class="form-group">
                            <label for="activo">Activo:</label>
                            <select name="activo" class="form-control" required>
                                <option value="" disabled>Usuario:</option>
                                <option value='1' <?php echo ($res[9] == 1 ? "selected" : "") ?>>Activo</option>
                                <option value='0' <?php echo ($res[9] == 0 ? "selected" : "") ?>>No Activo</option>
                            </select>
                        </div>
                    <?php } else { ?>
                        <!-- Mostrar un campo de texto readonly si es el propio usuario -->
                        <div class="form-group">
                            <label for="activo">Activo(1) / No Activo(0):</label>
                            <input class="form-control" type="text" name="activo" value="<?php echo $res[9] ?>" readonly>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <!-- Mostrar un campo de texto readonly si no es administrador -->
                    <div class="form-group">
                        <label for="activo">Activo(1) / No Activo(0):</label>
                        <input class="form-control" type="text" name="activo" value="<?php echo $res[9] ?>" readonly>
                    </div>
                <?php } ?>

                
                <div class="form-group">
                    <input type="submit" class="btn btn-block" value="Enviar" style="background-color: #487317; color: white;">
                </div>
                
                <div class="form-group">
                    <button type="button" class="btn btn-block" style="background-color: #487317;">
                        <a href="<?php echo $enlaceVolver ?>" style="text-decoration: none; color: white; padding: 10px 300px 10px 300px;">Volver</a>
                    </button>
                </div>
            </fieldset>
        </form>   
    </div>
</div>




<?php 
 include "templates/pie.php";
?>  