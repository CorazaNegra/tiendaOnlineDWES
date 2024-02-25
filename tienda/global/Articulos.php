<?php
    require_once("funciones.php");

    class Articulo {
        private $con;

        public function __construct($con) {
            $this->con = $con;
        }

        public function obtenerArticulos() {
            
            try {

                $query = $this->con->prepare("SELECT * FROM articulos");
                $query->execute();
                $articulos = $query->fetchAll(PDO::FETCH_ASSOC);

                return $articulos;   
                
            } catch (PDOException $e) {
                die("Error al obtener clientes: " . $e->getMessage());
            }
        }

        public function obtenerArticulosOrdenados($con, $order) {
            $stmt = $con->prepare("SELECT * FROM articulos ORDER BY codigo $order");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>