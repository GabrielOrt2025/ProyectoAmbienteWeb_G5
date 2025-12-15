<?php
// Incluir la conexión y la interfaz
require_once __DIR__ . '/../DataBase/DataBase.php';
require_once __DIR__ . '/UsuarioDao.php';
require_once __DIR__ . '/../Entidades/Usuario.php';

class UsuarioDaoImpl implements UsuarioDAO {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function obtenerPorId($id_usuario) {
        $query = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return new Usuario(
                $fila['id_usuario'],
                $fila['nombre'],
                $fila['apellido'],
                $fila['email'],
                $fila['password'],
                $fila['telefono'],
                $fila['rol']
            );
        }
        return null;
    }

    public function obtenerPorEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return new Usuario(
                $fila['id_usuario'],
                $fila['nombre'],
                $fila['apellido'],
                $fila['email'],
                $fila['password'],
                $fila['telefono'],
                $fila['rol']
            );
        }
        return null;
    }

    public function insertar(Usuario $usuario) {
        $query = "CALL crear_usuario(?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        $email = $usuario->email;
        $passwordHash = password_hash($usuario->password, PASSWORD_DEFAULT);
        $telefono = $usuario->telefono;
        $rol = $usuario->rol;
        
        mysqli_stmt_bind_param($stmt, "ssssss", 
            $nombre, $apellido, $email, $passwordHash, $telefono, $rol);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $resultado;
    }

    public function actualizar(Usuario $usuario) {
        $query = "CALL actualizar_usuario(?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        
        $id = $usuario->id_usuario;
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        $email = $usuario->email;
        $password = $usuario->password;
        $telefono = $usuario->telefono;
        $rol = $usuario->rol;
        
        mysqli_stmt_bind_param($stmt, "issssss", 
            $id, $nombre, $apellido, $email, $password, $telefono, $rol);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $resultado;
    }

    public function eliminar($id_usuario) {
        $query = "CALL eliminar_usuario(?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $resultado;
    }

    public function validarLogin($email, $password) {
        $usuario = $this->obtenerPorEmail($email);

        if ($usuario && password_verify($password, $usuario->password)) {
            return $usuario;
        }
        return null;
    }
}
?>