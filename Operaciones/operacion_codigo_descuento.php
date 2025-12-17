<?php
require_once '../DataBase/DataBase.php';
require_once '../dao/CodigoDescuentoDaoImpl.php';

header('Content-Type: application/json');

$codigoDao = new CodigoDescuentoDaoImpl($conexion);

$operacion = $_POST['operacion'] ?? $_GET['operacion'] ?? '';

switch($operacion) {
    case 'insertar':
        insertarCodigo($codigoDao);
        break;
    
    case 'actualizar':
        actualizarCodigo($codigoDao);
        break;
    
    case 'eliminar':
        eliminarCodigo($codigoDao);
        break;
    
    case 'obtener':
        obtenerCodigo($codigoDao);
        break;
    
    case 'obtener_todos':
        obtenerTodosCodigos($codigoDao);
        break;
    
    case 'validar_codigo':
        validarCodigo($codigoDao);
        break;
    
    default:
        echo json_encode(['error' => 'Operación no válida']);
        break;
}

function insertarCodigo($codigoDao) {
    try {
        $codigo = $_POST['codigo'];
        $descuento = $_POST['descuento'];
        $fecha_expiracion = $_POST['fecha_expiracion'];
        $activo = $_POST['activo'] ?? 'si';
        
        $codigoDescuento = new codigo_descuento(null, $codigo, $descuento, $fecha_expiracion, $activo);
        
        if($codigoDao->insertar($codigoDescuento)) {
            echo json_encode(['success' => true, 'mensaje' => 'Código creado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al crear código']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function actualizarCodigo($codigoDao) {
    try {
        $id = $_POST['id_codigo'];
        $codigo = $_POST['codigo'];
        $descuento = $_POST['descuento'];
        $fecha_expiracion = $_POST['fecha_expiracion'];
        $activo = $_POST['activo'];
        
        $codigoDescuento = new codigo_descuento($id, $codigo, $descuento, $fecha_expiracion, $activo);
        
        if($codigoDao->actualizar($codigoDescuento)) {
            echo json_encode(['success' => true, 'mensaje' => 'Código actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar código']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function eliminarCodigo($codigoDao) {
    try {
        $id = $_POST['id_codigo'] ?? $_GET['id_codigo'];
        
        if($codigoDao->eliminar($id)) {
            echo json_encode(['success' => true, 'mensaje' => 'Código eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar código']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerCodigo($codigoDao) {
    try {
        $id = $_GET['id_codigo'];
        $codigo = $codigoDao->obtenerPorId($id);
        
        if($codigo) {
            echo json_encode(['success' => true, 'data' => $codigo]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Código no encontrado']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function obtenerTodosCodigos($codigoDao) {
    try {
        $codigos = $codigoDao->obtenerTodos();
        echo json_encode(['success' => true, 'data' => $codigos]);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function validarCodigo($codigoDao) {
    try {
        $codigo_texto = $_POST['codigo'] ?? $_GET['codigo'];
        $codigo = $codigoDao->obtenerPorCodigo($codigo_texto);
        
        if($codigo && $codigo->activo == 'si') {
            $fecha_actual = date('Y-m-d');
            if($codigo->fecha_expiracion >= $fecha_actual) {
                echo json_encode([
                    'success' => true, 
                    'valido' => true,
                    'descuento' => $codigo->descuento,
                    'mensaje' => 'Código válido'
                ]);
            } else {
                echo json_encode([
                    'success' => true, 
                    'valido' => false,
                    'mensaje' => 'Código expirado'
                ]);
            }
        } else {
            echo json_encode([
                'success' => true, 
                'valido' => false,
                'mensaje' => 'Código inválido o inactivo'
            ]);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

mysqli_close($conexion);
?>