<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Construcción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Iniciar Sesión</h4>
                        <small>Sistema de Análisis de Precios y Programa de Obra</small>
                    </div>
                    <div class="card-body">
                        <?php
                        require_once '../config/database.php';
                        require_once '../src/Helpers/auth.php';
                        require_once '../src/Helpers/functions.php';
                        
                        // Display flash messages
                        displayFlashMessages();
                        
                        // Check if already logged in
                        if (Auth::isLoggedIn()) {
                            header('Location: index.php');
                            exit;
                        }
                        
                        // Handle login form submission
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $email = sanitizeInput($_POST['email'] ?? '');
                            $password = $_POST['password'] ?? '';
                            
                            if (Auth::login($email, $password)) {
                                setFlashMessage('success', 'Bienvenido al sistema');
                                header('Location: index.php');
                                exit;
                            } else {
                                $error_message = 'Credenciales incorrectas';
                            }
                        }
                        ?>
                        
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($error_message) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                        
                        <hr>
                        
                        <div class="mt-3">
                            <h6>Usuarios de Prueba:</h6>
                            <small class="text-muted">
                                <strong>Admin:</strong> admin@construccion.com<br>
                                <strong>Analista:</strong> analista@construccion.com<br>
                                <strong>Visitante:</strong> visitante@construccion.com<br>
                                <strong>Contraseña:</strong> password
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>