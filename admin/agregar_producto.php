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
$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $nuevoProducto = new Producto(
            null,
            $nombre,
            $descripcion,
            $precio,
            $precio_descuento,
            $id_categoria,
            $stock,
            $imagen
        );
        
        if ($productoDao->crearProducto($nuevoProducto)) {
            $success = 'Producto agregado exitosamente';
            
            $_POST = array();
        } else {
            $error = 'Error al agregar el producto';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA VACA | Agregar Producto</title>
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
        
        .add-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        
        .add-container h2 {
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
        
        .btn-agregar {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #51cf66 0%, #37b24d 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            margin-top: 20px;
        }
        
        .btn-agregar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(81, 207, 102, 0.4);
        }
    </style>
</head>
<body>
    <div class="add-container">
        <h2><i class="bi bi-plus-circle"></i> Agregar Nuevo Producto</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <br><a href="../index.php">Ver en la tienda</a> | 
                <a href="agregar_producto.php">Agregar otro producto</a>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Producto *</label>
                    <input type="text" name="nombre" class="form-control" 
                           placeholder="Ej: Camisa Elegante" required
                           value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Categoría *</label>
                    <select name="id_categoria" class="form-select" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria->id_categoria; ?>"
                                <?php echo (isset($_POST['id_categoria']) && $_POST['id_categoria'] == $categoria->id_categoria) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria->nombre); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" 
                          placeholder="Descripción del producto"><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Precio (€) *</label>
                    <input type="number" name="precio" class="form-control" step="0.01" min="0"
                           placeholder="0.00" required
                           value="<?php echo isset($_POST['precio']) ? $_POST['precio'] : ''; ?>">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Precio Descuento (€)</label>
                    <input type="number" name="precio_descuento" class="form-control" step="0.01" min="0"
                           placeholder="0.00"
                           value="<?php echo isset($_POST['precio_descuento']) ? $_POST['precio_descuento'] : ''; ?>">
                    <small class="text-muted">Dejar en 0 si no hay descuento</small>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           placeholder="0" required
                           value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : ''; ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">URL de la Imagen</label>
                <input type="text" name="imagen" class="form-control"
                       placeholder="img/producto.png"
                       value="<?php echo isset($_POST['imagen']) ? htmlspecialchars($_POST['imagen']) : ''; ?>">
                <small class="text-muted">Ruta de la imagen (debe estar en la carpeta del proyecto)</small>
            </div>
            
            <button type="submit" class="btn-agregar">
                <i class="bi bi-check-circle"></i> Agregar Producto
            </button>
            
            <div class="text-center mt-4">
                <a href="../index.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver a la tienda
                </a>
            </div>
        </form>
    </div>
</body>
</html>