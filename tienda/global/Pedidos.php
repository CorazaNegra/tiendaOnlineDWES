<?php
require_once("funciones.php");

class Pedido {
    private $con;
    private $rol;
    private $dni;

    public function __construct($con, $rol, $dni) {
        $this->con = $con;
        $this->rol = $rol;
        $this->dni = $dni;
    }

    public function obtenerPedidos() {

        try {
            $query = "";

            if ($this->rol === 'usuario') {
                // Si el rol es usuario, solo muestra sus propios pedidos
                $query = $this->con->prepare("SELECT * FROM pedidos WHERE codUsuario = :dni");
                $query->bindParam(':dni', $this->dni);
            } else {
                // Si el rol es admin o empleado, muestra todos los pedidos
                $query = $this->con->prepare("SELECT * FROM pedidos");
            }

            $query->execute();
            $pedidos = $query->fetchAll(PDO::FETCH_ASSOC);

            return $pedidos;

        } catch (PDOException $e) {
            die("Error al obtener pedidos: " . $e->getMessage());
        }
    }

    public function obtenerPedidosOrdenados($order) {
        try {
            $query = "";
    
            if ($this->rol === 'usuario') {
                // Si el rol es usuario, solo muestra sus propios pedidos ordenados
                $query = $this->con->prepare("SELECT * FROM pedidos WHERE codUsuario = :dni ORDER BY idPedido $order");
                $query->bindParam(':dni', $this->dni);
            } else {
                // Si el rol es admin o empleado, muestra todos los pedidos ordenados
                $query = $this->con->prepare("SELECT * FROM pedidos ORDER BY idPedido $order");
            }
    
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener pedidos ordenados: " . $e->getMessage());
        }
    }
    
}
?>
