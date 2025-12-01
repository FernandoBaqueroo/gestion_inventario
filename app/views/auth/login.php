<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Login' ?></title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/dist/css/adminlte.min.css">
</head>
<body class="login-page bg-body-secondary" data-bs-theme="light">
    <div class="login-box">
        <!-- Logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= BASE_URL ?>" class="link-dark text-decoration-none">
                    <h1 class="mb-0">
                        <i class="bi bi-box-seam"></i>
                        <b>Sistema</b> Inventario
                    </h1>
                </a>
            </div>
            
            <div class="card-body">
                <p class="login-box-msg">Inicia sesión para comenzar</p>

                <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>auth/authenticate" method="post">
                    <!-- Username -->
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Usuario" required autofocus>
                        <div class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                        <div class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label" for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-0 mt-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Usuario de prueba: <b>admin</b> / Contraseña: <b>admin123</b>
                    </small>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Support -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar tema guardado al cargar
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            document.body.setAttribute('data-bs-theme', 'dark');
        }
    });
    </script>
</body>
</html>