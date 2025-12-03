<?php
class Usuario {
    public $id_usuario;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $rol;

    public function __construct($id_usuario, $nombre, $apellido, $email, $password, $telefono, $rol) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->telefono = $telefono;
        $this->rol = $rol;
    }
}
