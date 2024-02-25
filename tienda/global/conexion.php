<?php
 
    include_once("funciones.php");

    // Conexión con la base de datos
    if (isset($_POST['user']) && isset($_POST['key'])) {
        $usu = $_POST['user'];
        echo $usu;
        $pwd = $_POST['key'];
        echo $pwd;
        $pagar = $_POST['pagar'];
    
        // Validar el NIF antes de consultar la base de datos
        $nifValido = validarNIF($usu);

        if ($nifValido == false) {
            $fallo = true;
            header("Location: login.php?dni=$dni&fallo=$fallo"); 
            $fallo = false; 
            exit();
        }
    
        if ($nifValido === strtoupper($usu)) {
            try {
                $con = conectar_pdo();
                $query = $con->prepare("SELECT * from usuarios where dni='$usu' and activo=1");
                $query->execute();
                $resultado = $query->fetch(PDO::FETCH_ASSOC);

                if (isset($resultado)) {
                    // Verificar si la contraseña proporcionada coincide con el hash almacenado
                    if (password_verify($pwd, $resultado['clave_usuario'])) {
                        echo "Contraseña válida. Acceso concedido.";
                        
                        session_start();

                        $_SESSION['rol'] = $resultado['rol'];
                        $_SESSION['dni'] = $resultado['dni'];
                        $_SESSION['nombre'] = $resultado['nombre'];
                        $_SESSION['autentificado'] = "OK";
            
                        $rol = $resultado['rol']; // Nos determina el rol del DNI introducido, para posteriormente redireccionarlo correctamente.
            
                        if ($rol == "admin"){ 
                            if(isset($pagar)){
                                header ("Location: ../mostrarCarrito.php");
                            }else{
                                header ("Location: ../homeUsuario.php");
                            }  
                            
                        } else if ($rol == "empleado"){
                            if(isset($pagar)){
                                header ("Location: ../mostrarCarrito.php");
                            }else{
                                header ("Location: ../homeUsuario.php");
                            }
                        } else
                            if(isset($pagar)){
                                header ("Location: ../mostrarCarrito.php");
                            }else{
                                header ("Location: ../homeUsuario.php");
                            }
                    } else {
                        $mensaje="Usuario o contraseña incorrecto. Inténtelo de nuevo.";
                        echo "Contraseña incorrecta. Acceso denegado.";
                        header("Location: ../registro.php?mensaje=$mensaje");
                    }
                } else {
                    header("Location: ../registro.php");
                }
            } catch (PDOException $e) {
                    die("Error al obtener clientes: " . $e->getMessage());
            }
        }
    }
?>