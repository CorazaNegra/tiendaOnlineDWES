<?php
    require_once("funciones.php");

    class Categoria {
        private $con;

        public function __construct($con) {
            $this->con = $con;
        }

        public function obtenerCategorias() {
            
            try {

                $query = $this->con->prepare("SELECT * FROM categorias");
                $query->execute();
                $categorias = $query->fetchAll(PDO::FETCH_ASSOC);

                return $categorias;   
                
            } catch (PDOException $e) {
                die("Error al obtener categorias: " . $e->getMessage());
            }
        }

        public function obtenerCategoriasOrdenados($con, $order) {
            $stmt = $con->prepare("SELECT * FROM categorias ORDER BY nombre $order");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>