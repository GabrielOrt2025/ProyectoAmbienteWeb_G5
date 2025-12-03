<?php
interface DireccionDAO {
    public function obtenerTodas();
    public function obtenerPorId($id_direccion);
    public function obtenerPorUsuario($id_usuario);
    public function insertar(Direccion $direccion);
    public function actualizar(Direccion $direccion);
    public function eliminar($id_direccion);
}
?>