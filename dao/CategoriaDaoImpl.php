<?php
require_once 'CategoriaDao.php';
require_once '../Entidades/categoria.php';

class CategoriaDaoImpl implements CategoriaDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPorId($id_categoria) {
        $sql = "CALL leer_categorias()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['id_categoria'] == $id_categoria) {
                    return new categoria(
                        $row['id_categoria'],
                        $row['nombre'],
                        $row['descripcion'],
                        $row['imagen']
                    );
                }
            }
        }
        return null;
    }

    public function insertar(categoria $categoria) {
        $stmt = $this->conexion->prepare("CALL crear_categoria(?, ?, ?)");
        
        $nombre = $categoria->nombre;
        $descripcion = $categoria->descripcion;
        $imagen = $categoria->imagen;
        
        $stmt->bind_param("sss", $nombre, $descripcion, $imagen);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function actualizar(categoria $categoria) {
        $stmt = $this->conexion->prepare("CALL actualizar_categoria(?, ?, ?, ?)");
        
        $id = $categoria->id_categoria;
        $nombre = $categoria->nombre;
        $descripcion = $categoria->descripcion;
        $imagen = $categoria->imagen;
        
        $stmt->bind_param("isss", $id, $nombre, $descripcion, $imagen);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function eliminar($id_categoria) {
        $stmt = $this->conexion->prepare("CALL eliminar_categoria(?)");
        $stmt->bind_param("i", $id_categoria);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
}
?>