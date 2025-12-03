<?php
class carrito {
    public $id_carrito;
    public $id_usuario;
    public $id_producto;
    public $cantidad;
    public $precio_unitario;
    public $fecha_agregado;

    public function __construct($id_carrito, $id_usuario, $id_producto, $cantidad, $precio_unitario, $fecha_agregado) {
        $this->id_carrito = $id_carrito;
        $this->id_usuario = $id_usuario;
        $this->id_producto = $id_producto;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
        $this->fecha_agregado = $fecha_agregado;
    }
}
