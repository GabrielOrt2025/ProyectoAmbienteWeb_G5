<?php
class direccion {
    public $id_direccion;
    public $id_usuario;
    public $calle;
    public $ciudad;
    public $codigo_postal;
    public $pais;
    public $telefono;

    public function __construct($id_direccion, $id_usuario, $calle, $ciudad, $codigo_postal, $pais, $telefono) {
        $this->id_direccion = $id_direccion;
        $this->id_usuario = $id_usuario;
        $this->calle = $calle;
        $this->ciudad = $ciudad;
        $this->codigo_postal = $codigo_postal;
        $this->pais = $pais;
        $this->telefono = $telefono;
    }
}
