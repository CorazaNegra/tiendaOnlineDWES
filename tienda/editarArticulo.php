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

        // Consulta para obtener todas las categorías
        $stmtCategorias = $con->prepare("SELECT codigo, nombre FROM categorias");
        $stmtCategorias->execute();
        $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

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

    $rolesPermitidos = ['admin', 'empleado'];

    // Verificar autenticación y roles permitidos
    verificarAutenticacion($rolesPermitidos);
    
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
                <option value="" disabled <?php echo (empty($res[3]) ? 'selected' : ''); ?>>Elegir categoría</option>
                <?php
                // Iterar sobre las categorías y generar las opciones del desplegable
                foreach($categorias as $categoria) {
                    echo '<option value="'.$categoria['codigo'].'" '.($res[3] == $categoria['codigo'] ? 'selected' : '').'>'.$categoria['nombre'].'</option>';
                }
                ?>
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