<?php
interface DetallePedidoDAO {
    public function obtenerPorPedido($id_pedido);
    public function obtenerPorId($id_detalle);
    public function insertar(DetallePedido $detalle);
    public function eliminar($id_detalle);
    public function eliminarPorPedido($id_pedido);
}
?>