<?php
    // //Inicio la sesión 
    // if (session_status() == PHP_SESSION_NONE) {
    //     session_start();
    // }
    // //COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
    // if ($_SESSION['autentificado'] != "OK") {
    // //si no existe, envío a la página de autentificación 
    // header("Location: index.php");
    // //ademas salgo de este script
    // }

?>

<?php
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Comprueba que el usuario está autenticado y tiene uno de los roles permitidos
    function verificarAutenticacion($rolesPermitidos) {
        // Comprueba si el usuario está autenticado
        if (!isset($_SESSION['autentificado']) || $_SESSION['autentificado'] !== "OK") {
            // Si no está autenticado, redirige a la página de inicio
            header("Location: index.php");
            exit; 
        }

        // Verifica si el rol del usuario está en los roles permitidos
        $rolUsuario = $_SESSION['rol'];
        if (!in_array($rolUsuario, $rolesPermitidos)) {
            // Si el rol del usuario no está en los roles permitidos, redirige a homeUsuario.php
            header("Location: homeUsuario.php");
            exit; 
        }
    }

?>
