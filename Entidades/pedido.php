<?php
class Pedido {
    public $id_pedido;
    public $numero_pedido;
    public $id_usuario;
    public $id_direccion;
    public $subtotal;
    public $descuento;
    public $costo_envio;
    public $total;
    public $metodo_pago;
    public $estado;
    public $fecha_pedido;

    public function __construct($id_pedido, $numero_pedido, $id_usuario, $id_direccion, $subtotal, $descuento, $costo_envio, $total, $metodo_pago, $estado, $fecha_pedido) {
        $this->id_pedido = $id_pedido;
        $this->numero_pedido = $numero_pedido;
        $this->id_usuario = $id_usuario;
        $this->id_direccion = $id_direccion;
        $this->subtotal = $subtotal;
        $this->descuento = $descuento;
        $this->costo_envio = $costo_envio;
        $this->total = $total;
        $this->metodo_pago = $metodo_pago;
        $this->estado = $estado;
        $this->fecha_pedido = $fecha_pedido;
    }
}
