<?php
class Producto {
    public $id_producto;
    public $nombre;
    public $descripcion;
    public $precio;
    public $precio_descuento;
    public $id_categoria;
    public $stock;
    public $imagen;

    public function __construct($id_producto, $nombre, $descripcion, $precio, $precio_descuento, $id_categoria, $stock, $imagen) {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->precio_descuento = $precio_descuento;
        $this->id_categoria = $id_categoria;
        $this->stock = $stock;
        $this->imagen = $imagen;
    }
}
?>
