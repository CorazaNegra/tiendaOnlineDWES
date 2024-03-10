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

    try{

        // Consulta para obtener todas las categorías
        $stmtCategorias = $con->prepare("SELECT codigo, nombre FROM categorias");
        $stmtCategorias->execute();
        $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e){
        echo "Error: " . $e->getMessage(); 
    }

    $rolesPermitidos = ['admin', 'empleado'];

    // Verificar autenticación y roles permitidos
    verificarAutenticacion($rolesPermitidos);

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
                <option value="" disabled <?php echo (empty($res[3]) ? 'selected' : ''); ?>>Elegir categoría</option>
                <?php
                // Iterar sobre las categorías y generar las opciones del desplegable
                foreach($categorias as $categoria) {
                    echo '<option value="'.$categoria['codigo'].'" '.($res[3] == $categoria['codigo'] ? 'selected' : '').'>'.$categoria['nombre'].'</option>';
                }
                ?>
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