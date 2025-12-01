<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Nuevo Usuario</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>user">Usuarios</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Información del Usuario</h3>
                    </div>

                    <form action="<?= BASE_URL ?>user/store" method="POST">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" required
                                        autofocus>
                                </div>
                                <div class="form-text">Nombre único para iniciar sesión.</div>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="staff">Staff (Vendedor)</option>
                                    <option value="admin">Administrador</option>
                                </select>
                                <div class="form-text text-info" id="roleHelp">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Staff:</strong> Solo puede ver productos y realizar ventas.
                                    <strong>Admin:</strong> Control total del sistema.
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Contraseña <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required minlength="6">
                                    </div>
                                    <div class="form-text">Mínimo 6 caracteres.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirm" class="form-label">Confirmar Contraseña <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" class="form-control" id="password_confirm"
                                            name="password_confirm" required minlength="6">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Usuario
                            </button>
                            <a href="<?= BASE_URL ?>user" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>