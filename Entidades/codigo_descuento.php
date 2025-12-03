<?php
class codigo_descuento {
    public $id_codigo;
    public $codigo;
    public $descuento;
    public $fecha_expiracion;
    public $activo;

    public function __construct($id_codigo, $codigo, $descuento, $fecha_expiracion, $activo) {
        $this->id_codigo = $id_codigo;
        $this->codigo = $codigo;
        $this->descuento = $descuento;
        $this->fecha_expiracion = $fecha_expiracion;
        $this->activo = $activo;
    }
}
