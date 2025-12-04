<?php
require_once '../DataBase/DataBase.php';
require_once '../dao/UsuarioDaoImpl.php';

$usuarioDao = new UsuarioDaoImpl($conexion);

$operacion = $_POST['operacion'] ?? $_GET['operacion'] ?? '';

switch($operacion) {
    case 'insertar':
        insertarUsuario($usuarioDao);
        break;
    
    case 'actualizar':
        actualizarUsuario($usuarioDao);
        break;
    
    case 'eliminar':
        eliminarUsuario($usuarioDao);
        break;
    
    case 'obtener':
        obtenerUsuario($usuarioDao);
        break;
    
    case 'obtener_todos':
        obtenerTodosUsuarios($usuarioDao);
        break;
    
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function insertarUsuario($usuarioDao) {
    try {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $telefono = $_POST['telefono'] ?? '';
        $rol = $_POST['rol'] ?? 'cliente';
        
        $usuario = new Usuario(null, $nombre, $apellido, $email, $password, $telefono, $rol);
        
        if($usuarioDao->insertar($usuario)) {
            echo json_encode(['success' => true, 'mensaje' => 'Usuario creado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al crear usuario']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function actualizarUsuario($usuarioDao) {
    try {
        $id = $_POST['id_usuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $telefono = $_POST['telefono'];
        $rol = $_POST['rol'];
        
        $usuario = new Usuario($id, $nombre, $apellido, $email, $password, $telefono, $rol);
        
        if($usuarioDao->actualizar($usuario)) {
            echo json_encode(['success' => true, 'mensaje' => 'Usuario actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar usuario']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function eliminarUsuario($usuarioDao) {
    try {
        $id = $_POST['id_usuario'] ?? $_GET['id_usuario'];
        
        if($usuarioDao->eliminar($id)) {
            echo json_encode(['success' => true, 'mensaje' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar usuario']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerUsuario($usuarioDao) {
    try {
        $id = $_GET['id_usuario'];
        $usuario = $usuarioDao->obtenerPorId($id);
        
        if($usuario) {
            echo json_encode(['success' => true, 'data' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Usuario no encontrado']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerTodosUsuarios($usuarioDao) {
    try {
        $usuarios = $usuarioDao->obtenerTodos();
        echo json_encode(['success' => true, 'data' => $usuarios]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
mysqli_close($conexion);
?>