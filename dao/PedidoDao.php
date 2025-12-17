<?php
interface PedidoDAO {
    public function obtenerTodos();
    public function obtenerPorId($id_pedido);
    public function obtenerPorUsuario($id_usuario);
    public function insertar(Pedido $pedido);
    public function actualizarEstado($id_pedido, $estado);
    public function eliminar($id_pedido);
}
?>