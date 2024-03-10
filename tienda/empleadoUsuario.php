<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once ("global/seguridad.php");
require_once ("global/funciones.php");
require_once ("global/Cliente.php");
require_once ("templates/cabecera.php");

$dni= $_SESSION['dni'];
$rol= $_SESSION['rol'];
$nombreUsuario = $_SESSION['nombre'];

$enlaceVolver = ($rol === 'empleado') ? 'homeUsuario.php' : 'homeUsuario.php';
//$enlaceMisDatos = ($rol === '') ? 'indexAdmin.php' : 'indexEditor.php';

if(isset ($_GET["nombre"])){
    $nombre = $_GET["nombre"];
} 

if(isset ($_GET["mensaje"])){
    $mensaje = $_GET["mensaje"];
}

$rolesPermitidos = ['admin', 'empleado', 'usuario'];

// Verificar autenticación y roles permitidos
verificarAutenticacion($rolesPermitidos);

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
<div class="row justify-content-center">
    <div class="col">
        <h1 class="text-center" style="color:#487317">Mis Datos</h1>
        <hr>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col">
        <table class="table table-sm">
            <thead class="table-dark" style="background-color: #487317;">
                <th id="1">DNI</th>
                <th id="2">Nombre</th>
                <th id="3">Apellidos</th>
                <th id="4">Dirección</th>
                <th id="5">Localidad</th>
                <th id="6">Provincia</th>
                <th id="7">Teléfono</th>
                <th id="8">e-mail</th>
                <th id="9">Editar</th>
                <th id="10">Baja</th>
            </thead>

            <?php
                $con = conectar_pdo();

                $cliente = new Cliente ($con);
                $clientes = $cliente->obtenerClientes($dni);

                if (isset($nombre)){
                    echo "<p id='p'>Se ha eliminado correctamente el cliente con nombre: " . $nombre . "</p>";
                }

                foreach($clientes as $cliente) { 
                    echo "<tr>";
                    echo "<tr><td>{$cliente["dni"]}</td>
                        <td>{$cliente["nombre"]}</td>
                        <td>{$cliente["apellidos"]}</td>
                        <td>{$cliente["direccion"]}</td>
                        <td>{$cliente["localidad"]}</td>
                        <td>{$cliente["provincia"]}</td>
                        <td>{$cliente["telefono"]}</td>
                        <td>{$cliente["email"]}</td>
                        <td class='editar' ><a href ='editarUsuario.php?cliente_DNI={$cliente['dni']}'><i class='far fa-edit fa-lg' style='color: #487317;'></i></a></td>
                        <td class='eliminar'><a href ='bajaUsuario.php?cliente_DNI={$cliente['dni']}'><i class='far fa-trash-alt fa-lg' style='color: #487317;'></i></a></td></tr>";
                    } 
            ?> 
        </table> 
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="col-8 text-center">
    <section>
        <button class="btn" style="background-color: #487317;"><a href="<?php echo $enlaceVolver; ?>" style="color: white; text-decoration: none; padding: 10px 40px 10px 40px;" >Volver</a></button>
    </section>
    </div>
</div>


<?php 
 include "templates/pie.php";
?>  