<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define("KEY","vidaparacasa");
define("COD","AES-128-ECB");

function conectar_pdo(){

    $hostname = 'localhost';
    $user_db = 'root';
    $password = '';
    $database = 'vidaparacasa';

    try {
        $con = new PDO("mysql:host=$hostname;dbname=$database", $user_db, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function cerrarSesion(){
    // Elimina todas las variables de sesión
    session_unset();
    
    // Destruye la sesión
    session_destroy();
    
    // Redirige a la página de inicio de sesión u otra página después de cerrar sesión
    header("Location: index.php");
}

function validarNIF($nif) {
    echo("NIF introducido: " . $nif);
    echo("<br>");
    
    $dni = substr($nif, 0, -1);
    $numero = intval($dni);
    
    $coleccion = array(
        0 => "T", 1 => "R", 2 => "W", 3 => "A", 4 => "G", 5 => "M", 6 => "Y", 7 => "F", 8 => "P", 9 => "D", 10 => "X", 11 => "B",
        12 => "N", 13 => "J", 14 => "Z", 15 => "S", 16 => "Q", 17 => "V", 18 => "H", 19 => "L", 20 => "C", 21 => "K", 22 => "E"
    );
    
    $resultado = $coleccion[$numero % 23];
    $letra = strtoupper(substr($nif, -1));
    
    if ($resultado == $letra) {
        return strtoupper($nif);
    } else {
        return false;
    }
}

function comprobarUsuEmail ($con){

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $dni = $_POST["DNI"];
        $email = $_POST["email"];
            
        $_SESSION['DNI'] = $dni;

        try{
            $query = $con->prepare("SELECT * from usuarios where DNI='$dni' and email='$email'");
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if ($resultado != false) {
                header("Location: passwordNuevo.php");

            } else {
                $mensaje="El usuario o el email no se encuentran en nuestra base de datos.";
                header("Location: passwordOlvidado.php?mensaje=$mensaje");
            }
        }
        catch(PDOException $e){
            die("Error de conexión: " . $e->getMessage());
        }   
    }
}

function restablecerPassword ($con){

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $dni = $_SESSION['DNI'];
        
        $clave1 = $_POST["key1"];
        $clave2 = $_POST["key2"];

        if ($clave1 == $clave2){
            try{
                
                $claveHash = password_hash($clave1, PASSWORD_DEFAULT);

                $stmt = $con->prepare("UPDATE usuarios SET clave_usuario=? WHERE DNI=?");
                $stmt->execute([$claveHash, $dni]);

                //$_SESSION['update'] = "La contraseña ha sido actualizada correcamente";
                $mensaje="La contraseña ha sido actualizada correcamente";
                header("Location: registro.php?mensaje=$mensaje");
                
            }catch(PDOException $e){
                die("Error de conexión: " . $e->getMessage());
            }
        } else{
            $mensaje="Las contraseñas no coinciden";
            header("Location: passwordNuevo.php?mensaje=$mensaje");
        }
    }
}

function gestionarGET($parametro, &$variable) {

    if(isset($_GET[$parametro])) {
        $variable = $_GET[$parametro];
    }
}

function insertarCliente($con) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $dni = $_POST["DNI"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $direccion = $_POST["direccion"];
        $localidad = $_POST["localidad"];
        $provincia = $_POST["provincia"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $clave = $_POST["clave_usuario"];

        $pagar = $_POST["pagar"];
        
        $nifValido = validarNIF($dni);

        if ($nifValido == false) {
            $fallo = true;
            header("Location: altaUsuario.php?dni=$dni&fallo=$fallo&nombre=$nombre&apellidos=$apellidos&direccion=$direccion&localidad=$localidad&provincia=$provincia&telefono=$telefono&email=$email&clave_usuario=$clave");  
            exit();
        }

        try {

            // Comprobación de DNI con consulta preparada
            $stmt = $con->prepare("SELECT * FROM usuarios WHERE dni = ?");
            $stmt->execute([$dni]);

            if ($stmt->rowCount() > 0) {

                header("Location: altaUsuario.php?dni=$dni&nombre=$nombre&apellidos=$apellidos&direccion=$direccion&localidad=$localidad&provincia=$provincia&telefono=$telefono&email=$email&clave_usuario=$clave");
            
            } else {
                // Cifrar la contraseña
                $claveHash = password_hash($clave, PASSWORD_DEFAULT);

                // Inserción de nuevo cliente con consulta preparada
                $stmtInsert = $con->prepare("INSERT INTO usuarios (dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, clave_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $res = $stmtInsert->execute([$dni, $nombre, $apellidos, $direccion, $localidad, $provincia, $telefono, $email, $claveHash]);
    
                if ($res) {
                    $mensaje = "Registro realizado correctamente, puede iniciar sesión";
                    if(isset($pagar) && $pagar == "carrito"){
                        header("Location: registro.php?alta=$mensaje&pagar=$pagar");
                        exit();
                    }else{
                        header("Location: registro.php?alta=$mensaje");
                        exit();
                    }
                    
                    
                } else {
                    header("Location: altaUsuario.php");
       
                }
            }
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

function insertarClienteAdmin($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dni = $_POST["DNI"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $direccion = $_POST["direccion"];
        $localidad = $_POST["localidad"];
        $provincia = $_POST["provincia"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $rol = $_POST["rol"];
        $clave = $_POST["clave_usuario"];
        $activo = $_POST["activo"];
        
        // Validar el NIF antes de realizar la inserción
        $nifValido = validarNIF($dni);

        if ($nifValido != strtoupper($dni)) {
            $fallo = true;
            header("Location: altaUsuarioAdmin.php?dni=$dni&fallo=$fallo&nombre=$nombre&apellidos=$apellidos&direccion=$direccion&localidad=$localidad&provincia=$provincia&telefono=$telefono&email=$email&rol=$rol&clave_usuario=$clave&activo=$activo");
            exit();
        }
        
        try {
            // Comprobación de DNI con consulta preparada
            $stmt = $con->prepare("SELECT * FROM usuarios WHERE DNI = ?");
            $stmt->execute([$dni]);

            if ($stmt->rowCount() > 0) {
                header("Location: altaUsuarioAdmin.php?dni=$dni&nombre=$nombre&apellidos=$apellidos&direccion=$direccion&localidad=$localidad&provincia=$provincia&telefono=$telefono&email=$email&rol=$rol&clave_usuario=$clave&activo=$activo");
            } else {
                // Cifrar la contraseña
                $claveHash = password_hash($clave, PASSWORD_DEFAULT);

                // Inserción de nuevo cliente con consulta preparada
                $stmtInsert = $con->prepare("INSERT INTO usuarios (dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, rol, clave_usuario, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $res = $stmtInsert->execute([$dni, $nombre, $apellidos, $direccion, $localidad, $provincia, $telefono, $email, $rol, $claveHash, $activo]);

                if ($res) {
                    $mensaje = "Registro realizado correctamente.";
                    header("Location: administrador.php?alta=$mensaje");
                    
                } else {
                    header("Location: altaUsuarioAdmin.php");
                    exit();
                }
            }
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

function insertarCategoria($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST["nombre"];
        $activo = $_POST["activo"];
        $codCategoriaPadre = $_POST["codCategoriaPadre"];

        try {
            // Preparar la consulta para insertar una nueva categoría
            $stmt = $con->prepare("INSERT INTO categorias (nombre, activo, codCategoriaPadre) VALUES (?, ?, ?)");
            // Ejecutar la consulta con los valores proporcionados
            $stmt->execute([$nombre, $activo, $codCategoriaPadre]);

            // Redirigir a alguna página después de insertar la categoría
            $mensaje="Categoría ".$nombre." insertada con éxito";
            header("Location: categorias.php?mensaje=$mensaje");
            exit(); // Importante para detener la ejecución del script después de redirigir
        } catch (PDOException $e) {
            // Manejar cualquier error de la base de datos
            echo "Error al insertar la categoría: " . $e->getMessage();
        }
    }
}

function insertarArticulo($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];

        // Verifica si se ha subido un nuevo archivo
        $imagen = $_FILES["imagen"]["name"] ?? '';
        $imagen_temp = $_FILES["imagen"]["tmp_name"] ?? '';
        $imagen_actual = $_POST['imagen_actual'] ?? '';

        try {
            $rol = $_SESSION['rol'];

            // Verifica si se ha subido un nuevo archivo
            if (!empty($imagen) && !empty($imagen_temp) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
                // Verificar las dimensiones de la imagen
                list($width, $height) = getimagesize($imagen_temp);
                if ($width > 200 || $height > 200) {
                    // Las dimensiones exceden el límite permitido
                    $mensaje = "La imagen debe tener como máximo 200x200 píxeles.";
                    $falloImg = true;
                    header("Location: altaArticulo.php?codigo=$codigo&falloImg=$falloImg&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&mensaje=$mensaje");
                    exit();
                }

                // Verificar el tamaño del archivo
                $max_size_kb = 300;
                $file_size_kb = $_FILES["imagen"]["size"] / 1024;
                if ($file_size_kb > $max_size_kb) {
                    // El tamaño del archivo excede el límite permitido
                    $mensaje = "La imagen debe tener como máximo 300 KB.";
                    $falloImg = true;
                    header("Location: altaArticulo.php?codigo=$codigo&falloImg=$falloImg&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&mensaje=$mensaje");
                    exit();
                }

                // Procesar la subida de la nueva imagen y actualizar el valor en la base de datos
                $ruta_destino = 'archivos/' . $imagen;
                move_uploaded_file($imagen_temp, $ruta_destino);
                
                $stmt = $con->prepare("SELECT * FROM articulos WHERE codigo = ?");
                $stmt->execute([$codigo]);

                if ($stmt->rowCount() > 0) {
                    header("Location: altaArticulo.php?codigo=$codigo&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&imagen=$ruta_destino");
                }

                // Validar código (tres letras y hasta cinco números)
                if (!preg_match('/^[A-Za-z]{3}\d{1,5}$/', $codigo)) {
                    $mensaje = "El código debe tener tres letras seguidas de hasta cinco números.";
                    $fallo = true;
                    header("Location: altaArticulo.php?codigo=$codigo&fallo=$fallo&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&imagen=$ruta_destino&mensaje=$mensaje");
                    
                }

                $stmt = $con->prepare("INSERT INTO articulos (codigo, nombre, descripcion, categoria, precio, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$codigo, $nombre, $descripcion, $categoria, $precio, $ruta_destino]);

                echo "<p>El artículo con Código: $codigo se ha introducido correctamonte</p>";

            } else {
                // No se ha subido un nuevo archivo, mantener la imagen existente
                $imagen = $imagen_actual;

                // Verificar las dimensiones de la imagen
                list($width, $height) = getimagesize($imagen);
                if ($width > 200 || $height > 200) {
                    // Las dimensiones exceden el límite permitido
                    $mensaje = "La imagen debe tener como máximo 200x200 píxeles.";
                    $falloImg = true;
                    header("Location: altaArticulo.php?codigo=$codigo&falloImg=$falloImg&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&mensaje=$mensaje");
                    exit();
                }

                // Verificar el tamaño del archivo
                $max_size_kb = 300;
                $file_size_kb = $_FILES["imagen"]["size"] / 1024;
                if ($file_size_kb > $max_size_kb) {
                    // El tamaño del archivo excede el límite permitido
                    $mensaje = "La imagen debe tener como máximo 300 KB.";
                    $falloImg = true;
                    header("Location: altaArticulo.php?codigo=$codigo&falloImg=$falloImg&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&mensaje=$mensaje");
                    exit();
                }

                // Procesar la subida de la nueva imagen y actualizar el valor en la base de datos
                $ruta_destino = 'uploads/' . $imagen;
                move_uploaded_file($imagen_temp, $ruta_destino);
                
                $stmt = $con->prepare("SELECT * FROM articulos WHERE codigo = ?");
                $stmt->execute([$codigo]);

                if ($stmt->rowCount() > 0) {
                    header("Location: altaArticulo.php?codigo=$codigo&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&imagen=$imagen");
                }

                // Validar código (tres letras y hasta cinco números)
                if (!preg_match('/^[A-Za-z]{3}\d{1,5}$/', $codigo)) {
                    
                    $mensaje = "El código debe tener tres letras seguidas de hasta cinco números.";
                    $fallo = true;
                    header("Location: altaArticulo.php?codigo=$codigo&fallo=$fallo&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio&imagen=$imagen&mensaje=$mensaje");
                    
                }
                
                $stmt = $con->prepare("INSERT INTO articulos (codigo, nombre, descripcion, categoria, precio, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$codigo, $nombre, $descripcion, $categoria, $precio, $imagen]);

                echo "<p>El artículo con Código: $codigo se ha introducido correctamonte</p>";
            }

            if ($rol == "admin") {
                $mensaje = "Registro del artículo ".$codigo." realizado correctamente.";
                header("Location: articulos.php?mensaje=$mensaje");
               
            } else {
                $mensaje = "Registro del artículo ".$codigo." realizado correctamente.";
                header("Location: articulos.php?mensaje=$mensaje");
                
            }
            
        } catch (PDOException $e) {
            // Manejar la excepción (puedes imprimir el mensaje o redirigir a una página de error)
            echo "Error en la actualización: " . $e->getMessage();
        }
    }
}

function procesarFormulario($con) {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Validar los campos del formulario
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];

        $errores = [];
        try {
            // Comprobación de codigo con consulta preparada
            $stmt = $con->prepare("SELECT * FROM articulos WHERE codigo = ?");
            $stmt->execute([$codigo]);

                if ($stmt->rowCount() > 0) {
                    header("Location: altaArticulo.php?codigo=$codigo&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio");
                }

                // Validar código (tres letras y hasta cinco números)
                if (!preg_match('/^[A-Za-z]{3}\d{1,5}$/', $codigo)) {
                    $fallo = true;
                    header("Location: altaArticulo.php?codigo=$codigo&fallo=$fallo&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&precio=$precio");
                    $errores[] = "El código debe tener tres letras seguidas de hasta cinco números.";
                }
            
                if (empty($nombre) || empty($descripcion) || empty($categoria) || empty($precio)) {
                    $errores[] = "Todos los campos son obligatorios.";
                }
            
                // Validar la imagen
                if (isset($_FILES['imagen'])) {

                    $imagen = $_FILES['imagen'];
                
                    // Verificar si es una imagen
                    $tipoImagen = exif_imagetype($imagen['tmp_name']);
                    if ($tipoImagen === false) {
                        $errores[] = "Error: El archivo seleccionado no es una imagen válida.";
                    }
            
                    // Verificar el tamaño de la imagen (no más de 300 KB)
                    if ($imagen['size'] > 300 * 1024) {
                        $errores[] = "Error: La imagen no debe ser mayor de 300 KB.";
                    }
            
                    // Verificar las dimensiones de la imagen (máximo 200x200)
                    list($ancho, $alto) = getimagesize($imagen['tmp_name']);
                    if ($ancho > 200 || $alto > 200) {
                        $errores[] = "Error: Las dimensiones de la imagen no deben ser mayores de 200x200.";
                    }
                } else {
                    $errores[] = "Error: Debes seleccionar una imagen.";
                }
            
                // Si no hay errores, procesar la información
                if (empty($errores)) {
                    // Carpeta donde se guardarán las imágenes
                    $carpetaDestino = 'archivos/';

                    //si no existe la carpeta de destino que la cree
                    if (!file_exists($carpetaDestino)) {
                        mkdir($carpetaDestino, 0777, true);
                    }
            
                    // Generar un nombre único para el archivo
                    $nombreArchivo = uniqid('imagen_') . '.' . pathinfo($imagen['name'], PATHINFO_EXTENSION);
            
                    // Ruta completa del archivo en el servidor
                    $rutaCompleta = $carpetaDestino . $nombreArchivo; 
            
                    // Mover el archivo al directorio de destino
                    move_uploaded_file($imagen['tmp_name'], $rutaCompleta);

                    $_SESSION['imagen'] = $rutaCompleta;
            
                    // Limpiar la variable de sesión después de la redirección
                    //unset($_SESSION['imagen']);
                    
                    // Conectar a la base de datos utilizando la función conectar_pdo
                    
                    // Guardar la información en la base de datos (supongamos que utilizas PDO)
                    $stmt = $con->prepare("INSERT INTO articulos (codigo, nombre, descripcion, categoria, precio, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$codigo, $nombre, $descripcion, $categoria, $precio, $rutaCompleta]);
            
                    // Mostrar la información del artículo
                    echo "<h2>Artículo Registrado:</h2>";
                    echo "<p>Código: $codigo</p>";
                    echo "<p>Nombre: $nombre</p>";
                    echo "<p>Descripción: $descripcion</p>";
                    echo "<p>Categoría: $categoria</p>";
                    echo "<p>Precio: $precio</p>";
                    echo "<img src='$rutaCompleta' width='200' height='200' alt='Imagen del Artículo'>";
                } else {
                    // Mostrar los errores
                    echo "<h2>Errores:</h2>";
                    foreach ($errores as $error) {
                        echo "<p>$error</p>";
                    }
                }
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } 
    }
}

function actualizarCliente1($con) {
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dni = $_POST["DNI"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $direccion = $_POST["direccion"];
        $localidad = $_POST["localidad"];
        $provincia = $_POST["provincia"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $nuevoRol = $_POST["rol"];
        $activo= $_POST["activo"];

        try {

            $rol = $_SESSION['rol'];

            // Utilizamos una consulta preparada para prevenir SQL injection
            $stmt = $con->prepare("UPDATE usuarios SET nombre=?, apellidos=?, direccion=?, localidad=?, provincia=?, telefono=?, email=?, rol=?, activo=? WHERE dni=?");
            $stmt->execute([$nombre, $apellidos, $direccion, $localidad, $provincia, $telefono, $email, $nuevoRol, $activo, $dni]);

            if ($rol === "admin") {
                // Redirigir a la página de administrador
                $mensaje="Datos del usuario con dni ".$dni. " actualizados.";
                header("Location: administrador.php?mensaje=$mensaje");
            } else {
                // Redirigir a la página de usuario
                $mensaje="Sus datos han sido actualizados correctamente.";
                header("Location: empleadoUsuario.php?mensaje=$mensaje");
            }     
        } catch (PDOException $e) {
            // Manejar la excepción (puedes imprimir el mensaje o redirigir a una página de error)
            echo "Error en la actualización: " . $e->getMessage();
        }
    }
}

function actualizarCliente($con) {
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $dni = $_POST["DNI"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $direccion = $_POST["direccion"];
        $localidad = $_POST["localidad"];
        $provincia = $_POST["provincia"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $nuevoRol = $_POST["rol"];
        $activo= $_POST["activo"];

        try {

            $rol = $_SESSION['rol'];

            // Obtenemos los valores actuales del usuario de la base de datos
            $stmt = $con->prepare("SELECT * FROM usuarios WHERE dni=?");
            $stmt->execute([$dni]);
            $usuarioActual = $stmt->fetch(PDO::FETCH_ASSOC);

            // Utilizamos una consulta preparada para prevenir SQL injection
            $stmt = $con->prepare("UPDATE usuarios SET nombre=?, apellidos=?, direccion=?, localidad=?, provincia=?, telefono=?, email=?, rol=?, activo=? WHERE dni=?");
            $stmt->execute([$nombre, $apellidos, $direccion, $localidad, $provincia, $telefono, $email, $nuevoRol, $activo, $dni]);

            // Comprobamos si sólo el valor de $activo ha cambiado
            if ($usuarioActual['nombre'] == $nombre && 
                $usuarioActual['apellidos'] == $apellidos && 
                $usuarioActual['direccion'] == $direccion && 
                $usuarioActual['localidad'] == $localidad && 
                $usuarioActual['provincia'] == $provincia && 
                $usuarioActual['telefono'] == $telefono && 
                $usuarioActual['email'] == $email && 
                $usuarioActual['rol'] == $nuevoRol && 
                $usuarioActual['activo'] != $activo) {
                // Redirige al administrador con el mensaje correspondiente
                if ($activo == 0) {
                    $mensaje = "Usuario con dni ".$dni." dado de baja con éxito";
                } else {
                    $mensaje = "Usuario con dni ".$dni." dado de alta con éxito";
                }
                header("Location: administrador.php?mensaje=$mensaje");
                exit();
            }

            if ($rol === "admin") {
                // Redirigir a la página de administrador
                $mensaje="Datos del usuario con dni ".$dni. " actualizados.";
                header("Location: administrador.php?mensaje=$mensaje");
            } else {
                // Redirigir a la página de usuario
                $mensaje="Sus datos han sido actualizados correctamente.";
                header("Location: empleadoUsuario.php?mensaje=$mensaje");
            }     
        } catch (PDOException $e) {
            // Manejar la excepción (puedes imprimir el mensaje o redirigir a una página de error)
            echo "Error en la actualización: " . $e->getMessage();
        }
    }
}

function actualizarArticulo($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $categoria = $_POST["categoria"];
        $precio = $_POST["precio"];

        // Verifica si se ha subido un nuevo archivo
        $imagen = $_FILES["imagen"]["name"] ?? '';
        $imagen_temp = $_FILES["imagen"]["tmp_name"] ?? '';
        $imagen_actual = $_POST['imagen_actual'] ?? '';

        try {
            $rol = $_SESSION['rol'];

            // Verifica si se ha subido un nuevo archivo
            if (!empty($imagen) && !empty($imagen_temp) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
                // Verificar las dimensiones de la imagen
                list($width, $height) = getimagesize($imagen_temp);
                if ($width > 200 || $height > 200) {
                    // Las dimensiones exceden el límite permitido
                    echo "La imagen debe tener como máximo 200x200 píxeles.";
                    exit;
                }

                // Verificar el tamaño del archivo
                $max_size_kb = 300;
                $file_size_kb = $_FILES["imagen"]["size"] / 1024;
                if ($file_size_kb > $max_size_kb) {
                    // El tamaño del archivo excede el límite permitido
                    echo "La imagen debe tener como máximo 300 KB.";
                    exit;
                }

                // Procesar la subida de la nueva imagen y actualizar el valor en la base de datos
                $ruta_destino = 'archivos/' . $imagen;
                move_uploaded_file($imagen_temp, $ruta_destino);

                $stmt = $con->prepare("UPDATE articulos SET nombre=?, descripcion=?, categoria=?, precio=?, imagen=? WHERE codigo=?");
                $stmt->execute([$nombre, $descripcion, $categoria, $precio, $ruta_destino, $codigo]);
            } else {
                // No se ha subido un nuevo archivo, mantener la imagen existente
                $imagen = $imagen_actual;

                $stmt = $con->prepare("UPDATE articulos SET nombre=?, descripcion=?, categoria=?, precio=?, imagen=? WHERE codigo=?");
                $stmt->execute([$nombre, $descripcion, $categoria, $precio, $imagen, $codigo]);
            }

            if ($rol == "admin") {

                // Redirigir a la página de administrador
                $mensaje = "Artículo ".$codigo." actualizado con éxito";
                header("Location: articulos.php?mensaje=$mensaje");
                exit(); // Importante para detener la ejecución del script después de redirigir
                
            } else {

                // Redirigir a la página de ...
                $mensaje = "Artículo ".$codigo." actualizado con éxito";
                header("Location: articulos.php?mensaje=$mensaje");
                exit(); // Importante para detener la ejecución del script después de redirigir
               
            }
            
        } catch (PDOException $e) {
            // Manejar la excepción (puedes imprimir el mensaje o redirigir a una página de error)
            echo "Error en la actualización: " . $e->getMessage();
        }
    }
}

function actualizarPedido($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if((isset($_POST["action"]) && $_POST["action"] === "buscar") || (isset($_POST["volver"]) && $_POST["volver"] === "true")) {
            // No hacer nada si es una búsqueda
            return;
        }

        
        $codigo_pedido = $_POST["codigo_pedido"];
        $estado = $_POST["estado"];

        
        try {
            // Preparar la consulta para actualizar el estado del pedido
            $stmt = $con->prepare("UPDATE pedidos SET estado = ? WHERE idPedido = ?");
            // Ejecutar la consulta con los valores proporcionados
            $stmt->execute([$estado, $codigo_pedido]);

            // Redirigir a alguna página después de actualizar el pedido
            $mensaje = "Pedido ".$codigo_pedido." actualizado con éxito";
            header("Location: pedidos.php?mensaje=$mensaje");
            exit(); // Importante para detener la ejecución del script después de redirigir
        } catch (PDOException $e) {
            // Manejar cualquier error de la base de datos
            echo "Error al actualizar el pedido: " . $e->getMessage();
        }
        
    }
}

function actualizarCategoria($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if((isset($_POST["action"]) && $_POST["action"] === "buscar") || (isset($_POST["volver"]) && $_POST["volver"] === "true")) {
            // No hacer nada si es una búsqueda
            return;
        }
        
        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $activo = $_POST["activo"];
        $codCategoriaPadre = $_POST["catPadre"];
         
        try {
            // Preparar la consulta para actualizar el estado de la categoria
            if ($codCategoriaPadre === "") {
                // Si $codCategoriaPadre es NULL, actualizar de manera diferente
                $stmt = $con->prepare("UPDATE categorias SET nombre=?, activo=?, codCategoriaPadre=NULL WHERE codigo=?");
                $stmt->execute([$nombre, $activo, $codigo]);
            } else {
                // Si $codCategoriaPadre no es NULL, actualizar normalmente
                $stmt = $con->prepare("UPDATE categorias SET nombre=?, activo=?, codCategoriaPadre=? WHERE codigo=?");
                $stmt->execute([$nombre, $activo, $codCategoriaPadre, $codigo]);
            }

            // Redirigir a alguna página después de actualizar el pedido
            $mensaje = "Categoría ".$codigo." actualizada con éxito";
            header("Location: categorias.php?mensaje=$mensaje");
            exit(); // Importante para detener la ejecución del script después de redirigir
        } catch (PDOException $e) {
            // Manejar cualquier error de la base de datos
            echo "Error al actualizar el pedido: " . $e->getMessage();
        }
        
    }
}



function buscarClientes($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["DNI"])) {
        $dni = $_POST["DNI"];
        try {
            // Utilizar una sentencia preparada para evitar la inyección de SQL
            $stmt = $con->prepare("SELECT * FROM usuarios WHERE dni = :dni");
            $stmt->bindParam(':dni', $dni);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($result) {
                // Se encontraron resultados
                session_start(); 
                $_SESSION['resultados_busqueda'] = $result;
                header("Location: administrador.php");
                
            } else {
                $mensaje = "No se encontró al cliente con el DNI: $dni";
                header("Location: administrador.php?buscar=$mensaje");
                //echo "No se encontró al cliente con el DNI: $dni";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function buscarArticulos($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["busqueda"])) {
        $nombre = $_POST["busqueda"];
        $rol = $_SESSION['rol'];
        try {
            // Utilizar una sentencia preparada para evitar la inyección de SQL
            $stmt = $con->prepare("SELECT * FROM articulos WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($result) {
                // Se encontraron resultados
                session_start(); 
                $_SESSION['resultados_busqueda_Articulos'] = $result;
                
                if ($rol == "admin" || $rol == "empleado") {
                    // Redirigir a la página de administrador
                    header("Location: articulos.php");
                } else {
                    // Redirigir a la página de usuario
                    header("Location: articulos.php");
                }
            } else {
                if ($rol == "admin" || $rol == "empleado") {
                    // Redirigir a la página de administrador
                    $mensaje = "No se encontró el artículo con nombre: $nombre";
                    header("Location: articulos.php?buscar=$mensaje");
                } else {
                    // Redirigir a la página de usuario
                    $mensaje = "No se encontró el artículo con nombre: $nombre";
                    header("Location: articulos.php?buscar=$mensaje");
                }
                
                //echo "No se encontró el artículo con nombre: $nombre";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function buscarArticulosIndex($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["busqueda"])) {
        $nombre = $_POST["busqueda"];
        $rol = $_SESSION['rol'];
        try {
            // Utilizar una sentencia preparada para evitar la inyección de SQL
            $stmt = $con->prepare("SELECT * FROM articulos WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($result) {
                // Verificar si el artículo está activo
                if ($result[0]['activo'] == 1) {
                    // Se encontraron resultados y el artículo está activo
                    session_start(); 
                    $_SESSION['indexBusqueda'] = $result;
                    // Redirigir según el rol del usuario
                    if ($rol == "admin" || $rol == "empleado") {
                        header("Location: index.php");
                    } else {
                        header("Location: index.php");
                    }
                } else {
                    // El artículo no está activo
                    $mensaje = "El artículo '$nombre' no está disponible actualmente.";
                    header("Location: index.php?mensaje=$mensaje");
                }
            } else {
                // No se encontraron resultados
                $mensaje = "No se encontró el artículo con nombre: $nombre";
                header("Location: index.php?mensaje=$mensaje");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


function buscarCategoria($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["busqueda"])) {
        $nombre = $_POST["busqueda"];
        try {
            // Utilizar una sentencia preparada para evitar la inyección de SQL
            $stmt = $con->prepare("SELECT * FROM categorias WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($result) {
                // Se encontraron resultados
                session_start(); 
                $_SESSION['resultados_busqueda_categorias'] = $result;
                header("Location: categorias.php");
                
            } else {
                $mensaje = "No se encontró la categoria con nombre: $nombre";
                header("Location: categorias.php?buscar=$mensaje");
                //echo "No se encontró al cliente con el DNI: $dni";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function buscarPedido($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id"])) {
        $idPedido = $_POST["id"];
        try {
            // Utilizar una sentencia preparada para evitar la inyección de SQL
            $stmt = $con->prepare("SELECT * FROM pedidos WHERE idPedido = :idPedido");
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($result) {
                // Se encontraron resultados
                session_start(); 
                $_SESSION['resultados_busqueda_pedidos'] = $result;
                header("Location: pedidos.php");
                
            } else {
                $mensaje = "No se encontró el pedido con idPedido: $idPedido";
                header("Location: pedidos.php?buscar=$mensaje");
                //echo "No se encontró al cliente con el DNI: $dni";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function bajaCliente($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dni = $_POST["dni"];
        try {
            $rol = $_SESSION['rol'];

            // Verificar si el cliente que se quiere eliminar es el propio administrador
            if ($rol == "admin" && $dni == $_SESSION['dni']) {
                // Si es el propio administrador, redirigir a la página de administrador
                $mensaje="Administrador con dni ".$dni." no puede darse de baja a sí mismo.";
                header("Location: administrador.php?mensaje=$mensaje");
                return;
            }

            // Utilizar una consulta preparada para actualizar el valor de la columna activo
            $stmtUpdate = $con->prepare("UPDATE usuarios SET activo = 0 WHERE dni = ?");
            $stmtUpdate->execute([$dni]);

            // Verificar si se actualizó algún registro
            if ($stmtUpdate->rowCount() > 0) {
                // Redirigir a la página correspondiente según el rol del usuario
                if ($rol == "admin") {
                    
                    // Redirigir a la página de administrador
                    $mensaje="Efectuada la baja del usuario con dni ".$dni;
                    header("Location: administrador.php?mensaje=$mensaje");
                } else {
                    cerrarSesion();
                    // Redirigir a la página de usuario
                    $mensaje="Efectuada la baja del usuario con dni ".$dni. ". Esperamos volver a verle pronto.";
                    header("Location: index.php?mensaje=$mensaje");
                }
            } else {
                echo "No se encontró al cliente con el DNI: $dni";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function bajaArticulo($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if((isset($_POST["action"]) && $_POST["action"] === "buscar") || (isset($_POST["volver"]) && $_POST["volver"] === "true")) {
            // No hacer nada si es una búsqueda
            return;
        }

        $codigo_articulo = $_POST["codigo_articulo"];
        $activo = $_POST["activo"]; // Establecer el estado "no activo"

        try {
            // Preparar la consulta para actualizar el estado del artículo
            $stmt = $con->prepare("UPDATE articulos SET activo = ? WHERE codigo = ?");
            // Ejecutar la consulta con los valores proporcionados
            $stmt->execute([$activo, $codigo_articulo]);

            if(isset($_POST["activo"]) && $_POST["activo"] == 0){

                // Redirigir a alguna página después de realizar la baja
                $mensaje = "Artículo con código ".$codigo_articulo." dado de baja con éxito";
                header("Location: articulos.php?mensaje=$mensaje");
                exit(); // Importante para detener la ejecución del script después de redirigir

            }else{

                // Redirigir a alguna página después de realizar la baja
                $mensaje = "Artículo con código ".$codigo_articulo." dado de alta con éxito";
                header("Location: articulos.php?mensaje=$mensaje");
                exit(); // Importante para detener la ejecución del script después de redirigir

            }

            
        } catch (PDOException $e) {
            // Manejar cualquier error de la base de datos
            echo "Error al eliminar el artículo: " . $e->getMessage();
        }
    }
}

function bajaCategoria($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if((isset($_POST["action"]) && $_POST["action"] === "buscar") || (isset($_POST["volver"]) && $_POST["volver"] === "true")) {
            // No hacer nada si es una búsqueda
            return;
        }

    
        $codigo_categoria = $_POST["codigo_categoria"];
        $activo = $_POST["activo"];
        $nombre = $_POST["nombre_categoria"]; 

        try {
            // Preparar la consulta para actualizar el estado de la categoría
            $stmt = $con->prepare("UPDATE categorias SET activo = ? WHERE codigo = ?");
            // Ejecutar la consulta con los valores proporcionados
            $stmt->execute([$activo, $codigo_categoria]);

            if(isset($_POST["activo"]) && $_POST["activo"] == 0){

                // Redirigir a alguna página después de realizar la baja
                $mensaje = "Categoría con código ".$codigo_categoria." dada de baja con éxito";
                header("Location: categorias.php?mensaje=$mensaje");
                exit(); // Importante para detener la ejecución del script después de redirigir

            }else{

                // Redirigir a alguna página después de realizar la baja
                $mensaje = "Categoría con código ".$codigo_categoria." dada de alta con éxito";
                header("Location: categorias.php?mensaje=$mensaje");
                exit(); // Importante para detener la ejecución del script después de redirigir

            }
            
        } catch (PDOException $e) {
            // Manejar cualquier error de la base de datos
            echo "Error al actualizar la categoría: " . $e->getMessage();
        }
    }
}

function bajaArticulo1($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigo = $_POST["codigo"];

        try {
            $rol = $_SESSION['rol'];

            // Utilizar una consulta preparada para actualizar el valor de la columna activo
            $stmtUpdate = $con->prepare("UPDATE articulos SET activo = 0 WHERE codigo = ?");
            $stmtUpdate->execute([$codigo]);

            // Verificar si se actualizó algún registro
            if ($stmtUpdate->rowCount() > 0) {
                // Redirigir a la página correspondiente según el rol del usuario
                if ($rol == "admin") {
                    // Redirigir a la página de administrador
                    header("Location: articulos.php?codigo=$codigo");
                } else {
                    // Redirigir a la página de usuario
                    header("Location: articulos.php?codigo=$codigo");
                }
            } else {
                echo "No se encontró el artículo con el código: $codigo";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>