<?php
require_once 'DireccionDao.php';
require_once '../Entidades/direccion.php';

class DireccionDaoImpl implements DireccionDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerTodas() {
        $direcciones = array();
        $sql = "CALL leer_direcciones()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $direcciones[] = new direccion(
                    $row['id_direccion'],
                    $row['id_usuario'],
                    $row['calle'],
                    $row['ciudad'],
                    $row['codigo_postal'],
                    $row['pais'],
                    $row['telefono']
                );
            }
        }
        return $direcciones;
    }

    public function obtenerPorId($id_direccion) {
        $sql = "CALL leer_direcciones()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['id_direccion'] == $id_direccion) {
                    return new direccion(
                        $row['id_direccion'],
                        $row['id_usuario'],
                        $row['calle'],
                        $row['ciudad'],
                        $row['codigo_postal'],
                        $row['pais'],
                        $row['telefono']
                    );
                }
            }
        }
        return null;
    }

    public function obtenerPorUsuario($id_usuario) {
        $direcciones = array();
        $sql = "CALL leer_direcciones()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['id_usuario'] == $id_usuario) {
                    $direcciones[] = new direccion(
                        $row['id_direccion'],
                        $row['id_usuario'],
                        $row['calle'],
                        $row['ciudad'],
                        $row['codigo_postal'],
                        $row['pais'],
                        $row['telefono']
                    );
                }
            }
        }
        return $direcciones;
    }

    public function insertar(direccion $direccion) {
        $stmt = $this->conexion->prepare("CALL crear_direccion(?, ?, ?, ?, ?, ?)");
        
        $id_usuario = $direccion->id_usuario;
        $calle = $direccion->calle;
        $ciudad = $direccion->ciudad;
        $codigo = $direccion->codigo_postal;
        $pais = $direccion->pais;
        $telefono = $direccion->telefono;
        
        $stmt->bind_param("isssss", $id_usuario, $calle, $ciudad, $codigo, $pais, $telefono);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function actualizar(direccion $direccion) {
        $stmt = $this->conexion->prepare("CALL actualizar_direccion(?, ?, ?, ?, ?, ?)");
        
        $id = $direccion->id_direccion;
        $calle = $direccion->calle;
        $ciudad = $direccion->ciudad;
        $codigo = $direccion->codigo_postal;
        $pais = $direccion->pais;
        $telefono = $direccion->telefono;
        
        $stmt->bind_param("isssss", $id, $calle, $ciudad, $codigo, $pais, $telefono);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function eliminar($id_direccion) {
        $stmt = $this->conexion->prepare("CALL eliminar_direccion(?)");
        $stmt->bind_param("i", $id_direccion);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
}
?>