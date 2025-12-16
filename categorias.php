<?php
session_start();
require_once 'dao/ProductoDaoImpl.php';
require_once 'dao/CategoriaDaoImpl.php';

$productoDao = new ProductoDaoImpl();
$categoriaDao = new CategoriaDaoImpl();

$categorias = $categoriaDao->obtenerTodas();


$categoriaFiltro = isset($_GET['categoria']) ? intval($_GET['categoria']) : null;


if ($categoriaFiltro) {
    $productos = $productoDao->obtenerPorCategoria($categoriaFiltro);
} else {
    $productos = $productoDao->leerProductos();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA VACA | Fall/Winter 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .filter-buttons .btn.active {
            background-color: #000 !important;
            color: #fff !important;
        }
        .producto {
            transition: all 0.3s ease;
        }
        .producto:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .button {
            padding: 8px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .button.is-warning {
            background-color: #ffc107;
            color: #000;
        }
        .button.is-warning:hover {
            background-color: #ffb300;
        }
        .button.is-danger {
            background-color: #dc3545;
            color: white;
        }
        .button.is-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <header>
        <div class="brand">LA VACA</div>
        <div class="header-links">
            <a href="index.php">Inicio</a>
            <a href="categorias.php">Categorias</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="#">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></a>
                <a href="logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
            <a href="carrito.php"><i class="bi bi-cart-fill"></i></a>
        </div>
    </header>

    <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="container mt-4">
        <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show" role="alert">
            <?php 
                echo htmlspecialchars($_SESSION['mensaje']); 
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo_mensaje']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php endif; ?>

    <section class="heroc">
        <img src="img/imagen2.png" alt="New Collection 2025">
        <img src="img/imagen3.png" alt="New Collection 2025">
        <div class="hero-text">
            <h1>START YOUR NEW CLOSET</h1>
            <button class="btn-shop" onclick="window.location.href='#productos'">SHOP NOW</button>
        </div>
    </section>

    <section class="filtros text-center my-5">
        <div class="container">
            <div class="filter-buttons d-flex justify-content-center flex-wrap gap-3">
                <button class="btn btn-outline-dark px-4 py-2 <?php echo !$categoriaFiltro ? 'active' : ''; ?>" 
                        onclick="window.location.href='categorias.php'">
                    Todos
                </button>
                <?php foreach ($categorias as $categoria): ?>
                <button class="btn btn-outline-dark px-4 py-2 <?php echo $categoriaFiltro == $categoria->id_categoria ? 'active' : ''; ?>" 
                        onclick="window.location.href='categorias.php?categoria=<?php echo $categoria->id_categoria; ?>'">
                    <?php echo htmlspecialchars($categoria->nombre); ?>
                </button>
                <?php endforeach; ?>
            </div>
            
            <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
            <div class="admin-actions mt-4">
                <a href="admin/agregar_producto.php" class="btn btn-dark btn-lg px-5 py-3">
                    <i class="bi bi-plus-circle-fill"></i> Agregar Nuevo Producto
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="productos" id="productos">
        <section class="catalogo container">
            <?php if (empty($productos)): ?>
                <div class="text-center py-5">
                    <h4>No hay productos disponibles en esta categoría</h4>
                    <a href="categorias.php" class="btn btn-dark mt-3">Ver todos los productos</a>
                </div>
            <?php else: ?>
            <div class="row g-4">
                <?php foreach ($productos as $producto): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="producto">
                        <img src="<?php echo htmlspecialchars($producto->imagen); ?>" 
                             alt="<?php echo htmlspecialchars($producto->nombre); ?>">
                        <h6><?php echo htmlspecialchars($producto->nombre); ?></h6>
                        <p class="precio">
                            <?php if ($producto->precio_descuento > 0): ?>
                                <span style="text-decoration: line-through; color: #999;">
                                    €<?php echo number_format($producto->precio, 2); ?>
                                </span>
                                <span style="color: #e74c3c; font-weight: bold;">
                                    €<?php echo number_format($producto->precio_descuento, 2); ?>
                                </span>
                            <?php else: ?>
                                €<?php echo number_format($producto->precio, 2); ?>
                            <?php endif; ?>
                        </p>
                        
                        <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                        <div class="d-flex gap-2 justify-content-center mt-2">
                            <button class="btn btn-warning btn-sm" 
                                    onclick="editarProducto(<?php echo $producto->id_producto; ?>)">
                                Editar
                            </button>
                            <button class="btn btn-danger btn-sm" 
                                    onclick="eliminarProducto(<?php echo $producto->id_producto; ?>)">
                                Eliminar
                            </button>
                        </div>
                        <?php else: ?>
                        <button class="btn btn-dark btn-sm w-100 mt-2" 
                                onclick="agregarAlCarrito(<?php echo $producto->id_producto; ?>)">
                            Agregar al Carrito
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
    </section>

    <footer>
        <p>2025 LA VACA</p>
    </footer>

<script>
function agregarAlCarrito(idProducto) {
    <?php if (!isset($_SESSION['usuario_id'])): ?>
        alert('Debes iniciar sesión para agregar productos al carrito');
        window.location.href = 'login.php';
        return;
    <?php endif; ?>
    
    fetch('api/agregarCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_producto: idProducto,
            cantidad: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto agregado al carrito');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al agregar al carrito');
    });
}

function eliminarProducto(idProducto) {
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        window.location.href = 'api/eliminar_producto.php?id=' + idProducto;
    }
}

function editarProducto(idProducto) {
    window.location.href = 'admin/editar_producto.php?id=' + idProducto;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/accesibilidad.js"></script>
</body>

</html>