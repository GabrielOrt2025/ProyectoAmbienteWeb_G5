<?php
class detalle_pedido {
    public $id_detalle;
    public $id_pedido;
    public $id_producto;
    public $nombre_producto;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;

    public function __construct($id_detalle, $id_pedido, $id_producto, $nombre_producto, $cantidad, $precio_unitario, $subtotal) {
        $this->id_detalle = $id_detalle;
        $this->id_pedido = $id_pedido;
        $this->id_producto = $id_producto;
        $this->nombre_producto = $nombre_producto;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
        $this->subtotal = $subtotal;
    }
}
