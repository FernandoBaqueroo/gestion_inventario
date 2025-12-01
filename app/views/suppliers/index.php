<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Gestión de Proveedores</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item active">Proveedores</li>
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

        <!-- Tabla de proveedores -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-truck"></i> Lista de Proveedores
                </h3>
                <div class="card-tools">
                    <?php if (AuthController::isAdmin()): ?>
                        <a href="/GestionInventario/public/supplier/create" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Nuevo Proveedor
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <?php if (empty($suppliers)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay proveedores registrados.
                        <a href="/GestionInventario/public/supplier/create">Crear el primero</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="suppliersTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Empresa</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Fecha Creación</th>
                                    <th style="width: 150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <tr>
                                        <td><?= $supplier['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($supplier['company_name']) ?></strong></td>
                                        <td>
                                            <?php if ($supplier['contact_email']): ?>
                                                <a href="mailto:<?= htmlspecialchars($supplier['contact_email']) ?>">
                                                    <?= htmlspecialchars($supplier['contact_email']) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">No especificado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($supplier['phone']): ?>
                                                <i class="bi bi-telephone"></i> <?= htmlspecialchars($supplier['phone']) ?>
                                            <?php else: ?>
                                                <span class="text-muted">No especificado</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($supplier['created_at'])) ?></td>
                                        <td>
                                            <?php if (AuthController::isAdmin()): ?>
                                                <a href="/GestionInventario/public/supplier/edit/<?= $supplier['id'] ?>"
                                                    class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/GestionInventario/public/supplier/deleteAction/<?= $supplier['id'] ?>"
                                                    class="btn btn-sm btn-danger" title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted"><i class="bi bi-lock"></i> Solo lectura</span>
                                            <?php endif; ?>
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
                    Total de proveedores: <strong><?= count($suppliers) ?></strong>
                </small>
            </div>
        </div>

    </div>
</div>

<?php
// Scripts específicos
ob_start();
?>
<script>
    $(document).ready(function () {
        if ($('#suppliersTable').length > 0) {
            $('#suppliersTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "pageLength": 10,
                "order": [[1, "asc"]],
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            });
        }
    });
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>