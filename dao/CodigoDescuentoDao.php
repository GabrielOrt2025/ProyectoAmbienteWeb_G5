<?php
interface CodigoDescuentoDAO {
    public function obtenerTodos();
    public function obtenerPorCodigo($codigo);
    public function obtenerPorId($id_codigo);
    public function insertar(Codigo_Descuento $codigo);
    public function actualizar(Codigo_Descuento $codigo);
    public function eliminar($id_codigo);
}
?>
