<?php
require_once __DIR__ . '/../DataBase/DataBase.php';
require_once __DIR__ . '/CategoriaDao.php';
require_once __DIR__ . '/../Entidades/categoria.php';

class CategoriaDaoImpl implements CategoriaDAO {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function obtenerTodas() {
        $query = "CALL leer_categorias()";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $categorias = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $categorias[] = new categoria(
                $fila['id_categoria'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['imagen']
            );
        }
        
        mysqli_free_result($resultado);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $categorias;
    }

    public function obtenerPorId($id_categoria) {
        $query = "SELECT * FROM categorias WHERE id_categoria = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_categoria);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return new categoria(
                $fila['id_categoria'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['imagen']
            );
        }
        return null;
    }

    public function insertar($categoria) {
        $query = "CALL crear_categoria(?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        
        $nombre = $categoria->nombre;
        $descripcion = $categoria->descripcion;
        $imagen = $categoria->imagen;
        
        mysqli_stmt_bind_param($stmt, "sss", $nombre, $descripcion, $imagen);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }

    public function actualizar($categoria) {
        $query = "CALL actualizar_categoria(?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        
        $id = $categoria->id_categoria;
        $nombre = $categoria->nombre;
        $descripcion = $categoria->descripcion;
        $imagen = $categoria->imagen;
        
        mysqli_stmt_bind_param($stmt, "isss", $id, $nombre, $descripcion, $imagen);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }

    public function eliminar($id_categoria) {
        $query = "CALL eliminar_categoria(?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_categoria);
        
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $resultado;
    }
}
?>