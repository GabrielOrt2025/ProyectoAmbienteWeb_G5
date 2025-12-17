<?php
require_once '../DataBase/DataBase.php';
require_once '../dao/ProductoDaoImpl.php';

header('Content-Type: application/json');

$productoDao = new ProductoDaoImpl($conexion);

$operacion = $_POST['operacion'] ?? $_GET['operacion'] ?? '';

switch($operacion) {
    case 'insertar':
        insertarProducto($productoDao);
        break;
    
    case 'actualizar':
        actualizarProducto($productoDao);
        break;
    
    case 'eliminar':
        eliminarProducto($productoDao);
        break;
    
    case 'obtener':
        obtenerProducto($productoDao);
        break;
    
    case 'obtener_todos':
        obtenerTodosProductos($productoDao);
        break;
    
    case 'obtener_por_categoria':
        obtenerProductosPorCategoria($productoDao);
        break;
    
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function insertarProducto($productoDao) {
    try {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $precio_desc = $_POST['precio_descuento'] ?? null;
        $id_categoria = $_POST['id_categoria'];
        $stock = $_POST['stock'];
        $imagen = $_POST['imagen'] ?? 'img/default.png';
        
        $producto = new producto(null, $nombre, $descripcion, $precio, $precio_desc, $id_categoria, $stock, $imagen);
        
        if($productoDao->insertar($producto)) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto creado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al crear producto']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function actualizarProducto($productoDao) {
    try {
        $id = $_POST['id_producto'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $precio_desc = $_POST['precio_descuento'];
        $id_categoria = $_POST['id_categoria'];
        $stock = $_POST['stock'];
        $imagen = $_POST['imagen'];
        
        $producto = new producto($id, $nombre, $descripcion, $precio, $precio_desc, $id_categoria, $stock, $imagen);
        
        if($productoDao->actualizar($producto)) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar producto']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function eliminarProducto($productoDao) {
    try {
        $id = $_POST['id_producto'] ?? $_GET['id_producto'];
        
        if($productoDao->eliminar($id)) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar producto']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerProducto($productoDao) {
    try {
        $id = $_GET['id_producto'];
        $producto = $productoDao->obtenerPorId($id);
        
        if($producto) {
            echo json_encode(['success' => true, 'data' => $producto]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Producto no encontrado']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerTodosProductos($productoDao) {
    try {
        $productos = $productoDao->obtenerTodos();
        echo json_encode(['success' => true, 'data' => $productos]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerProductosPorCategoria($productoDao) {
    try {
        $id_categoria = $_GET['id_categoria'];
        $productos = $productoDao->obtenerPorCategoria($id_categoria);
        echo json_encode(['success' => true, 'data' => $productos]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

mysqli_close($conexion);
?>