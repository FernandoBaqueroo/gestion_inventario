<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Categoría</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>category">Categorías</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        
        <!-- Mensaje de error -->
        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-pencil"></i> Editar: <?= htmlspecialchars($category['name']) ?>
                        </h3>
                    </div>
                    
                    <form action="<?= BASE_URL ?>category/update/<?= $category['id'] ?>" method="POST">
                        <div class="card-body">
                            
                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la Categoría <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       value="<?= htmlspecialchars($category['name']) ?>"
                                       required>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" 
                                          id="description" 
                                          name="description" 
                                          rows="4"><?= htmlspecialchars($category['description']) ?></textarea>
                            </div>

                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Actualizar Categoría
                            </button>
                            <a href="<?= BASE_URL ?>category" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info lateral -->
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Información
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Detalles:</strong></p>
                        <ul class="list-unstyled">
                            <li><strong>ID:</strong> <?= $category['id'] ?></li>
                            <li><strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($category['created_at'])) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>

