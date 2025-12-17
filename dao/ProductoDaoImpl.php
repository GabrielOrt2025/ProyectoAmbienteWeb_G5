
<?php
require_once __DIR__ . '/../DataBase/DataBase.php';
require_once __DIR__ . '/ProductoDao.php';
require_once __DIR__ . '/../Entidades/Producto.php';

class ProductoDaoImpl implements ProductoDao {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function crearProducto(Producto $producto) {
        $query = "CALL crear_producto(?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssddiis",
            $producto->nombre,
            $producto->descripcion,
            $producto->precio,
            $producto->precio_descuento,
            $producto->id_categoria,
            $producto->stock,
            $producto->imagen
        );

        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);

        return $resultado;
    }

    public function leerProductos() {
        $query = "CALL leer_productos()";
        $stmt = mysqli_prepare($this->conexion, $query);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $productos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $producto = new Producto(
                $row['id_producto'],
                $row['nombre'],
                $row['descripcion'],
                $row['precio'],
                $row['precio_descuento'],
                $row['id_categoria'],
                $row['stock'],
                $row['imagen']
            );
            $productos[] = $producto;
        }
        
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);
        
        return $productos;
    }

    public function obtenerPorId($id_producto) {
        $query = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_producto);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return new Producto(
                $fila['id_producto'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['precio'],
                $fila['precio_descuento'],
                $fila['id_categoria'],
                $fila['stock'],
                $fila['imagen']
            );
        }
        return null;
    }

    public function obtenerPorCategoria($id_categoria) {
        $query = "SELECT * FROM productos WHERE id_categoria = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_categoria);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        
        $productos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos[] = new Producto(
                $fila['id_producto'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['precio'],
                $fila['precio_descuento'],
                $fila['id_categoria'],
                $fila['stock'],
                $fila['imagen']
            );
        }
        
        return $productos;
    }

    public function actualizarProducto(Producto $producto) {
        $query = "CALL actualizar_producto(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param(
            $stmt,
            "issddiis",
            $producto->id_producto,
            $producto->nombre,
            $producto->descripcion,
            $producto->precio,
            $producto->precio_descuento,
            $producto->id_categoria,
            $producto->stock,
            $producto->imagen
        );

        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);

        return $resultado;
    }

    public function eliminarProducto($idProducto) {
        $query = "CALL eliminar_producto(?)";
        $stmt = mysqli_prepare($this->conexion, $query);

        mysqli_stmt_bind_param($stmt, "i", $idProducto);

        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_next_result($this->conexion);

        return $resultado;
    }
}
?>