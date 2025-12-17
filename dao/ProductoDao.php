<?php
interface ProductoDAO {
    public function crearProducto(Producto $producto);
    public function leerProductos();
    public function actualizarProducto(Producto $producto);
    public function eliminarProducto($id_producto);
    
}
?>