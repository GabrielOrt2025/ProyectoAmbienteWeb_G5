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
                $row['nombre'],
                $row['descripcion'],
                $row['precio'],
                $row['precio_descuento'],
                $row['id_categoria'],
                $row['stock'],
                $row['imagen'],
                $row['id_producto']
            );
        }
        mysqli_stmt_close($stmt);
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

        return $resultado;
    }

    public function eliminarProducto($idProducto) {
        $query = "CALL eliminar_producto(?)";
        $stmt = mysqli_prepare($this->conexion, $query);

        mysqli_stmt_bind_param($stmt, "i", $idProducto);

        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $resultado;
    }



}
