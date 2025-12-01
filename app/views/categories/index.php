<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Gestión de Categorías</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item active">Categorías</li>
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

        <!-- Tabla de categorías -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-tags"></i> Lista de Categorías
                </h3>
                <div class="card-tools">
                    <?php if (AuthController::isAdmin()): ?>
                        <a href="/GestionInventario/public/category/create" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Nueva Categoría
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <?php if (empty($categories)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay categorías registradas.
                        <a href="/GestionInventario/public/category/create">Crear la primera</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="categoriesTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Fecha Creación</th>
                                    <th style="width: 150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= $category['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($category['name']) ?></strong></td>
                                        <td><?= htmlspecialchars($category['description']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                                        <td>
                                            <?php if (AuthController::isAdmin()): ?>
                                                <a href="/GestionInventario/public/category/edit/<?= $category['id'] ?>"
                                                    class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/GestionInventario/public/category/deleteAction/<?= $category['id'] ?>"
                                                    class="btn btn-sm btn-danger" title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
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
                    Total de categorías: <strong><?= count($categories) ?></strong>
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
        if ($('#categoriesTable').length > 0) {
            $('#categoriesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "pageLength": 10,
                "order": [[1, "asc"]],
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