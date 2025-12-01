<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Gestión de Usuarios</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
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

        <!-- Tabla de usuarios -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-people"></i> Lista de Usuarios
                </h3>
                <div class="card-tools">
                    <a href="<?= BASE_URL ?>user/create" class="btn btn-primary btn-sm">
                        <i class="bi bi-person-plus"></i> Nuevo Usuario
                    </a>
                </div>
            </div>

            <div class="card-body">
                <?php if (empty($users)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay usuarios registrados.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Fecha Creación</th>
                                    <th style="width: 150px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                                        <td>
                                            <?php if ($user['role'] === 'admin'): ?>
                                                <span class="badge text-bg-warning"><i class="bi bi-shield-fill-check"></i>
                                                    Administrador</span>
                                            <?php else: ?>
                                                <span class="badge text-bg-info"><i class="bi bi-person-badge"></i> Staff</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>user/edit/<?= $user['id'] ?>"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <a href="<?= BASE_URL ?>user/deleteAction/<?= $user['id'] ?>"
                                                    class="btn btn-sm btn-danger" title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-secondary" disabled
                                                    title="No puedes eliminar tu propia cuenta">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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
        if ($('#usersTable').length > 0) {
            $('#usersTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "pageLength": 10,
                "order": [[0, "asc"]],
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