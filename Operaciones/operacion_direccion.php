<?php
require_once '../DataBase/DataBase.php';
require_once '../dao/DireccionDaoImpl.php';

header('Content-Type: application/json');

$direccionDao = new DireccionDaoImpl($conexion);

$operacion = $_POST['operacion'] ?? $_GET['operacion'] ?? '';

switch($operacion) {
    case 'insertar':
        insertarDireccion($direccionDao);
        break;
    
    case 'actualizar':
        actualizarDireccion($direccionDao);
        break;
    
    case 'eliminar':
        eliminarDireccion($direccionDao);
        break;
    
    case 'obtener':
        obtenerDireccion($direccionDao);
        break;
    
    case 'obtener_todas':
        obtenerTodasDirecciones($direccionDao);
        break;
    
    case 'obtener_por_usuario':
        obtenerDireccionesPorUsuario($direccionDao);
        break;
    
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function insertarDireccion($direccionDao) {
    try {
        $id_usuario = $_POST['id_usuario'];
        $calle = $_POST['calle'];
        $ciudad = $_POST['ciudad'];
        $codigo_postal = $_POST['codigo_postal'];
        $pais = $_POST['pais'] ?? 'España';
        $telefono = $_POST['telefono'];
        
        $direccion = new direccion(null, $id_usuario, $calle, $ciudad, $codigo_postal, $pais, $telefono);
        
        if($direccionDao->insertar($direccion)) {
            echo json_encode(['success' => true, 'mensaje' => 'Dirección creada correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al crear dirección']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function actualizarDireccion($direccionDao) {
    try {
        $id = $_POST['id_direccion'];
        $id_usuario = $_POST['id_usuario'];
        $calle = $_POST['calle'];
        $ciudad = $_POST['ciudad'];
        $codigo_postal = $_POST['codigo_postal'];
        $pais = $_POST['pais'];
        $telefono = $_POST['telefono'];
        
        $direccion = new direccion($id, $id_usuario, $calle, $ciudad, $codigo_postal, $pais, $telefono);
        
        if($direccionDao->actualizar($direccion)) {
            echo json_encode(['success' => true, 'mensaje' => 'Dirección actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar dirección']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function eliminarDireccion($direccionDao) {
    try {
        $id = $_POST['id_direccion'] ?? $_GET['id_direccion'];
        
        if($direccionDao->eliminar($id)) {
            echo json_encode(['success' => true, 'mensaje' => 'Dirección eliminada correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar dirección']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerDireccion($direccionDao) {
    try {
        $id = $_GET['id_direccion'];
        $direccion = $direccionDao->obtenerPorId($id);
        
        if($direccion) {
            echo json_encode(['success' => true, 'data' => $direccion]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Dirección no encontrada']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerTodasDirecciones($direccionDao) {
    try {
        $direcciones = $direccionDao->obtenerTodas();
        echo json_encode(['success' => true, 'data' => $direcciones]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerDireccionesPorUsuario($direccionDao) {
    try {
        $id_usuario = $_GET['id_usuario'];
        $direcciones = $direccionDao->obtenerPorUsuario($id_usuario);
        echo json_encode(['success' => true, 'data' => $direcciones]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

mysqli_close($conexion);
?>