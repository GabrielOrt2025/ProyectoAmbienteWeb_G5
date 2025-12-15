<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'dao/UsuarioDaoImpl.php';
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor complete todos los campos';
    } else {
        $usuarioDao = new UsuarioDaoImpl();
        $usuario = $usuarioDao->validarLogin($email, $password);
        
        if ($usuario) {
            // Login exitoso
            $_SESSION['usuario_id'] = $usuario->id_usuario;
            $_SESSION['usuario_nombre'] = $usuario->nombre;
            $_SESSION['usuario_email'] = $usuario->email;
            $_SESSION['usuario_rol'] = $usuario->rol;
            
            header('Location: index.php');
            exit();
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
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        .login-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }
        
        .login-image h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .login-form {
            padding: 60px 40px;
        }
        
        .login-form h3 {
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 10px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            .login-image {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <h2>LA VACA</h2>
            <p>Tu tienda de moda online</p>
            <p style="margin-top: 30px;">¿No tienes cuenta?</p>
            <a href="registro.php" class="btn btn-light mt-3">Regístrate Aquí</a>
        </div>
        
        <div class="login-form">
            <h3>Iniciar Sesión</h3>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           placeholder="tu@email.com" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" 
                           placeholder="Tu contraseña" required>
                </div>
                
                <button type="submit" class="btn-login">Iniciar Sesión</button>
                
                <div class="text-center mt-4">
                    <a href="index.php" style="color: #667eea; text-decoration: none;">
                        ← Volver a la tienda
                    </a>
                </div>
            </form>
            
            <div class="mt-4 p-3 bg-light rounded">
                <small><strong>Usuario de prueba:</strong></small><br>
                <small>Email: eduard@gmail.com</small><br>
                <small>Password: pass123</small>
            </div>
        </div>
    </div>
</body>
</html>