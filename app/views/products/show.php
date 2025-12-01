<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detalle del Producto</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/product">Productos</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        
        <div class="row">
            <!-- Columna principal -->
            <div class="col-md-8">
                <!-- Información del Producto -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Información del Producto
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="bi bi-upc-scan"></i> Código:</strong>
                                <p class="text-muted">
                                    <code class="fs-5"><?= htmlspecialchars($product['code']) ?></code>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-box"></i> Nombre:</strong>
                                <p class="text-muted"><?= htmlspecialchars($product['name']) ?></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="bi bi-tags"></i> Categoría:</strong>
                                <p>
                                    <?php if ($product['category_name']): ?>
                                        <span class="badge text-bg-info fs-6">
                                            <?= htmlspecialchars($product['category_name']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">Sin categoría</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-truck"></i> Proveedor:</strong>
                                <p class="text-muted">
                                    <?php if ($product['supplier_name']): ?>
                                        <?= htmlspecialchars($product['supplier_name']) ?>
                                    <?php else: ?>
                                        <span class="text-secondary">Sin proveedor</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong><i class="bi bi-currency-dollar"></i> Precio:</strong>
                                <p>
                                    <span class="fs-4 text-success">
                                        <strong>$<?= number_format($product['price'], 2) ?></strong>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-stack"></i> Stock:</strong>
                                <p>
                                    <?php if ($product['stock'] < 10): ?>
                                        <span class="badge text-bg-danger fs-5">
                                            <?= $product['stock'] ?> unidades
                                        </span>
                                        <small class="text-danger d-block">⚠️ Stock bajo</small>
                                    <?php else: ?>
                                        <span class="badge text-bg-success fs-5">
                                            <?= $product['stock'] ?> unidades
                                        </span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong><i class="bi bi-calendar"></i> Fecha de Creación:</strong>
                                <p class="text-muted">
                                    <?= date('d/m/Y H:i', strtotime($product['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <a href="/GestionInventario/public/product/edit/<?= $product['id'] ?>" 
                           class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar Producto
                        </a>
                        <a href="/GestionInventario/public/product" 
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>

            <!-- Columna lateral -->
            <div class="col-md-4">
                <!-- Imagen del producto -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-image"></i> Imagen
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= htmlspecialchars($product['image']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 class="img-fluid rounded">
                        <?php else: ?>
                            <div class="p-5 bg-light rounded">
                                <i class="bi bi-image" style="font-size: 5rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">Sin imagen</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-graph-up"></i> Estadísticas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Valor en Stock:</strong>
                            <p class="text-success fs-5">
                                $<?= number_format($product['price'] * $product['stock'], 2) ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <strong>Estado:</strong>
                            <p>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge text-bg-success">Disponible</span>
                                <?php else: ?>
                                    <span class="badge text-bg-danger">Agotado</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-lightning"></i> Acciones Rápidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="/GestionInventario/public/product/edit/<?= $product['id'] ?>" 
                           class="btn btn-warning btn-block mb-2 w-100">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="/GestionInventario/public/product/deleteAction/<?= $product['id'] ?>" 
                           class="btn btn-danger btn-block w-100"
                           onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                            <i class="bi bi-trash"></i> Eliminar
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>