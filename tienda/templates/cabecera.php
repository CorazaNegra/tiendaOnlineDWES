<?php 
ob_start();

if (isset($_SESSION['dni'])) {
    $dni= $_SESSION['dni'];
}

$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

if($rol=="admin"){
    $datos= "Datos";
    $pedidos= "Pedidos";
}else if($rol=="empleado"){
    $datos="Mis Datos";
    $pedidos= "Pedidos";
}else{
    $datos="Mis Datos";
    $pedidos="Mis Pedidos";
}

if(isset($_SESSION['update'])){
    if($_SESSION['update'] != null){
        $mensaje2 = $_SESSION['update'];
        $_SESSION['update'] = null;    
    }
}

$enlaceDatos = ($rol === 'admin') ? 'administrador.php' : 'empleadoUsuario.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <title>VidaParaCasa</title>
</head>
<body>
    <div id="contenedor"> 
        <div id="cabecera"> 
            <header>
                <nav>
                    <a href="index.php"><img src="archivos/VidaParaCasa_1.png" alt="vidaparacasa logo" width="105" height="85"></a>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Servicios</a></li>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contacto</a></li>
                        
                        <?php

                            $totalCantidad = 0;
                            

                            if(!empty($_SESSION['CARRITO'])){
                                foreach($_SESSION['CARRITO'] as $producto){
                                    $totalCantidad += $producto['CANTIDAD'];
                                }
                            } 

                            function generarListaCarrito() {
                                $totalPagar = 0;
                                $lista = '<ul>';
                                // Verificar si $_SESSION['CARRITO'] está definido y no está vacío
                                if (!empty($_SESSION['CARRITO'])) {
                                    foreach ($_SESSION['CARRITO'] as $producto) {
                                        $nombre = $producto['NOMBRE'];
                                        $cantidad = $producto['CANTIDAD'];
                                        $precio = $producto['PRECIO'];
                                        $subtotal = $cantidad * $precio;
                                        // Actualizar el valor de $totalPagar (opcional)
                                        $totalPagar += $subtotal;
                                        $lista .= "<li>$nombre - Cantidad: $cantidad </li>";
                                    }
                                } else {
                                    // Si el carrito está vacío, mostrar un mensaje indicando esto
                                    $lista .= "<li>El carrito está vacío</li>";
                                }
                                $lista .= "</ul><strong>Total a pagar: $totalPagar €</strong>";
                                return $lista;
                            }

                        ?>
                        
                        <li><a href="mostrarCarrito.php" 
                                style="text-decoration: none;" 
                                data-toggle="popover"
                                data-trigger="hover"
                                title="Cesta"
                                data-html="true"
                                data-content="Artículos: <?php echo generarListaCarrito(); ?>"
                            >
                            <i class="fas fa-shopping-basket fa-lg"></i>(<?php echo $totalCantidad; ?>)</a></li>
                        <?php
                        if (isset($_SESSION['nombre'])){

                            $nombreUsu = $_SESSION['nombre'];

                            echo "<li style='color: #487317;'?>Hola,<a href='homeUsuario.php'>".$nombreUsu."</a></li>";
                            echo "<li><a href='global/cerrarSesion.php'><i class='fas fa-door-open fa-lg'></i></a></li>";
                        }   
                        ?>
                    </ul>    
                </nav>
            </header>
            <div class="parallax">
                <img src="archivos/VidaParaCasa_2.png">
                <h1 id="vida"></h1>
            </div>
        </div> 
        <div id="cuerpo"> 
            <div id="lateral">
                <div id="menu">
                    <div class="row" style="height: 700px;">
                        <div class="col-9">
                            <ul>
                                <?php

                                $con = conectar_pdo();

                                // Consulta las categorías principales (sin categoría padre)
                                $query = "SELECT codigo, nombre FROM categorias WHERE codCategoriaPadre IS NULL AND activo = 1";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($categorias as $categoria) {
                                    echo "<li><a href='index.php?categoria=" . $categoria['codigo'] . "'>" . $categoria['nombre'] . "</a>";

                                    // Consultar las subcategorías activas para esta categoría
                                    $query_sub = "SELECT codigo, nombre FROM categorias WHERE codCategoriaPadre = :codigo_padre AND activo = 1";
                                    $stmt_sub = $con->prepare($query_sub);
                                    $stmt_sub->bindParam(':codigo_padre', $categoria['codigo']);
                                    $stmt_sub->execute();
                                    $subcategorias = $stmt_sub->fetchAll(PDO::FETCH_ASSOC);

                                    // Si hay subcategorías, las muestra en el menú desplegable
                                    if ($subcategorias) {
                                        echo "<ul style='--cantidad-items: " . count($subcategorias) . "'>";
                                        foreach ($subcategorias as $subcategoria) {
                                            echo "<li><a href='index.php?categoria=" . $subcategoria['codigo'] . "'>" . $subcategoria['nombre'] . "</a></li>";
                                        }
                                        echo "</ul>";
                                    }
                                    echo "</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>   
            </div>
        </div> 
        <div id="otrolado"> 
            <!--<img src="bannerlateral.gif" width="250" height="600" alt="">-->
            <aside>
                <section class="newsletter-fullwidth" style="height: 600px;">
                    <div class="newsletter-content">
                    <?php if (!isset($_SESSION['dni'])) { ?>
                        <h2>¿QUIÉN ERES?</h2>
                        <!--<p>Subscribe to receive updates, access to exclusive deals, and more.</p>-->
                        <form action="./global/conexion.php" method="post">
                            <label for="name">Usuario:</label>
                            <input type="text"  name="user" placeholder="Tu dni aquí" pattern="[0-9]{8}[A-Za-z]{1}" maxlength="9" required aria-required="true" autofocus>
                            <label for="email">Contraseña:</label>
                            <input type="password" name="key" placeholder="Tu contraseña aquí" required aria-required="true">
                            <br><br>
                            <button type="submit">Enviar</button>
                            
                        </form>
                        <button type="button" class="btn mt-1" style="background-color: #487317;">
                            <a href="altaUsuario.php" style="text-decoration: none; color: white;">Registrarse</a>
                        </button>
                        <a href="passwordOlvidado.php">Olvidé mi contraseña</a>
                        <br>
                        <?php if(isset($mensaje2)){ ?>
                            <div class="alert alert-success" role="alert">
                                <p><?php echo $mensaje2; ?></p>
                            </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="container">
                            <H5 style="color: #487317;">Hola, <?php echo $nombreUsu?></H5>
                            <hr>
                            <p><a href="<?php echo $enlaceDatos ?>"><?php echo $datos?></a></p>
                            <p><a href="pedidos.php"><?php echo $pedidos?></a></p>
                            
                            <?php
                                if (isset($rol) && (($rol == "admin") || ($rol == "empleado"))){
                                    echo '
                                    <p><a href="categorias.php">Categorías</a></p>
                                    <p><a href="articulos.php">Artículos</a></p>';
                                }
                            ?>
                            <hr>
                            <p><a href="global/cerrarSesion.php">Cerrar Sesión</a></p>    
                            
                        </div>
                    <?php } ?>
                    </div>
                </section>
            </aside>
        </div>

        <div id="principal"> 
            <div class="container">