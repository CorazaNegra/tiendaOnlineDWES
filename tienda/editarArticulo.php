<?php

    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once ("templates/cabecera.php");

    $con = conectar_pdo();
    // Llamar a la función para procesar el formulario
    $codigo = $_GET['codigo_articulo'];
    $rol = $_SESSION['rol'];
    
    try{
        $stmt = $con->prepare("SELECT codigo, nombre, descripcion, categoria, precio, imagen FROM articulos WHERE codigo = '$codigo'");
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_NUM);
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage(); 
    }

    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';


    $enlaceVolver = '';

    if ($rol === 'admin') {
        $enlaceVolver = 'articulos.php';
    } else {
        $enlaceVolver = 'articulos.php';
    }
    
    actualizarArticulo($con);
?>

<div class="row justify-content-center">
    <div class="col-8">
        <form action="editarArticulo.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend class="text-center" style="color: #487317;">Modificar datos Artículos</legend>
            <label for="codigo">Código:</label>
            <input class="form-control" type="text" name="codigo" required pattern="[A-Za-z]{3}\d{1,5}" title="Tres letras seguidas de hasta cinco números" placeholder="ejm. abc12345" value="<?php echo $res[0] ?>" readonly>

            <label for="nombre">Nombre:</label>
            <input class="form-control" type="text" name="nombre" required value="<?php echo $res[1] ?>">

            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" name="descripcion" required><?php echo $res[2] ?></textarea>

            <label for="categoria">Categoría:</label>
            <select class="form-control" name="categoria" required>
                <option value="" disabled <?php echo empty($res[3]) ? 'selected' : ''; ?>>Elegir categoría</option>
                <option value="1" <?php echo ($res[3] == '1') ? 'selected' : ''; ?>>Plantas de Exteriro</option>
                <option value="2" <?php echo ($res[3] == '2') ? 'selected' : ''; ?>>Plantas de Interior</option>
                <option value="3" <?php echo ($res[3] == '3') ? 'selected' : ''; ?>>Macetas</option>
                <option value="4" <?php echo ($res[3] == '4') ? 'selected' : ''; ?>>Accesorios Jardín</option>
                <option value="5" <?php echo ($res[3] == '5') ? 'selected' : ''; ?>>Otros</option>
                <option value="" disabled <?php echo empty($categoria) ? 'selected' : ''; ?>>Elegir subcategoría</option>
                <option value="6" <?php echo ($res[3] == '6') ? 'selected' : ''; ?>>Acuáticas</option>
                <option value="7" <?php echo ($res[3] == '7') ? 'selected' : ''; ?>>Arbustos</option>
                <option value="8" <?php echo ($res[3] == '8') ? 'selected' : ''; ?>>Aromáticas</option>
                <option value="9" <?php echo ($res[3] == '9') ? 'selected' : ''; ?>>Bulbos</option>
                <option value="10" <?php echo ($res[3] == '10') ? 'selected' : ''; ?>>Aglaonemas</option>
                <option value="11" <?php echo ($res[3] == '11') ? 'selected' : ''; ?>>Alocasias</option>
                <option value="12" <?php echo ($res[3] == '12') ? 'selected' : ''; ?>>Calatheas</option>
                <option value="13" <?php echo ($res[3] == '13') ? 'selected' : ''; ?>>Colgantes</option>
                <option value="14" <?php echo ($res[3] == '14') ? 'selected' : ''; ?>>Macetas de Barro</option>
                <option value="15" <?php echo ($res[3] == '15') ? 'selected' : ''; ?>>Macetas EcoFriendly</option>
                <option value="16" <?php echo ($res[3] == '16') ? 'selected' : ''; ?>>Macetas de Plástico</option>
                <option value="17" <?php echo ($res[3] == '17') ? 'selected' : ''; ?>>Abono</option>
                <option value="18" <?php echo ($res[3] == '18') ? 'selected' : ''; ?>>Accesorios Riego</option>
                <option value="19" <?php echo ($res[3] == '19') ? 'selected' : ''; ?>>Herramientas</option>
                <option value="20" <?php echo ($res[3] == '20') ? 'selected' : ''; ?>>Insecticidas</option>
            </select>

            <label for="precio">Precio:</label>
            <input class="form-control" type="text" name="precio" pattern="\d{1,9}\.\d{2}" maxlength="11" required value="<?php echo $res[4] ?>">

            <label for="imagen">Imagen:</label>
            <img src="<?php echo $res[5] ?>" alt="Imagen del Artículo"><br>
            <input class="form-control" type="hidden" name="imagen_actual" value="<?php echo $res[5] ?>">
            <input class="form-control" type="file" name="imagen" accept="image/jpeg, image/jpg, image/png, image/gif">

            <button class="btn btn-block" style="background-color: #487317; color: white;" type="submit">Actualizar Artículo</button>
            <button class="btn btn-block" style="background-color: #487317;"><a href="<?php echo $enlaceVolver; ?>" style="text-decoration: none; color: white; padding: 10px 300px 10px 300px;">Volver</a></button>
            </fieldset>
        </form>
    </div>
</div>

<?php

include "templates/pie.php";

?>