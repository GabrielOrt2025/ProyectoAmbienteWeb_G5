<?php
interface CategoriaDAO {
    public function obtenerTodas();
    public function obtenerPorId($id_categoria);
    public function insertar($categoria);
    public function actualizar($categoria);
    public function eliminar($id_categoria);
}
?>