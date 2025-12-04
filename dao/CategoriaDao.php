<?php
interface CategoriaDAO {
    public function obtenerPorId($id_categoria);
    public function insertar(Categoria $categoria);
    public function actualizar(Categoria $categoria);
    public function eliminar($id_categoria);
}
    ?>