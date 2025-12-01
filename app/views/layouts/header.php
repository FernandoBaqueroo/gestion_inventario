<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Sistema de Inventario' ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous">

    <!-- AdminLTE v4 -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/dist/css/adminlte.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary" data-bs-theme="light">
    <div class="app-wrapper">

        <!-- Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="<?= BASE_URL ?>" class="nav-link">Inicio</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ms-auto">
                    <!-- Dark Mode Toggle -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button" id="darkModeToggle" title="Cambiar tema">
                            <i class="bi bi-moon-fill" id="darkModeIcon"></i>
                        </a>
                    </li>

                    <!-- Notifications -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button">
                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning">3</span>
                        </a>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-md-inline"><?= htmlspecialchars($_SESSION['username']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                                <p>
                                    <?= htmlspecialchars($_SESSION['username']) ?>
                                    <small>
                                        <?php if (AuthController::isAdmin()): ?>
                                            <span class="badge text-bg-warning"><i class="bi bi-shield-fill-check"></i>
                                                Administrador</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-info"><i class="bi bi-person-badge"></i> Staff</span>
                                        <?php endif; ?>
                                    </small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                <a href="<?= BASE_URL ?>auth/logout"
                                    class="btn btn-default btn-flat float-end">Salir</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->