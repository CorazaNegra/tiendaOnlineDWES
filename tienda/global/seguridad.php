<?php
    //Inicio la sesión 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
    if ($_SESSION['autentificado'] != "OK") {
    //si no existe, envío a la página de autentificación 
    header("Location: index.php");
    //ademas salgo de este script
    }
?>