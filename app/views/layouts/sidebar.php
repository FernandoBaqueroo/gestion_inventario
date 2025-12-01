<!-- Main Sidebar -->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
        <a href="<?= BASE_URL ?>" class="brand-link">
            <i class="bi bi-box-seam brand-icon opacity-75 fs-4"></i>
            <span class="brand-text fw-light">Inventario</span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>"
                        class="nav-link <?= ($_SERVER['REQUEST_URI'] == '<?= BASE_URL ?>' || $_SERVER['REQUEST_URI'] == '<?= BASE_URL ?>index.php') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Productos -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>product"
                        class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/product') !== false) ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-box"></i>
                        <p>Productos</p>
                    </a>
                </li>

                <!-- Categorías -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>category"
                        class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/category') !== false) ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Categorías</p>
                    </a>
                </li>

                <!-- Proveedores -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>supplier"
                        class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/supplier') !== false) ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-truck"></i>
                        <p>Proveedores</p>
                    </a>
                </li>

                <!-- Ventas -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>sale"
                        class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/sale') !== false) ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-cart"></i>
                        <p>Ventas</p>
                    </a>
                </li>

                <!-- Separador -->
                <li class="nav-header">CONFIGURACIÓN</li>

                <!-- Usuarios (Solo Admin) -->
                <?php if (AuthController::isAdmin()): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>user"
                            class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/user') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Reportes -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-bar-chart"></i>
                        <p>
                            Reportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Inventario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Ventas</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper -->
<main class="app-main">