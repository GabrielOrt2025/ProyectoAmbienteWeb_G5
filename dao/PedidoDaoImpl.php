<?php
require_once __DIR__ . '/../DataBase/DataBase.php';
require_once __DIR__ . '/PedidoDao.php';
require_once __DIR__ . '/../Entidades/pedido.php';

class PedidoDaoImpl implements PedidoDAO {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function obtenerTodos() {
        $query = "CALL leer_pedidos()";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $pedidos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $pedidos[] = new Pedido(
                $fila['id_pedido'],
                $fila['numero_pedido'],
                $fila['id_usuario'],
                $fila['id_direccion'],
                $fila['subtotal'],
                $fila['descuento'],
                $fila['costo_envio'],
                $fila['total'],
                $fila['metodo_pago'],
                $fila['estado'],
                $fila['fecha_pedido']
            );
        }
        
        mysqli_free_result($resultado);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $pedidos;
    }

    public function obtenerPorId($id_pedido) {
        $query = "SELECT * FROM pedidos WHERE id_pedido = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_pedido);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return new Pedido(
                $fila['id_pedido'],
                $fila['numero_pedido'],
                $fila['id_usuario'],
                $fila['id_direccion'],
                $fila['subtotal'],
                $fila['descuento'],
                $fila['costo_envio'],
                $fila['total'],
                $fila['metodo_pago'],
                $fila['estado'],
                $fila['fecha_pedido']
            );
        }
        return null;
    }

    public function obtenerPorUsuario($id_usuario) {
        $query = "SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY fecha_pedido DESC";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $pedidos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $pedidos[] = new Pedido(
                $fila['id_pedido'],
                $fila['numero_pedido'],
                $fila['id_usuario'],
                $fila['id_direccion'],
                $fila['subtotal'],
                $fila['descuento'],
                $fila['costo_envio'],
                $fila['total'],
                $fila['metodo_pago'],
                $fila['estado'],
                $fila['fecha_pedido']
            );
        }
        
        return $pedidos;
    }

    public function insertar(Pedido $pedido) {
        $query = "CALL crear_pedido(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        
        $numero = $pedido->numero_pedido;
        $id_usuario = $pedido->id_usuario;
        $id_direccion = $pedido->id_direccion;
        $subtotal = $pedido->subtotal;
        $descuento = $pedido->descuento;
        $costo_envio = $pedido->costo_envio;
        $total = $pedido->total;
        $metodo = $pedido->metodo_pago;
        $estado = $pedido->estado;
        
        mysqli_stmt_bind_param($stmt, "siiddddss", 
            $numero, $id_usuario, $id_direccion, $subtotal, 
            $descuento, $costo_envio, $total, $metodo, $estado);
        
        $resultado = mysqli_stmt_execute($stmt);
        
        if ($resultado) {
            $id_insertado = mysqli_insert_id($this->conexion);
            mysqli_stmt_close($stmt);
            mysqli_next_result($this->conexion);
            return $id_insertado;
        }
        
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        return false;
    }

    public function actualizarEstado($id_pedido, $estado) {
        $query = "CALL actualizar_pedido(?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "is", $id_pedido, $estado);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }

    public function eliminar($id_pedido) {
        $query = "CALL eliminar_pedido(?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_pedido);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }
}
?>