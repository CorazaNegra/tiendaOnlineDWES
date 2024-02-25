<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once("funciones.php");

    class Cliente {

        private $con;

        public function __construct($con) {
            $this->con = $con;
        }

        public function obtenerClientes() {

            $dni = $_SESSION['dni'];
            $rol = $_SESSION['rol'];
            
            try {

                if ($rol == "admin"){
                    $query = $this->con->prepare("SELECT * FROM usuarios");
                    $query->execute();
                    $clientes = $query->fetchAll(PDO::FETCH_ASSOC);
    
                    return $clientes;   
                    header ("Location: administrador.php");
                }
                else {

                    $query = $this->con->prepare("SELECT * FROM usuarios WHERE dni = '$dni'");
                    $query->execute();
                    $clientes = $query->fetchall(PDO::FETCH_ASSOC);
    
                    return $clientes;
                    header("Location: indexUsu.php");
                } 
                
            } catch (PDOException $e) {
                die("Error al obtener clientes: " . $e->getMessage());
            }
        }

        public function obtenerClientesOrdenados($con, $order) {
            $stmt = $con->prepare("SELECT * FROM usuarios ORDER BY nombre $order");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>