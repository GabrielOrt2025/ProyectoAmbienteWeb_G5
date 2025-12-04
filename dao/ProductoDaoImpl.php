<?php
require_once 'ProductoDao.php';
require_once '../Entidades/producto.php';

class ProductoDaoImpl implements ProductoDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerTodos() {
        $productos = array();
        $sql = "CALL leer_productos()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $productos[] = new producto(
                    $row['id_producto'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio'],
                    $row['precio_descuento'],
                    $row['id_categoria'],
                    $row['stock'],
                    $row['imagen']
                );
            }
        }
        return $productos;
    }

    public function obtenerPorCategoria($id_categoria) {
        $productos = array();
        $sql = "CALL leer_productos()";
        $result = $this->conexion->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['id_categoria'] == $id_categoria) {
                    $productos[] = new producto(
                        $row['id_producto'],
                        $row['nombre'],
                        $row['descripcion'],
                        $row['precio'],
                        $row['precio_descuento'],
                        $row['id_categoria'],
                        $row['stock'],
                        $row['imagen']
                    );
                }
            }
        }
        return $productos;
    }

    public function insertar(producto $producto) {
        $stmt = $this->conexion->prepare("CALL crear_producto(?, ?, ?, ?, ?, ?, ?)");
        
        $nombre = $producto->nombre;
        $descripcion = $producto->descripcion;
        $precio = $producto->precio;
        $precio_desc = $producto->precio_descuento;
        $id_cat = $producto->id_categoria;
        $stock = $producto->stock;
        $imagen = $producto->imagen;
        
        $stmt->bind_param("ssddiis", $nombre, $descripcion, $precio, $precio_desc, $id_cat, $stock, $imagen);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function actualizar(producto $producto) {
        $stmt = $this->conexion->prepare("CALL actualizar_producto(?, ?, ?, ?, ?, ?, ?, ?)");
        
        $id = $producto->id_producto;
        $nombre = $producto->nombre;
        $descripcion = $producto->descripcion;
        $precio = $producto->precio;
        $precio_desc = $producto->precio_descuento;
        $id_cat = $producto->id_categoria;
        $stock = $producto->stock;
        $imagen = $producto->imagen;
        
        $stmt->bind_param("issddiis", $id, $nombre, $descripcion, $precio, $precio_desc, $id_cat, $stock, $imagen);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }

    public function eliminar($id_producto) {
        $stmt = $this->conexion->prepare("CALL eliminar_producto(?)");
        $stmt->bind_param("i", $id_producto);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
}
?>