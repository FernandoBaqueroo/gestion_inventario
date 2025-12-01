<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Producto</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>product">Productos</a></li>
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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                            <i class="bi bi-pencil"></i> Editar: <?= htmlspecialchars($product['name']) ?>
                        </h3>
                    </div>
                    
                    <form action="<?= BASE_URL ?>product/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            
                            <!-- Código -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Código del Producto <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="code" 
                                       name="code" 
                                       value="<?= htmlspecialchars($product['code']) ?>"
                                       required>
                                <small class="form-text text-muted">Código único (SKU o código de barras)</small>
                            </div>

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       value="<?= htmlspecialchars($product['name']) ?>"
                                       required>
                            </div>

                            <!-- Categoría -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">-- Seleccionar categoría --</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" 
                                                <?= ($product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Proveedor -->
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Proveedor</label>
                                <select class="form-select" id="supplier_id" name="supplier_id">
                                    <option value="">-- Seleccionar proveedor --</option>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <option value="<?= $supplier['id'] ?>"
                                                <?= ($product['supplier_id'] == $supplier['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($supplier['company_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <!-- Precio -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Precio <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="price" 
                                                   name="price" 
                                                   step="0.01"
                                                   min="0"
                                                   value="<?= $product['price'] ?>"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="stock" 
                                               name="stock" 
                                               min="0"
                                               value="<?= $product['stock'] ?>"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Imagen del Producto -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Imagen del Producto</label>
                                
                                <?php if (!empty($product['image'])): ?>
                                <div class="mb-2">
                                    <p class="text-muted">Imagen actual:</p>
                                    <img src="<?= htmlspecialchars($product['image']) ?>" 
                                         alt="Imagen actual" 
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                                <?php endif; ?>
                                
                                <input type="file" 
                                       class="form-control" 
                                       id="image" 
                                       name="image"
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="form-text text-muted">
                                    <?php if (!empty($product['image'])): ?>
                                        Deja vacío para mantener la imagen actual. 
                                    <?php endif; ?>
                                    Formatos: JPG, PNG, WEBP. Máximo: 2MB
                                </small>
                                
                                <!-- Preview de nueva imagen -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <p class="text-success"><i class="bi bi-check-circle"></i> Nueva imagen:</p>
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>

                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Actualizar Producto
                            </button>
                            <a href="<?= BASE_URL ?>product" class="btn btn-secondary">
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
                        <p><strong>Detalles del producto:</strong></p>
                        <ul class="list-unstyled">
                            <li><strong>ID:</strong> <?= $product['id'] ?></li>
                            <li><strong>Código:</strong> <?= htmlspecialchars($product['code']) ?></li>
                            <li><strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($product['created_at'])) ?></li>
                        </ul>
                        <hr>
                        <p class="mb-0"><small class="text-muted">Los cambios se guardarán inmediatamente al hacer clic en "Actualizar".</small></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
// Scripts específicos de esta página
ob_start();
?>
<script>
$(document).ready(function() {
    // Preview de imagen cuando se selecciona un archivo
    $('#image').on('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar tamaño (2MB máximo)
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen es muy grande. Máximo 2MB');
                $(this).val('');
                $('#imagePreview').hide();
                return;
            }
            
            // Validar tipo
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Tipo de archivo no válido. Solo JPG, PNG o WEBP');
                $(this).val('');
                $('#imagePreview').hide();
                return;
            }
            
            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });
});
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>

