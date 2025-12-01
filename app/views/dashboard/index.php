<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0"><?= $welcome_message ?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">

        <!-- Info boxes -->
        <div class="row">

            <!-- Productos -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-info shadow-sm">
                        <i class="bi bi-box"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Productos</span>
                        <span class="info-box-number"><?= $total_products ?></span>
                    </div>
                </div>
            </div>

            <!-- Categorías -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                        <i class="bi bi-tags"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Categorías</span>
                        <span class="info-box-number"><?= $total_categories ?></span>
                    </div>
                </div>
            </div>

            <!-- Proveedores -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-warning shadow-sm">
                        <i class="bi bi-truck"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Proveedores</span>
                        <span class="info-box-number"><?= $total_suppliers ?></span>
                    </div>
                </div>
            </div>

            <!-- Ventas del Mes -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-danger shadow-sm">
                        <i class="bi bi-cart"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ventas</span>
                        <span class="info-box-number"><?= $total_sales ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficas -->
        <div class="row mb-4">
            <!-- Ventas últimos 6 meses -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-graph-up"></i>
                            Historial de Ventas (Últimos 6 meses)
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Productos más vendidos -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-trophy"></i>
                            Top 5 Productos
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="productsChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipos de Cambio -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-currency-exchange"></i>
                            Tipos de Cambio (USD)
                        </h3>
                        <div class="card-tools">
                            <span class="badge text-bg-info">Actualizado cada 6 horas</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <?php if (!empty($exchange_rates)): ?>
                                <?php
                                $currencies = [
                                    'EUR' => ['name' => 'Euro', 'icon' => '€', 'color' => 'primary'],
                                    'GBP' => ['name' => 'Libra', 'icon' => '£', 'color' => 'success'],
                                    'MXN' => ['name' => 'Peso MX', 'icon' => '$', 'color' => 'warning']
                                ];
                                foreach ($currencies as $code => $info):
                                    if (isset($exchange_rates[$code])):
                                        ?>
                                        <div class="col-md-4">
                                            <div class="info-box">
                                                <span class="info-box-icon text-bg-<?= $info['color'] ?>">
                                                    <i class="bi bi-currency-exchange"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"><?= $info['name'] ?> (<?= $code ?>)</span>
                                                    <span class="info-box-number">
                                                        <?= $info['icon'] ?>             <?= number_format($exchange_rates[$code], 4) ?>
                                                    </span>
                                                    <small class="text-muted">1 USD =
                                                        <?= number_format($exchange_rates[$code], 4) ?>             <?= $code ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        No se pudieron obtener los tipos de cambio. Intente más tarde.
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-lightning"></i>
                            Accesos Rápidos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/GestionInventario/public/product/create" class="btn btn-app w-100">
                                    <i class="bi bi-plus-circle"></i> Nuevo Producto
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/GestionInventario/public/sale/create" class="btn btn-app w-100">
                                    <i class="bi bi-cart-plus"></i> Nueva Venta
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/GestionInventario/public/product" class="btn btn-app w-100">
                                    <i class="bi bi-list-ul"></i> Ver Productos
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-app w-100">
                                    <i class="bi bi-bar-chart"></i> Reportes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Separador -->
        <div class="mb-4"></div>

        <!-- Productos con Stock Bajo -->
        <?php if (!empty($low_stock_products)): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Productos con Stock Bajo
                            </h3>
                            <div class="card-tools">
                                <span class="badge text-bg-danger"><?= count($low_stock_products) ?> productos</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table id="lowStockTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Stock Actual</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($low_stock_products as $product): ?>
                                        <tr>
                                            <td><code><?= htmlspecialchars($product['code']) ?></code></td>
                                            <td>
                                                <strong><?= htmlspecialchars($product['name']) ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($product['stock'] == 0): ?>
                                                    <span class="badge text-bg-danger">
                                                        <i class="bi bi-x-circle"></i> AGOTADO
                                                    </span>
                                                <?php elseif ($product['stock'] < 5): ?>
                                                    <span class="badge text-bg-danger">
                                                        <?= $product['stock'] ?> unidades
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge text-bg-warning">
                                                        <?= $product['stock'] ?> unidades
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>$<?= number_format($product['price'], 2) ?></td>
                                            <td>
                                                <a href="/GestionInventario/public/product/edit/<?= $product['id'] ?>"
                                                    class="btn btn-sm btn-warning" title="Editar para reponer stock">
                                                    <i class="bi bi-pencil"></i> Reponer
                                                </a>
                                                <a href="/GestionInventario/public/product/show/<?= $product['id'] ?>"
                                                    class="btn btn-sm btn-info" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center">
                            <a href="/GestionInventario/public/product" class="btn btn-sm btn-primary">
                                <i class="bi bi-list"></i> Ver Todos los Productos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
// Scripts específicos de esta página
ob_start();
?>
<script>
    $(document).ready(function () {
        // DataTables para tabla de stock bajo
        if ($('#lowStockTable').length > 0) {
            $('#lowStockTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "pageLength": 10,
                "order": [[2, "asc"]],  // Ordenar por stock (menor primero)
                "columnDefs": [
                    { "orderable": false, "targets": 4 }  // Desactivar ordenar en Acciones
                ]
            });
        }

        // Gráfica de Ventas
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesData = <?= json_encode($sales_history ?? []) ?>;

        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesData.map(item => item.month),
                datasets: [{
                    label: 'Ventas ($)',
                    data: salesData.map(item => item.total),
                    backgroundColor: 'rgba(60, 141, 188, 0.9)',
                    borderColor: 'rgba(60, 141, 188, 0.8)',
                    pointRadius: 4,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            display: true
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfica de Productos Top
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        const productsData = <?= json_encode($top_products ?? []) ?>;

        new Chart(productsCtx, {
            type: 'doughnut',
            data: {
                labels: productsData.map(item => item.name),
                datasets: [{
                    data: productsData.map(item => item.total_sold),
                    backgroundColor: [
                        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
                    ],
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
            }
        });
    });
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>