<?php 

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $mensaje= "";

    if(isset($_POST["btnAccion"])){

        switch($_POST["btnAccion"]){

            case 'agregar':

                if(is_string(openssl_decrypt($_POST['codigo'],COD,KEY ))){
                    $ID= openssl_decrypt($_POST['codigo'],COD,KEY );
                
                    $mensaje.="Ok ID correcto ".$ID."<br>";

                }else{

                    $mensaje.="Upss... ID incorrecto ".$ID."<br>";
                    break;
                }

                if(is_string(openssl_decrypt($_POST['nombre'],COD,KEY ))){
                    $NOMBRE= openssl_decrypt($_POST['nombre'],COD,KEY );
                
                    $mensaje.="Ok NOMBRE correcto ".$NOMBRE."<br>";

                }else{

                    $mensaje.="Upss... NOMBRE incorrecto ".$NOMBRE."<br>";
                    break;
                }

                if(is_numeric(openssl_decrypt($_POST['precio'],COD,KEY ))){
                    $PRECIO= openssl_decrypt($_POST['precio'],COD,KEY );
                
                    $mensaje.="Ok PRECIO correcto ".$PRECIO."<br>";

                }else{

                    $mensaje.="Upss... PRECIO incorrecto ".$PRECIO."<br>";
                    break;
                }

                if(is_numeric(openssl_decrypt($_POST['cantidad'],COD,KEY ))){
                    $CANTIDAD= openssl_decrypt($_POST['cantidad'],COD,KEY );
                
                    $mensaje.="Ok CANTIDAD correcto ".$CANTIDAD."<br>";

                }else{

                    $mensaje.="Upss... CANTIDAD incorrecto ".$CANTIDAD."<br>";
                    break;
                }

                if(!isset($_SESSION['CARRITO'])){

                    $producto=array(
                        'ID'=>$ID,
                        'NOMBRE'=>$NOMBRE,
                        'PRECIO'=>$PRECIO,
                        'CANTIDAD'=>$CANTIDAD
                    );

                    $_SESSION['CARRITO'][0]=$producto;
                    $mensaje= "Producto agregado al carrito";

                }else{

                    $idProductos=array_column($_SESSION['CARRITO'], 'ID');

                    if(in_array($ID,$idProductos)){

                        foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                            if ($producto['ID'] == $ID) {
                                $_SESSION['CARRITO'][$indice]["CANTIDAD"] += 1;
                                $mensaje = "Producto agregado al carrito";
                                break;
                            }
                        }
                        

                    }else{

                        $numeroProductos=count($_SESSION['CARRITO']);
                        $producto=array(
                            'ID'=>$ID,
                            'NOMBRE'=>$NOMBRE,
                            'PRECIO'=>$PRECIO,
                            'CANTIDAD'=>$CANTIDAD
                        );

                        $_SESSION['CARRITO'][$numeroProductos]=$producto;
                        $mensaje= "Producto agregado al carrito";
                    }

                }

                //$mensaje= print_r($_SESSION,true);
                

            break;

            case 'eliminar':

                if(is_string(openssl_decrypt($_POST['ID'],COD,KEY ))){
                    $ID= openssl_decrypt($_POST['ID'],COD,KEY );
                
                    foreach($_SESSION['CARRITO'] as $indice=>$producto) {
                        if($producto['ID']==$ID){
                            unset($_SESSION['CARRITO'][$indice]);
                            echo "<script>alert('Elemento borrado...);</script>";
                        }
                    }

                }else{

                    $mensaje.="Upss... ID incorrecto ".$ID."<br>";
                    break;
                }
            
            break;

            case 'actualizar':
                if(is_string(openssl_decrypt($_POST['ID'],COD,KEY ))){
                    $ID= openssl_decrypt($_POST['ID'],COD,KEY );
                    $CANTIDAD = $_POST['CANTIDAD']; 
            
                    foreach($_SESSION['CARRITO'] as $indice=>$producto) {
                        if($producto['ID']==$ID){
                            $_SESSION['CARRITO'][$indice]['CANTIDAD'] = $CANTIDAD;
                            $mensaje = "Cantidad actualizada";
                            break;
                        }
                    }
                }else{
                    $mensaje.="Upss... ID incorrecto ".$ID."<br>";
                    break;
                }
            break;
            
        }

    }



?>