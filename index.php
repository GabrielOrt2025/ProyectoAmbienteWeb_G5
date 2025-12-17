<?php
session_start();
require_once 'dao/ProductoDaoImpl.php';

$productoDao = new ProductoDaoImpl();
$productos = $productoDao->leerProductos();

$productosDestacados = array_slice($productos, 0, 4);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LA VACA | Fall/Winter 2025</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css">
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

  <section class="hero">
    <img src="img/banner.png" alt="New Collection 2025">
    <div class="hero-text">
      <h1>NEW COLLECTION</h1>
      <p>FALL/WINTER MODA 2025</p>
      <button class="btn-shop" onclick="window.location.href='categorias.php'">SHOP NOW</button>
    </div>
  </section>

  <section class="productos">
    <h2 class="section-title">READY-TO-WEAR</h2>
    <div class="container">
      <div class="row justify-content-center">
        <?php foreach ($productosDestacados as $producto): ?>
          <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
              <img src="<?php echo htmlspecialchars($producto->imagen); ?>"
                alt="<?php echo htmlspecialchars($producto->nombre); ?>">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($producto->nombre); ?></h5>
                <p class="precio">
                  <?php if ($producto->precio_descuento > 0): ?>
                    <span style="text-decoration: line-through; color: #999;">₡<?php echo number_format($producto->precio, 3, '.', ','); ?></span>
                    <span style="color: #e74c3c; font-weight: bold;">₡<?php echo number_format($producto->precio_descuento, 3, '.', ','); ?></span>
                  <?php else: ?>
                    ₡<?php echo number_format($producto->precio, 3, '.', ','); ?>
                  <?php endif; ?>
                </p>

                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                  <div class="buttons">
                    <button class="btn btn-warning btn-sm" onclick="editarProducto(<?php echo $producto->id_producto; ?>)">
                      Editar
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="eliminarProducto(<?php echo $producto->id_producto; ?>)">
                      Eliminar
                    </button>
                  </div>
                <?php else: ?>
                  <button class="btn btn-dark btn-sm w-100"
                    onclick="agregarAlCarrito(<?php echo $producto->id_producto; ?>)">
                    Agregar al Carrito
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="categorias">
    <div class="container">
      <h2>CATEGORIES</h2>
      <ul>
        <li><a href="categorias.php?categoria=1" style="text-decoration: none; color: inherit;">CLOTHES /</a></li>
        <li><a href="categorias.php?categoria=2" style="text-decoration: none; color: inherit;">SHOES /</a></li>
        <li><a href="categorias.php?categoria=3" style="text-decoration: none; color: inherit;">BAGS /</a></li>
        <li><a href="categorias.php?categoria=4" style="text-decoration: none; color: inherit;">ACCESSORIES /</a></li>
      </ul>
    </div>
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
</body>

</html>