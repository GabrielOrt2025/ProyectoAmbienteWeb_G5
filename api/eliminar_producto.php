<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

require_once __DIR__ . '/../dao/CarritoDaoImpl.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_carrito'])) {
    echo json_encode(['success' => false, 'message' => 'ID de carrito no especificado']);
    exit();
}

$id_carrito = intval($data['id_carrito']);

try {
    $carritoDao = new CarritoDaoImpl();
    $resultado = $carritoDao->eliminar($id_carrito);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar del carrito']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>