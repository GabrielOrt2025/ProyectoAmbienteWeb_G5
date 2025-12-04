<?php
interface CarritoDao {
    public function obtenerPorUsuario($id_usuario);
    public function agregar($id_usuario, $id_producto, $cantidad, $precio);
    public function eliminar($id_carrito);
    public function vaciar($id_usuario);
}
?>
