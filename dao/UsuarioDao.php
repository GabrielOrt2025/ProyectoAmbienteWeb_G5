<?php
interface UsuarioDAO {
    public function obtenerPorId($id_usuario);
    public function insertar(Usuario $usuario);
    public function actualizar(Usuario $usuario);
    public function eliminar($id_usuario);
}
    ?>