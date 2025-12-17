<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

require_once __DIR__ . '/../dao/CarritoDaoImpl.php';
require_once __DIR__ . '/../dao/ProductoDaoImpl.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_producto']) || !isset($data['cantidad'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$id_producto = intval($data['id_producto']);
$cantidad = intval($data['cantidad']);

if ($cantidad < 1) {
    echo json_encode(['success' => false, 'message' => 'Cantidad inválida']);
    exit();
}

try {
    $productoDao = new ProductoDaoImpl();
    $producto = $productoDao->obtenerPorId($id_producto);
    
    if (!$producto) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit();
    }
    
    if ($producto->stock < $cantidad) {
        echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
        exit();
    }
    
    $precio = $producto->precio_descuento > 0 ? $producto->precio_descuento : $producto->precio;
    
    $carritoDao = new CarritoDaoImpl();
    $resultado = $carritoDao->agregar($id_usuario, $id_producto, $cantidad, $precio);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar al carrito']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>