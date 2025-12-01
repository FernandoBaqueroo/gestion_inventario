<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Nuevo Producto</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/product">Productos</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-plus-circle"></i> Datos del Producto
                        </h3>
                    </div>
                    
                    <form action="/GestionInventario/public/product/store" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            
                            <!-- Código -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Código del Producto <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="code" 
                                       name="code" 
                                       placeholder="Ej: PROD001"
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
                                       placeholder="Ej: Laptop HP 15 pulgadas"
                                       required>
                            </div>

                            <!-- Categoría -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">-- Seleccionar categoría --</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Proveedor -->
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Proveedor</label>
                                <select class="form-select" id="supplier_id" name="supplier_id">
                                    <option value="">-- Seleccionar proveedor --</option>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <option value="<?= $supplier['id'] ?>"><?= htmlspecialchars($supplier['company_name']) ?></option>
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
                                                   placeholder="0.00"
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
                                               placeholder="0"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Imagen del Producto -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Imagen del Producto</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="image" 
                                       name="image"
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="form-text text-muted">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB</small>
                                
                                <!-- Preview de la imagen -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>

                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Producto
                            </button>
                            <a href="/GestionInventario/public/product" class="btn btn-secondary">
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
                            <i class="bi bi-info-circle"></i> Ayuda
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Campos obligatorios:</strong></p>
                        <ul>
                            <li>Código del producto</li>
                            <li>Nombre</li>
                            <li>Precio</li>
                            <li>Stock</li>
                        </ul>
                        <hr>
                        <p class="mb-0"><small class="text-muted">Los campos marcados con <span class="text-danger">*</span> son obligatorios.</small></p>
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

