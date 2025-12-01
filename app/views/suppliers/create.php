<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Nuevo Proveedor</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/supplier">Proveedores</a></li>
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
        <div class="alert alert-danger alert-dismissible fade show">
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
                            <i class="bi bi-plus-circle"></i> Datos del Proveedor
                        </h3>
                    </div>
                    
                    <form action="/GestionInventario/public/supplier/store" method="POST">
                        <div class="card-body">
                            
                            <!-- Nombre de la empresa -->
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Nombre de la Empresa <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="company_name" 
                                       name="company_name" 
                                       placeholder="Ej: TechSupply Corp"
                                       required
                                       autofocus>
                            </div>

                            <!-- Email de contacto -->
                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Email de Contacto</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="contact_email" 
                                       name="contact_email" 
                                       placeholder="contacto@empresa.com">
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone" 
                                       placeholder="555-0001">
                            </div>

                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Proveedor
                            </button>
                            <a href="/GestionInventario/public/supplier" class="btn btn-secondary">
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
                            <li>Nombre de la empresa</li>
                        </ul>
                        <hr>
                        <p><strong>Campos opcionales:</strong></p>
                        <ul>
                            <li>Email de contacto</li>
                            <li>Teléfono</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>

