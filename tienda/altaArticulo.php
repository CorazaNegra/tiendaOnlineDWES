<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once ("templates/cabecera.php");

    $rol = $_SESSION['rol'];
    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

    $enlaceInicio = ($rol === 'admin') ? 'articulosAdminEditor.php' : 'articulosAdminEditor.php';
    $enlaceMisDatos = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';

    $enlaceVolver = '';

    if ($rol === 'admin') {
        $enlaceVolver = 'articulosAdminEditor.php';
    } else {
        $enlaceVolver= 'articulosAdminEditor.php';
    }

    $con = conectar_pdo();
    
    $rol =$_SESSION['rol'];
    
    $formato = "";
    $error = "";
    $fallo ="";
    $falloImg = "";
    $codigo = "";
    $nombre = "";
    $descripcion = "";
    $categoria = "";
    $precio = "";
    $imagen = "";

    // Llamar a la función para procesar el formulario
    gestionarGET('codigo', $formato);

    if ($formato){
        $error = "El código ya existe en la BBDD";
        $formato = "border: 2px solid red";
    } else {
        $error = "ej. abc12345";
    }
    gestionarGET('falloImg', $falloImg);
    gestionarGET('fallo', $fallo);
    gestionarGET('nombre', $nombre);
    gestionarGET('descripcion', $descripcion);
    gestionarGET('categoria', $categoria);
    gestionarGET('precio', $precio);
    gestionarGET('imagen', $imagen);
    gestionarGET('codigo', $codigo);

    if ($fallo == true) {
        $error = "El código introducido no es correcto";
        $formato = "border: 2px solid red";
    }

    if ($falloImg == true){
        $error = "";
        $formato = "";
    } else{
        $codigo = "";
    }

    if(isset ($_GET["mensaje"])){
        $mensaje = $_GET["mensaje"];
    }

    insertarArticulo($con);

?>

<div class="row justify-content-center mt-4">
    <div class="col text-center">
        <?php if(isset($mensaje) && $mensaje!="") { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>  
    </div>  
</div>

<div class="row justify-content-center">
    <div class="col-8">
        <form action="altaArticulo.php" method="post" enctype="multipart/form-data">
            <label for="codigo">Código:</label>
            <input class="form-control" type="text" name="codigo" required pattern="[A-Za-z]{3}\d{1,5}" title="Tres letras seguidas de hasta cinco números" style="<?php echo $formato; ?>"  placeholder="<?php echo $error; ?>" value="<?php echo $codigo; ?>">

            <label for="nombre">Nombre:</label>
            <input class="form-control" type="text" name="nombre" value="<?php echo $nombre; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" name="descripcion" required><?php echo $descripcion; ?></textarea>

            <label for="categoria">Categoría:</label>
            <select class="form-control" name="categoria" required>
                <option value="" disabled <?php echo empty($categoria) ? 'selected' : ''; ?>>Elegir categoría</option>
                <option value="1" <?php echo ($categoria == '1') ? 'selected' : ''; ?>>Plantas de Exteriro</option>
                <option value="2" <?php echo ($categoria == '2') ? 'selected' : ''; ?>>Plantas de Interior</option>
                <option value="3" <?php echo ($categoria == '3') ? 'selected' : ''; ?>>Macetas</option>
                <option value="4" <?php echo ($categoria == '4') ? 'selected' : ''; ?>>Accesorios Jardín</option>
                <option value="5" <?php echo ($categoria == '5') ? 'selected' : ''; ?>>Otros</option>
                <option value="" disabled <?php echo empty($categoria) ? 'selected' : ''; ?>>Elegir subcategoría</option>
                <option value="6" <?php echo ($categoria == '6') ? 'selected' : ''; ?>>Acuáticas</option>
                <option value="7" <?php echo ($categoria == '7') ? 'selected' : ''; ?>>Arbustos</option>
                <option value="8" <?php echo ($categoria == '8') ? 'selected' : ''; ?>>Aromáticas</option>
                <option value="9" <?php echo ($categoria == '9') ? 'selected' : ''; ?>>Bulbos</option>
                <option value="10" <?php echo ($categoria == '10') ? 'selected' : ''; ?>>Aglaonemas</option>
                <option value="11" <?php echo ($categoria == '11') ? 'selected' : ''; ?>>Alocasias</option>
                <option value="12" <?php echo ($categoria == '12') ? 'selected' : ''; ?>>Calatheas</option>
                <option value="13" <?php echo ($categoria == '13') ? 'selected' : ''; ?>>Colgantes</option>
                <option value="14" <?php echo ($categoria == '14') ? 'selected' : ''; ?>>Macetas de Barro</option>
                <option value="15" <?php echo ($categoria == '15') ? 'selected' : ''; ?>>Macetas EcoFriendly</option>
                <option value="16" <?php echo ($categoria == '16') ? 'selected' : ''; ?>>Macetas de Plástico</option>
                <option value="17" <?php echo ($categoria == '17') ? 'selected' : ''; ?>>Abono</option>
                <option value="18" <?php echo ($categoria == '18') ? 'selected' : ''; ?>>Accesorios Riego</option>
                <option value="19" <?php echo ($categoria == '19') ? 'selected' : ''; ?>>Herramientas</option>
                <option value="20" <?php echo ($categoria == '20') ? 'selected' : ''; ?>>Insecticidas</option>
            </select>

            <label for="precio">Precio:</label>
            <input class="form-control" type="text" name="precio" pattern="\d{1,9}\.\d{2}" maxlength="11" value="<?php echo $precio; ?>" required>

            <label for="imagen">Imagen:</label>
            <img src="<?php echo $imagen; ?>" alt="Imagen del Artículo"><br>
            <input type="hidden" name="imagen_actual" value="<?php echo $imagen; ?>">
            <?php
            if (isset($formato) && !empty($imagen)){
                echo '<input class="form-control" type="file" name="imagen" accept="image/jpeg, image/jpg, image/png, image/gif">';
                
            } else{
                echo '<input class="form-control" type="file" name="imagen" accept="image/jpeg, image/jpg, image/png, image/gif" required>';
                echo "<p style='color:red;'>La imagen debe tener como máximo 200x200 píxeles y 300Kb</p>";    
            }
            ?>
            <button class="btn btn-block" style="background-color: #487317; color: white;" type="submit">Registrar Artículo</button>
            <button class="btn btn-block" style="background-color: #487317;"><a href="articulos.php" style="text-decoration: none; color: white; padding: 10px 300px 10px 300px;" >Volver</a></button>
        </form>
    </div>
</div>




<?php

include "templates/pie.php";

?>