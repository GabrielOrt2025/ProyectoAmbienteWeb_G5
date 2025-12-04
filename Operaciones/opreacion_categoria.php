<?php
require_once '../DataBase/DataBase.php';
require_once '../dao/CategoriaDaoImpl.php';

header('Content-Type: application/json');

$categoriaDao = new CategoriaDaoImpl($conexion);

$operacion = $_POST['operacion'] ?? $_GET['operacion'] ?? '';

switch($operacion) {
    case 'insertar':
        insertarCategoria($categoriaDao);
        break;
    
    case 'actualizar':
        actualizarCategoria($categoriaDao);
        break;
    
    case 'eliminar':
        eliminarCategoria($categoriaDao);
        break;
    
    case 'obtener':
        obtenerCategoria($categoriaDao);
        break;
    
    case 'obtener_todos':
        obtenerTodasCategorias($categoriaDao);
        break;
    
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function insertarCategoria($categoriaDao) {
    try {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'] ?? '';
        $imagen = $_POST['imagen'] ?? '';
        
        $categoria = new categoria(null, $nombre, $descripcion, $imagen);
        
        if($categoriaDao->insertar($categoria)) {
            echo json_encode(['success' => true, 'mensaje' => 'Categoría creada correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al crear categoría']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function actualizarCategoria($categoriaDao) {
    try {
        $id = $_POST['id_categoria'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'];
        
        $categoria = new categoria($id, $nombre, $descripcion, $imagen);
        
        if($categoriaDao->actualizar($categoria)) {
            echo json_encode(['success' => true, 'mensaje' => 'Categoría actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar categoría']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function eliminarCategoria($categoriaDao) {
    try {
        $id = $_POST['id_categoria'] ?? $_GET['id_categoria'];
        
        if($categoriaDao->eliminar($id)) {
            echo json_encode(['success' => true, 'mensaje' => 'Categoría eliminada correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar categoría']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerCategoria($categoriaDao) {
    try {
        $id = $_GET['id_categoria'];
        $categoria = $categoriaDao->obtenerPorId($id);
        
        if($categoria) {
            echo json_encode(['success' => true, 'data' => $categoria]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Categoría no encontrada']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerTodasCategorias($categoriaDao) {
    try {
        $categorias = $categoriaDao->obtenerTodos();
        echo json_encode(['success' => true, 'data' => $categorias]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

mysqli_close($conexion);
?>