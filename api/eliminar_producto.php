<?php
session_start();


if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../dao/ProductoDaoImpl.php';

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    
    $productoDao = new ProductoDaoImpl();
    
    if ($productoDao->eliminarProducto($id_producto)) {
        $_SESSION['mensaje'] = 'Producto eliminado ';
        $_SESSION['tipo_mensaje'] = 'success';
    } else {
        $_SESSION['mensaje'] = 'Error al eliminar el producto';
        $_SESSION['tipo_mensaje'] = 'danger';
    }
} else {
    $_SESSION['mensaje'] = 'ID de producto no válido';
    $_SESSION['tipo_mensaje'] = 'danger';
}


$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
header('Location: ' . $referer);
exit();
?>