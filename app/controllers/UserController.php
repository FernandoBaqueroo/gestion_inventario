<?php

class UserController extends Controller
{
    public function __construct()
    {
        AuthController::requireAuth();
    }

    /**
     * Listar todos los usuarios (solo Admin)
     */
    public function index()
    {
        AuthController::requireAdmin();

        $userModel = $this->model('User');
        $users = $userModel->getAll();

        $data = [
            'title' => 'Gestión de Usuarios - Sistema de Inventario',
            'users' => $users,
            'success' => $_SESSION['user_success'] ?? null,
            'error' => $_SESSION['user_error'] ?? null
        ];

        unset($_SESSION['user_success'], $_SESSION['user_error']);

        $this->view('users/index', $data);
    }

    /**
     * Mostrar formulario para crear usuario
     */
    public function create()
    {
        AuthController::requireAdmin();

        $data = [
            'title' => 'Nuevo Usuario',
            'error' => $_SESSION['user_error'] ?? null
        ];

        unset($_SESSION['user_error']);

        $this->view('users/create', $data);
    }

    /**
     * Guardar nuevo usuario
     */
    public function store()
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        // Validar datos
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $password_confirm = trim($_POST['password_confirm'] ?? '');
        $role = trim($_POST['role'] ?? 'staff');

        if (empty($username) || empty($password)) {
            $_SESSION['user_error'] = 'El nombre de usuario y contraseña son obligatorios';
            $this->redirect('' . BASE_URL . 'user/create');
            return;
        }

        if ($password !== $password_confirm) {
            $_SESSION['user_error'] = 'Las contraseñas no coinciden';
            $this->redirect('' . BASE_URL . 'user/create');
            return;
        }

        if (strlen($password) < 6) {
            $_SESSION['user_error'] = 'La contraseña debe tener al menos 6 caracteres';
            $this->redirect('' . BASE_URL . 'user/create');
            return;
        }

        // Verificar que el username no exista
        $userModel = $this->model('User');
        if ($userModel->findByUsername($username)) {
            $_SESSION['user_error'] = 'El nombre de usuario ya existe';
            $this->redirect('' . BASE_URL . 'user/create');
            return;
        }

        // Crear usuario
        if ($userModel->create($username, $password, $role)) {
            $_SESSION['user_success'] = 'Usuario creado exitosamente';
            $this->redirect('' . BASE_URL . 'user');
        } else {
            $_SESSION['user_error'] = 'Error al crear el usuario';
            $this->redirect('' . BASE_URL . 'user/create');
        }
    }

    /**
     * Mostrar formulario para editar usuario
     * 
     * @param array $params Parámetros de la URL (ID del usuario)
     */
    public function edit($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        $userModel = $this->model('User');
        $user = $userModel->findById($id);

        if (!$user) {
            $_SESSION['user_error'] = 'Usuario no encontrado';
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        $data = [
            'title' => 'Editar Usuario',
            'user' => $user,
            'error' => $_SESSION['user_error'] ?? null
        ];

        unset($_SESSION['user_error']);

        $this->view('users/edit', $data);
    }

    /**
     * Actualizar usuario
     * 
     * @param array $params Parámetros de la URL (ID del usuario)
     */
    public function update($params)
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        // Validar datos
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $password_confirm = trim($_POST['password_confirm'] ?? '');
        $role = trim($_POST['role'] ?? 'staff');

        if (empty($username)) {
            $_SESSION['user_error'] = 'El nombre de usuario es obligatorio';
            $this->redirect('' . BASE_URL . 'user/edit/' . $id);
            return;
        }

        // Si se proporciona contraseña, validarla
        if (!empty($password)) {
            if ($password !== $password_confirm) {
                $_SESSION['user_error'] = 'Las contraseñas no coinciden';
                $this->redirect('' . BASE_URL . 'user/edit/' . $id);
                return;
            }

            if (strlen($password) < 6) {
                $_SESSION['user_error'] = 'La contraseña debe tener al menos 6 caracteres';
                $this->redirect('' . BASE_URL . 'user/edit/' . $id);
                return;
            }
        }

        // Preparar datos
        $data = [
            'username' => $username,
            'role' => $role,
            'password' => $password
        ];

        // Actualizar usuario
        $userModel = $this->model('User');
        if ($userModel->updateUser($id, $data)) {
            $_SESSION['user_success'] = 'Usuario actualizado exitosamente';
            $this->redirect('' . BASE_URL . 'user');
        } else {
            $_SESSION['user_error'] = 'Error al actualizar el usuario';
            $this->redirect('' . BASE_URL . 'user/edit/' . $id);
        }
    }

    /**
     * Eliminar usuario
     * 
     * @param array $params Parámetros de la URL (ID del usuario)
     */
    public function deleteAction($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $_SESSION['user_error'] = 'ID no válido';
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        // No permitir eliminar el usuario actual
        if ($id == $_SESSION['user_id']) {
            $_SESSION['user_error'] = 'No puedes eliminar tu propia cuenta';
            $this->redirect('' . BASE_URL . 'user');
            return;
        }

        $userModel = $this->model('User');

        if ($userModel->deleteUser($id)) {
            $_SESSION['user_success'] = 'Usuario eliminado exitosamente';
        } else {
            $_SESSION['user_error'] = 'Error al eliminar el usuario';
        }

        $this->redirect('' . BASE_URL . 'user');
    }
}
