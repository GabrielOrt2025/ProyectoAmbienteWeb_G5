<?php
require_once __DIR__ . '/../DataBase/DataBase.php';
require_once __DIR__ . '/CarritoDao.php';
require_once __DIR__ . '/../Entidades/carrito.php';

class CarritoDaoImpl implements CarritoDAO {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function obtenerPorUsuario($id_usuario) {
        $query = "CALL leer_carrito(?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $items = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $items[] = new carrito(
                $fila['id_carrito'],
                $fila['id_usuario'],
                $fila['id_producto'],
                $fila['cantidad'],
                $fila['precio_unitario'],
                $fila['fecha_agregado']
            );
        }
        
        mysqli_free_result($resultado);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $items;
    }

    public function obtenerCarritoCompleto($id_usuario) {
        $query = "SELECT c.*, p.nombre, p.imagen, p.stock 
                  FROM carrito c 
                  JOIN productos p ON c.id_producto = p.id_producto 
                  WHERE c.id_usuario = ?";
        
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $items = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $items[] = [
                'id_carrito' => $fila['id_carrito'],
                'id_producto' => $fila['id_producto'],
                'nombre' => $fila['nombre'],
                'cantidad' => $fila['cantidad'],
                'precio_unitario' => $fila['precio_unitario'],
                'imagen' => $fila['imagen'],
                'stock' => $fila['stock'],
                'subtotal' => $fila['cantidad'] * $fila['precio_unitario']
            ];
        }
        
        return $items;
    }

    public function agregar($id_usuario, $id_producto, $cantidad, $precio_unitario) {
        $queryCheck = "SELECT id_carrito, cantidad FROM carrito 
                       WHERE id_usuario = ? AND id_producto = ?";
        $stmtCheck = mysqli_prepare($this->conexion, $queryCheck);
        mysqli_stmt_bind_param($stmtCheck, "ii", $id_usuario, $id_producto);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);
        
        if ($fila = mysqli_fetch_assoc($resultCheck)) {
            $nuevaCantidad = $fila['cantidad'] + $cantidad;
            $queryUpdate = "CALL actualizar_carrito(?, ?)";
            $stmtUpdate = mysqli_prepare($this->conexion, $queryUpdate);
            mysqli_stmt_bind_param($stmtUpdate, "ii", $fila['id_carrito'], $nuevaCantidad);
            $resultado = mysqli_stmt_execute($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);
            mysqli_next_result($this->conexion);
            return $resultado;
        } else {
            $query = "CALL agregar_carrito(?, ?, ?, ?)";
            $stmt = mysqli_prepare($this->conexion, $query);
            mysqli_stmt_bind_param($stmt, "iiid", $id_usuario, $id_producto, $cantidad, $precio_unitario);
            $resultado = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_next_result($this->conexion);
            return $resultado;
        }
    }

    public function eliminar($id_carrito) {
        $query = "CALL eliminar_carrito(?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_carrito);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }

    public function vaciar($id_usuario) {
        $query = "DELETE FROM carrito WHERE id_usuario = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $resultado;
    }

    public function actualizarCantidad($id_carrito, $cantidad) {
        $query = "CALL actualizar_carrito(?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ii", $id_carrito, $cantidad);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }
}
?>