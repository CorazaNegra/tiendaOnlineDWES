<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once ("global/seguridad.php");
require_once ("global/funciones.php");
require_once ("templates/cabecera.php");

$con = conectar_pdo();

    $dni= $_SESSION['dni'];
    $rol= $_SESSION['rol'];
    
    $nombreUsuario = $_SESSION['nombre'];
    $enlaceDatos = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';
    
    
    if($rol=="admin"){
        $datos= "Datos";
        $pedidos= "Pedidos";
    }else if($rol=="empleado"){
        $pedidos= "Pedidos";
    }else{
        $datos="Mis Datos";
        $pedidos="Mis Pedidos";
    }
    

?>


<div class="row justify-content-center mt-3">
    <div class="col-10">
        <table class="table table-light">
            <thead class="text-center">
                <tr>
                    <th colspan="2" class="display-4" style="color: #487317;">Área Personal</th> 
                </tr>
            </thead>
            
            <tbody class="text-center">
                <tr>
                    <td>
                        <form action="<?php echo $enlaceDatos ?>" method="">
                            <button class="btn btn-lg btn-block" style="background-color: #487317; color: white;" type="submit"><?php echo $datos?></button>
                        </form>
                    </td>
                    <td>
                        <form action="pedidos.php" method="">
                            <button class="btn btn-lg btn-block" style="background-color: #487317; color: white;" type="submit"><?php echo $pedidos?></button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <?php

                    if($rol!=="usuario"){
                        echo '
                        <td>
                            <form action="categorias.php" method="">
                                <button class="btn btn-lg btn-block" style="background-color: #487317; color: white;" type="submit">Categorias</button>
                            </form>
                        </td>
                        <td>
                            <form action="articulos.php" method="">
                                <button class="btn btn-lg btn-block" style="background-color: #487317; color: white;" type="submit">Artículos</button>
                            </form>
                        </td>';
                    }
                    ?>
                </tr>
            </tbody>
            <tfoot class="text-center">
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form action="index.php" method="">
                            <button class="btn btn-lg btn-block" style="background-color: #487317; color: white;" type="submit">Volver</button>
                        </form>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php 
 include "templates/pie.php";
?> 