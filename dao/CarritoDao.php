<?php
interface CarritoDAO {
    public function obtenerPorUsuario($id_usuario);
    public function obtenerCarritoCompleto($id_usuario);
    public function agregar($id_usuario, $id_producto, $cantidad, $precio_unitario);
    public function eliminar($id_carrito);
    public function vaciar($id_usuario);
    public function actualizarCantidad($id_carrito, $cantidad);
}
?>