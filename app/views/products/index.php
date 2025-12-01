<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Gestión de Productos</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">

        <!-- Mensajes de éxito/error -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Tabla de productos -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-box"></i> Lista de Productos
                </h3>
                <div class="card-tools">
                    <?php if (AuthController::isAdmin()): ?>
                        <a href="<?= BASE_URL ?>product/create" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Nuevo Producto
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <?php if (empty($products)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay productos registrados.
                        <a href="<?= BASE_URL ?>product/create">Crear el primero</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="productsTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 60px">Imagen</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Proveedor</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th style="width: 150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= $product['id'] ?></td>
                                        <td>
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                                    alt="<?= htmlspecialchars($product['name']) ?>" class="img-thumbnail"
                                                    style="max-width: 50px; max-height: 50px;">
                                            <?php else: ?>
                                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><code><?= htmlspecialchars($product['code']) ?></code></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>product/show/<?= $product['id'] ?>"
                                                class="text-decoration-none">
                                                <?= htmlspecialchars($product['name']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($product['category_name']): ?>
                                                <span
                                                    class="badge text-bg-info"><?= htmlspecialchars($product['category_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge text-bg-secondary">Sin categoría</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($product['supplier_name']): ?>
                                                <?= htmlspecialchars($product['supplier_name']) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin proveedor</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong>$<?= number_format($product['price'], 2) ?></strong></td>
                                        <td>
                                            <?php if ($product['stock'] < 10): ?>
                                                <span class="badge text-bg-danger"><?= $product['stock'] ?></span>
                                            <?php else: ?>
                                                <span class="badge text-bg-success"><?= $product['stock'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>product/show/<?= $product['id'] ?>"
                                                class="btn btn-sm btn-info" title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if (AuthController::isAdmin()): ?>
                                                <a href="<?= BASE_URL ?>product/edit/<?= $product['id'] ?>"
                                                    class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>product/deleteAction/<?= $product['id'] ?>"
                                                    class="btn btn-sm btn-danger" title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
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
                    Total de productos: <strong><?= count($products) ?></strong>
                </small>
            </div>
        </div>

    </div>
</div>

<?php
// Scripts específicos de esta página
ob_start();
?>
<script>
    $(document).ready(function () {
        $('#productsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "pageLength": 10,
            "order": [[0, "desc"]],
            "columnDefs": [
                { "orderable": false, "targets": 7 }
            ]
        });
    });
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>