<?php
require_once 'UsuarioDao.php';
require_once '../Entidades/Usuario.php';

class UsuarioDaoImpl implements UsuarioDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPorId($id_usuario) {
        $sql = "CALL leer_usuarios()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['id_usuario'] == $id_usuario) {
                    return new Usuario(
                        $row['id_usuario'],
                        $row['nombre'],
                        $row['apellido'],
                        $row['email'],
                        $row['password'],
                        $row['telefono'],
                        $row['rol']
                    );
                }
            }
        }
        return null;
    }

    public function insertar(Usuario $usuario) {
        $stmt = $this->conexion->prepare("CALL crear_usuario(?, ?, ?, ?, ?, ?)");
        
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        $email = $usuario->email;
        $password = password_hash($usuario->password, PASSWORD_DEFAULT);
        $telefono = $usuario->telefono;
        $rol = $usuario->rol;
        
        $stmt->bind_param("ssssss", $nombre, $apellido, $email, $password, $telefono, $rol);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function actualizar(Usuario $usuario) {
        $stmt = $this->conexion->prepare("CALL actualizar_usuario(?, ?, ?, ?, ?, ?, ?)");
        
        $id = $usuario->id_usuario;
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        $email = $usuario->email;
        $password = password_hash($usuario->password, PASSWORD_DEFAULT);
        $telefono = $usuario->telefono;
        $rol = $usuario->rol;
        
        $stmt->bind_param("issssss", $id, $nombre, $apellido, $email, $password, $telefono, $rol);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function eliminar($id_usuario) {
        $stmt = $this->conexion->prepare("CALL eliminar_usuario(?)");
        $stmt->bind_param("i", $id_usuario);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
}
?>