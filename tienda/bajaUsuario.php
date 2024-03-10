<?php
    
    require_once ("global/seguridad.php");
    require_once ("global/funciones.php");
    require_once ("templates/cabecera.php");


    $rol =$_SESSION['rol'];
    $dni = $_GET["cliente_DNI"];

    $nombreUsuario = !empty($_SESSION['nombre']) ? $_SESSION['nombre'] : '';
    
    $enlaceInicio = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';
    $enlaceMisDatos = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';
    $enlaceCancelar = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';
    
    $con = conectar_pdo();

    $rolesPermitidos = ['admin', 'empleado', 'usuario'];

    // Verificar autenticación y roles permitidos
    verificarAutenticacion($rolesPermitidos);

    bajaCliente($con);

?>

<div class="row justify-content-center mt-4">
    <div class="col-8">
        <form action="bajaUsuario.php" method = "post" class="text-center">
            <p class="h2" >SE DARÁ DE BAJA al usuario con DNI: <?php echo $dni ?></p>
            <input type="hidden" name="dni" value="<?php echo $dni ?>">
            <button id="enviar" class="btn btn-block" style="background-color: #487317; color:white;" type="submit" name="confirmar">Sí, eliminar</button>
            <button id="volver" class="btn btn-danger btn-block"><a href="<?php echo $enlaceCancelar; ?>" style="text-decoration: none; color: white; padding: 10px 150px 10px 150px;">Cancelar</a></button> 
        </form>
    </div>
</div>

<?php 
 include "templates/pie.php";
?> 