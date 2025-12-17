<?php
require_once '../DataBase/DataBase.php';
require_once '../dao/CarritoDaoImpl.php';

header('Content-Type: application/json');

$carritoDao = new CarritoDaoImpl($conexion);

$operacion = $_POST['operacion'] ?? $_GET['operacion'] ?? '';

switch($operacion) {
    case 'agregar':
        agregarAlCarrito($carritoDao);
        break;
    
    case 'eliminar':
        eliminarDelCarrito($carritoDao);
        break;
    
    case 'obtener_por_usuario':
        obtenerCarritoUsuario($carritoDao);
        break;
    
    case 'vaciar':
        vaciarCarrito($carritoDao);
        break;
    
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function agregarAlCarrito($carritoDao) {
    try {
        $id_usuario = $_POST['id_usuario'];
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        
        if($carritoDao->agregar($id_usuario, $id_producto, $cantidad, $precio)) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto agregado al carrito']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al agregar producto']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function eliminarDelCarrito($carritoDao) {
    try {
        $id_carrito = $_POST['id_carrito'] ?? $_GET['id_carrito'];
        
        if($carritoDao->eliminar($id_carrito)) {
            echo json_encode(['success' => true, 'mensaje' => 'Producto eliminado del carrito']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar producto']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerCarritoUsuario($carritoDao) {
    try {
        $id_usuario = $_GET['id_usuario'];
        $items = $carritoDao->obtenerPorUsuario($id_usuario);
        echo json_encode(['success' => true, 'data' => $items]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function vaciarCarrito($carritoDao) {
    try {
        $id_usuario = $_POST['id_usuario'];
        
        if($carritoDao->vaciar($id_usuario)) {
            echo json_encode(['success' => true, 'mensaje' => 'Carrito vaciado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al vaciar carrito']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

mysqli_close($conexion);
?>