<?php
session_start();


if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../dao/ProductoDaoImpl.php';
require_once __DIR__ . '/../dao/CategoriaDaoImpl.php';
require_once __DIR__ . '/../Entidades/Producto.php';

$productoDao = new ProductoDaoImpl();
$categoriaDao = new CategoriaDaoImpl();

$categorias = $categoriaDao->obtenerTodas();
$producto = null;
$error = '';
$success = '';


if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $producto = $productoDao->obtenerPorId($id_producto);
    
    if (!$producto) {
        header('Location: ../index.php');
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_producto']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $precio_descuento = floatval($_POST['precio_descuento']);
    $id_categoria = intval($_POST['id_categoria']);
    $stock = intval($_POST['stock']);
    $imagen = trim($_POST['imagen']);
    
    if (empty($nombre) || empty($precio) || empty($id_categoria)) {
        $error = 'Por favor complete todos los campos obligatorios';
    } else {
        $productoActualizado = new Producto(
            $id,
            $nombre,
            $descripcion,
            $precio,
            $precio_descuento,
            $id_categoria,
            $stock,
            $imagen
        );
        
        if ($productoDao->actualizarProducto($productoActualizado)) {
            $success = 'Producto actualizado exitosamente';
            $producto = $productoDao->obtenerPorId($id);
        } else {
            $error = 'Error al actualizar el producto';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA VACA | Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #f7f7f7;
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .edit-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        
        .edit-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #333;
        }
        
        .form-control, .form-select {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            margin-bottom: 15px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-actualizar {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            margin-top: 20px;
        }
        
        .btn-actualizar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .preview-imagen {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2><i class="bi bi-pencil-square"></i> Editar Producto</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($producto): ?>
        <form method="POST" action="">
            <input type="hidden" name="id_producto" value="<?php echo $producto->id_producto; ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Producto *</label>
                    <input type="text" name="nombre" class="form-control" 
                           value="<?php echo htmlspecialchars($producto->nombre); ?>" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Categoría *</label>
                    <select name="id_categoria" class="form-select" required>
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria->id_categoria; ?>" 
                                <?php echo $producto->id_categoria == $categoria->id_categoria ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria->nombre); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?php echo htmlspecialchars($producto->descripcion); ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Precio (€) *</label>
                    <input type="number" name="precio" class="form-control" step="0.01" min="0"
                           value="<?php echo $producto->precio; ?>" required>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Precio Descuento (€)</label>
                    <input type="number" name="precio_descuento" class="form-control" step="0.01" min="0"
                           value="<?php echo $producto->precio_descuento; ?>">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="<?php echo $producto->stock; ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">URL de la Imagen</label>
                <input type="text" name="imagen" class="form-control" id="imagenInput"
                       value="<?php echo htmlspecialchars($producto->imagen); ?>"
                       onchange="previewImagen()">
                <small class="text-muted">Ejemplo: img/producto.png</small>
            </div>
            
            <?php if ($producto->imagen): ?>
            <div class="text-center">
                <label class="form-label">Vista previa:</label><br>
                <img src="../<?php echo htmlspecialchars($producto->imagen); ?>" 
                     alt="Preview" class="preview-imagen" id="imagenPreview">
            </div>
            <?php endif; ?>
            
            <button type="submit" class="btn-actualizar">
                <i class="bi bi-check-circle"></i> Actualizar Producto
            </button>
            
            <div class="text-center mt-4">
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </form>
        <?php endif; ?>
    </div>

    <script>
        function previewImagen() {
            const input = document.getElementById('imagenInput');
            const preview = document.getElementById('imagenPreview');
            
            if (input.value && preview) {
                preview.src = '../' + input.value;
            }
        }
    </script>
</body>
</html>