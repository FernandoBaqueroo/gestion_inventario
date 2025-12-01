<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detalle de Venta #<?= $sale['id'] ?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/sale">Ventas</a></li>
                    <li class="breadcrumb-item active">Venta #<?= $sale['id'] ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        
        <div class="row">
            <!-- Información de la venta -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-receipt"></i> Información de la Venta
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="bi bi-hash"></i> ID de Venta:</strong>
                                <p class="text-muted">#<?= $sale['id'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-calendar"></i> Fecha:</strong>
                                <p class="text-muted"><?= date('d/m/Y H:i:s', strtotime($sale['sale_date'])) ?></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="bi bi-person"></i> Vendedor:</strong>
                                <p class="text-muted"><?= htmlspecialchars($sale['username']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-currency-dollar"></i> Total:</strong>
                                <p><span class="fs-4 text-success"><strong>$<?= number_format($sale['total'], 2) ?></strong></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos vendidos -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-list-ul"></i> Productos Vendidos
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sale['details'] as $detail): ?>
                                <tr>
                                    <td><code><?= htmlspecialchars($detail['code']) ?></code></td>
                                    <td><?= htmlspecialchars($detail['product_name']) ?></td>
                                    <td><span class="badge text-bg-primary"><?= $detail['quantity'] ?></span></td>
                                    <td>$<?= number_format($detail['price'], 2) ?></td>
                                    <td><strong>$<?= number_format($detail['subtotal'], 2) ?></strong></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                    <td><strong class="text-success fs-5">$<?= number_format($sale['total'], 2) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-lightning"></i> Acciones
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="/GestionInventario/public/sale/ticket/<?= $sale['id'] ?>" 
                           class="btn btn-secondary btn-block w-100 mb-2"
                           target="_blank">
                            <i class="bi bi-printer"></i> Imprimir Ticket
                        </a>
                        <a href="/GestionInventario/public/sale" 
                           class="btn btn-primary btn-block w-100">
                            <i class="bi bi-arrow-left"></i> Volver al Historial
                        </a>
                    </div>
                </div>

                <!-- Resumen -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Resumen
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><strong>Productos:</strong> <?= count($sale['details']) ?> artículos</li>
                            <li><strong>Unidades:</strong> <?= array_sum(array_column($sale['details'], 'quantity')) ?> unidades</li>
                            <li><strong>Total:</strong> <span class="text-success">$<?= number_format($sale['total'], 2) ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>

