<?php
require_once 'CarritoDao.php';
require_once '../Entidades/carrito.php';

class CarritoDaoImpl implements CarritoDao {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPorUsuario($id_usuario) {
        $items = array();
        $stmt = $this->conexion->prepare("CALL leer_carrito(?)");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $items[] = new carrito(
                    $row['id_carrito'],
                    $row['id_usuario'],
                    $row['id_producto'],
                    $row['cantidad'],
                    $row['precio_unitario'],
                    $row['fecha_agregado']
                );
            }
        }
        
        $stmt->close();
        return $items;
    }

    public function agregar($id_usuario, $id_producto, $cantidad, $precio) {
        $stmt = $this->conexion->prepare("CALL agregar_carrito(?, ?, ?, ?)");
        
        $stmt->bind_param("iiid", $id_usuario, $id_producto, $cantidad, $precio);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function eliminar($id_carrito) {
        $stmt = $this->conexion->prepare("CALL eliminar_carrito(?)");
        $stmt->bind_param("i", $id_carrito);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function vaciar($id_usuario) {
        $items = $this->obtenerPorUsuario($id_usuario);
        
        foreach($items as $item) {
            $this->eliminar($item->id_carrito);
        }
        
        return true;
    }
}
?>