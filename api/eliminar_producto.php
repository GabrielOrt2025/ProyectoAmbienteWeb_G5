<?php
session_start();

// Verificar que el usuario sea administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../dao/ProductoDaoImpl.php';
require_once __DIR__ . '/../DataBase/DataBase.php';

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    
    global $conexion;
    
    try {
        // Iniciar transacción
        mysqli_begin_transaction($conexion);
        
        // 1. Eliminar del carrito
        $query1 = "DELETE FROM carrito WHERE id_producto = ?";
        $stmt1 = mysqli_prepare($conexion, $query1);
        mysqli_stmt_bind_param($stmt1, "i", $id_producto);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
        
        // 2. Eliminar de detalle_pedido (si existe)
        $query2 = "DELETE FROM detalle_pedido WHERE id_producto = ?";
        $stmt2 = mysqli_prepare($conexion, $query2);
        mysqli_stmt_bind_param($stmt2, "i", $id_producto);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
        
        // 3. Ahora sí eliminar el producto
        $productoDao = new ProductoDaoImpl();
        if ($productoDao->eliminarProducto($id_producto)) {
            // Confirmar transacción
            mysqli_commit($conexion);
            $_SESSION['mensaje'] = 'Producto eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            // Revertir cambios si falla
            mysqli_rollback($conexion);
            $_SESSION['mensaje'] = 'Error al eliminar el producto';
            $_SESSION['tipo_mensaje'] = 'danger';
        }
        
    } catch (Exception $e) {
        // Revertir cambios en caso de error
        mysqli_rollback($conexion);
        $_SESSION['mensaje'] = 'Error al eliminar: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'danger';
    }
    
} else {
    $_SESSION['mensaje'] = 'ID de producto no válido';
    $_SESSION['tipo_mensaje'] = 'danger';
}

// Redirigir de vuelta a la página anterior
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
header('Location: ' . $referer);
exit();
?>