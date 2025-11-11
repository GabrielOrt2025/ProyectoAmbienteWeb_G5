<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LA VACA | Fall/Winter 2025</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- es un header que es donde esta arriba de la pagina(tipo para selecionar el innicio etc) -->
  <header>
    <div class="brand">LA VACA</div>
    <div class="header-links">
      <a href="index.php">Inicio</a>
      <a href="categorias.php">Categorias</a>
      <a href="login.php">Login</a>
    </div>
  </header>

  <!-- hero ( esta es donde va la imagen en el inicio donde diga que hay ropa nueva) -->
  <section class="hero">
    <img src="img/banner.png" alt="New Collection 2025">
    <div class="hero-text">
      <h1>NEW COLLECTION</h1>
      <p>FALL/WINTER MODA 2025</p>
      <button class="btn-shop">SHOP NOW</button>
    </div>
  </section>

  <!-- ready to wear la seccion donde se puede ver donde se agregaron los productos nuevos -->
  <section class="productos">
    <h2 class="section-title">READY-TO-WEAR</h2>
    <div class="container">
      <div class="row justify-content-center">
        <!--producto 1 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="img/imagen.png" alt="imagen">
            <div class="card-body">
              <h5 class="card-title">Chaqueta de cuero napa</h5>
              <p>$20</p>
            </div>
          </div>
        </div>
        <!--producto 2 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="img/imagen1.png" alt="imagen1">
            <div class="card-body">
              <h5 class="card-title">Cardigan roja</h5>
              <p>$30</p>
            </div>
          </div>
        </div>
        <!-- producto 3 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="img/imagen2.png" alt="imagen2">
            <div class="card-body">
              <h5 class="card-title">Velcro black pants</h5>
              <p>$25</p>
            </div>
          </div>
        </div>
        <!-- Producto 4 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="img/imagen3.png" alt="imagen3">
            <div class="card-body">
              <h5 class="card-title">Pantalon de lana y algodon</h5>
              <p>$15</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- categorias -->
  <section class="categorias">
    <div class="container">
      <h2>CATEGORIES</h2>
      <ul>
        <li>CLOTHES /</li>
        <li>SHOES /</li>
        <li>BAGS /</li>
        <li>ACCESSORIES /</li>
      </ul>
    </div>
  </section>

  <!-- abajo-->
  <footer>
    <p>2025 LA VACA</p>
  </footer>

  
</body>
</html>
