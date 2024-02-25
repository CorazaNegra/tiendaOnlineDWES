<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Elimina todas las variables de sesión
    session_unset();
    
    // Destruye la sesión
    session_destroy();
    
    // Redirige a la página de inicio de sesión u otra página después de cerrar sesión
    
    header("Location: ../index.php"); 
    
?>