<?php
class categoria {
    public $id_categoria;
    public $nombre;
    public $descripcion;
    public $imagen;

    public function __construct($id_categoria, $nombre, $descripcion, $imagen) {
        $this->id_categoria = $id_categoria;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
    }
}
