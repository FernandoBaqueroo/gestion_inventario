<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Historial de Ventas</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active">Ventas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        
        <!-- Mensajes -->
        <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Tabla de ventas -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-receipt"></i> Lista de Ventas
                </h3>
                <div class="card-tools">
                    <a href="<?= BASE_URL ?>sale/create" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Nueva Venta
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <?php if (empty($sales)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay ventas registradas.
                        <a href="<?= BASE_URL ?>sale/create">Registrar la primera</a>
                    </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table id="salesTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Total</th>
                                <th style="width: 150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?= $sale['id'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($sale['sale_date'])) ?></td>
                                <td>
                                    <i class="bi bi-person"></i> <?= htmlspecialchars($sale['username']) ?>
                                </td>
                                <td>
                                    <strong class="text-success">$<?= number_format($sale['total'], 2) ?></strong>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>sale/show/<?= $sale['id'] ?>" 
                                       class="btn btn-sm btn-info" 
                                       title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>sale/ticket/<?= $sale['id'] ?>" 
                                       class="btn btn-sm btn-secondary" 
                                       title="Ver ticket"
                                       target="_blank">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="card-footer">
                <small class="text-muted">
                    Total de ventas: <strong><?= count($sales) ?></strong>
                    <?php if (!empty($sales)): ?>
                        | Total acumulado: <strong class="text-success">$<?= number_format(array_sum(array_column($sales, 'total')), 2) ?></strong>
                    <?php endif; ?>
                </small>
            </div>
        </div>

    </div>
</div>

<?php
ob_start();
?>
<script>
$(document).ready(function() {
    if ($('#salesTable').length > 0) {
        $('#salesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "pageLength": 10,
            "order": [[0, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    }
});
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>

