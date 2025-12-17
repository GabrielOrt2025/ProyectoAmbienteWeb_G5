<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'DataBase/DataBase.php';
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor complete todos los campos';
    } else {
        global $conexion;
        
        // Buscar usuario directamente
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        
        if ($usuario) {
            // Verificar contraseña - acepta tanto hasheadas como texto plano
            $passwordValido = false;
            
            // Intenta primero con password_verify (para contraseñas hasheadas)
            if (password_verify($password, $usuario['password'])) {
                $passwordValido = true;
            }
            // Si no funciona, compara directamente (para contraseñas en texto plano)
            elseif ($usuario['password'] === $password) {
                $passwordValido = true;
            }
            
            if ($passwordValido) {
                // Login exitoso
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                header('Location: index.php');
                exit();
            } else {
                $error = 'Email o contraseña incorrectos';
            }
        } else {
            $error = 'Email o contraseña incorrectos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LA VACA | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/login.css">
  
</head>
<body class="pagina-login">
  <header>
    <div class="brand">LA VACA</div>
    <div class="header-links">
      <a href="index.php">Inicio</a>
      <a href="categorias.php">Categorias</a>
      <a href="nosotros.php">Nosotros</a>
      <a href="login.php">Login</a>
    </div>
  </header>

  <div class="login-container">
    <div class="login-box">
      <h1 class="login-title">LOGIN</h1>
      
      <?php if ($error): ?>
        <div class="error-message" id="errorMsg"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      
      <div class="required-text">*CAMPOS REQUERIDOS</div>
      
      <form method="POST" action="login.php" id="loginForm">
        <div class="mb-4">
          <label for="email" class="form-label">Email *</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Contraseña *</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember" name="remember">
          <label class="form-check-label" for="remember">
            RECORDARME
          </label>
        </div>
        
        <div class="login-links">
          <a href="#" onclick="mostrarMensaje('recuperar'); return false;">¿OLVIDASTE TU CONTRASEÑA?</a>
        </div>
        
        <button type="submit" class="btn-login">SIGUIENTE</button>
      </form>
      
      <div class="create-account">
        <h3>CREAR UNA CUENTA</h3>
        <p>DISFRUTA DE UNA EXPERIENCIA DE COMPRA MAS RAPIDA Y GESTIONA TU INFORMACIÓN PERSONAL EN TU CUENTA</p>
        <button class="btn-create" onclick="window.location.href='registro.php'">CREAR UNA CUENTA</button>
      </div>

      <div class="mt-4 p-3" style="background: #f5f5f5; border-radius: 4px;">
        <small><strong>Usuario de prueba:</strong></small><br>
        <small>Email: admin@lavaca.com</small><br>
        <small>Password: password</small>
      </div>
    </div>
  </div>

  <footer>
    <p>2025 LA VACA</p>
  </footer>

  <script>
    function mostrarMensaje(tipo) {
      if (tipo === 'recuperar') {
        alert('Funcionalidad de recuperación de contraseña en desarrollo');
      }
    }
  </script>
</body>
</html>