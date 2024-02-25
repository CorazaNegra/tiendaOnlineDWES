<?php
    
    require_once ("global/seguridad.php");
    require_once("global/funciones.php");
    require_once ("templates/cabecera.php");

    $con = conectar_pdo();

    $codigo = $_GET["codigo_categoria"];
    $rol = $_SESSION['rol'];
    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';

    $enlaceVolver = ($rol === 'admin') ? 'categorias.php' : 'categorias.php';
    $enlaceMisDatos = ($rol === 'admin') ? 'indexAdmin.php' : 'indexEditor.php';

    try{
    $stmt = $con->prepare("SELECT * FROM categorias WHERE codigo = '$codigo'");
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_NUM);
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage(); 
    }

    actualizarCategoria($con);
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <form action="editarCategoria.php" method="post">
            <fieldset>
                <legend class="text-center" style="color: #487317;">Modificar datos Categorías</legend>
                
                <div class="form-group">
                    <label for="codigo">Codigo: </label>
                    <input class="form-control" type="text" name="codigo"  maxlength="11" required value="<?php echo $res[0] ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input class="form-control" type="text" name="nombre" required pattern="^\S.*$" maxlength="50" value="<?php echo $res[1] ?>"> 
                </div>
                
                <div class="form-group">
                    <label for="activo">Activo:</label>
                    <select name="activo" class="form-control" required>
                        <option value="" disabled>Categoría:</option>
                        <option value='1' <?php echo ($res[2] == 1 ? "selected" : "") ?>>Activa</option>
                        <option value='0' <?php echo ($res[2] == 0 ? "selected" : "") ?>>No Activa</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="catPadre">Cod. Categoría Padre: </label>
                    <input class="form-control" type="text" name="catPadre" pattern="[0-9]+" maxlength="11" value="<?php echo $res[3] ?>"> 
                </div>
                
                <div class="form-group">
                    <input type="submit" class="btn btn-block" value="Enviar" style="background-color: #487317; color: white;">
                </div>
                
                <div class="form-group">
                    <button type="button" class="btn btn-block" style="background-color: #487317;">
                        <a href="<?php echo $enlaceVolver ?>" style="text-decoration: none; color: white; padding: 10px 270px 10px 270px;">Volver</a>
                    </button>
                </div>
            </fieldset>
        </form>   
    </div>
</div>

<?php 
 include "templates/pie.php";
?>  