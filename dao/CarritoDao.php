<?php
interface CarritoDAO {
    public function obtenerPorUsuario($id_usuario);
    public function agregar(CarritoItem $item);
    public function eliminar($id_carrito);
    public function vaciar($id_usuario);
}
    ?>