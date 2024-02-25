<?php
    require_once("funciones.php");

    class Pedido {
        private $con;

        public function __construct($con) {
            $this->con = $con;
        }

        public function obtenerPedidos() {
            
            try {

                $query = $this->con->prepare("SELECT * FROM pedidos");
                $query->execute();
                $pedidos = $query->fetchAll(PDO::FETCH_ASSOC);

                return $pedidos;   
                
            } catch (PDOException $e) {
                die("Error al obtener pedidos: " . $e->getMessage());
            }
        }

        public function obtenerPedidosOrdenados($con, $order) {
            $stmt = $con->prepare("SELECT * FROM pedidos ORDER BY idPedido $order");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>