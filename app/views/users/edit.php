<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Usuario</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>user">Usuarios</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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

                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Editar Información:
                            <strong><?= htmlspecialchars($user['username']) ?></strong></h3>
                    </div>

                    <form action="<?= BASE_URL ?>user/update/<?= $user['id'] ?>" method="POST">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="<?= htmlspecialchars($user['username']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required
                                    <?= ($user['id'] == $_SESSION['user_id']) ? 'disabled' : '' ?>>
                                    <option value="staff" <?= ($user['role'] === 'staff') ? 'selected' : '' ?>>Staff
                                        (Vendedor)</option>
                                    <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>
                                        Administrador</option>
                                </select>
                                <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                    <input type="hidden" name="role" value="<?= $user['role'] ?>">
                                    <div class="form-text text-warning">No puedes cambiar tu propio rol.</div>
                                <?php else: ?>
                                    <div class="form-text text-info">
                                        <i class="bi bi-info-circle"></i>
                                        <strong>Staff:</strong> Solo puede ver productos y realizar ventas.
                                        <strong>Admin:</strong> Control total del sistema.
                                    </div>
                                <?php endif; ?>
                            </div>

                            <hr>
                            <h5 class="mb-3 text-muted">Cambiar Contraseña (Opcional)</h5>
                            <div class="alert alert-light border">
                                <small><i class="bi bi-info-circle"></i> Deja estos campos vacíos si no deseas cambiar
                                    la contraseña.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" class="form-control" id="password" name="password"
                                            minlength="6">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirm" class="form-label">Confirmar Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" class="form-control" id="password_confirm"
                                            name="password_confirm" minlength="6">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Actualizar Usuario
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