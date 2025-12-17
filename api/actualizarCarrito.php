<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

require_once __DIR__ . '/../dao/CarritoDaoImpl.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_carrito']) || !isset($data['cantidad'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

$id_carrito = intval($data['id_carrito']);
$cantidad = intval($data['cantidad']);

if ($cantidad < 1) {
    echo json_encode(['success' => false, 'message' => 'Cantidad inválida']);
    exit();
}

try {
    $carritoDao = new CarritoDaoImpl();
    $resultado = $carritoDao->actualizarCantidad($id_carrito, $cantidad);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Cantidad actualizada']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar cantidad']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>