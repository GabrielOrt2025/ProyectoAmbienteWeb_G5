<?php
session_start();
require_once 'dao/UsuarioDaoImpl.php';
require_once 'Entidades/Usuario.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);
    $telefono = trim($_POST['telefono']);
    
    // Validaciones
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($password !== $password_confirm) {
        $error = 'Las contraseñas no coinciden';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } else {
        $usuarioDao = new UsuarioDaoImpl();
        
        // Verificar si el email ya existe
        if ($usuarioDao->obtenerPorEmail($email)) {
            $error = 'Este email ya está registrado';
        } else {
            // Crear nuevo usuario
            $nuevoUsuario = new Usuario(
                null,
                $nombre,
                $apellido,
                $email,
                $password,
                $telefono,
                'cliente'
            );
            
            if ($usuarioDao->insertar($nuevoUsuario)) {
                $success = 'Registro exitoso. Redirigiendo al login...';
                header('refresh:2;url=login.php');
            } else {
                $error = 'Error al registrar usuario. Intenta nuevamente.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA VACA | Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    <div class="registro-container">
        <h2>Crear Cuenta</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" 
                           placeholder="Tu nombre" required 
                           value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" 
                           placeholder="Tu apellido" required
                           value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       placeholder="tu@email.com" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="telefono" class="form-control" 
                       placeholder="+506 8888-8888"
                       value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" 
                       placeholder="Mínimo 6 caracteres" required>
                <small class="text-muted">Mínimo 6 caracteres</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirm" class="form-control" 
                       placeholder="Repite tu contraseña" required>
            </div>
            
            <button type="submit" class="btn-registro">Registrarse</button>
            
            <div class="text-center mt-4">
                <p>¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a></p>
                <a href="index.php" style="color: #999;">← Volver a la tienda</a>
            </div>
        </form>
    </div>
</body>
</html>