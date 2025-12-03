<?php
interface CodigoDescuentoDAO {
    public function obtenerTodos();
    public function obtenerPorCodigo($codigo);
    public function obtenerPorId($id_codigo);
    public function insertar(CodigoDescuento $codigo);
    public function actualizar(CodigoDescuento $codigo);
    public function eliminar($id_codigo);
}
?>