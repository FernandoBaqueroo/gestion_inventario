<?php

class AuthController extends Controller
{
    /**
     *! Mostrar formulario de login
     */
    public function login()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('' . BASE_URL . '');
        }

        // Mostrar vista de login
        $data = [
            'title' => 'Login - Sistema de Inventario',
            'error' => $_SESSION['login_error'] ?? null
        ];

        // Limpiar mensaje de error después de mostrarlo
        unset($_SESSION['login_error']);

        $this->view('auth/login', $data);
    }

    /**
     *! Procesar login (POST)
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('' . BASE_URL . 'auth/login');
            return;
        }

        // Obtener datos del formulario
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validar campos vacíos
        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Por favor, completa todos los campos';
            $this->redirect('' . BASE_URL . 'auth/login');
            return;
        }

        // Buscar usuario
        $userModel = $this->model('User');
        $user = $userModel->findByUsername($username);

        // Verificar si existe y la contraseña es correcta
        if (!$user || !$userModel->verifyPassword($password, $user['password'])) {
            $_SESSION['login_error'] = 'Usuario o contraseña incorrectos';
            $this->redirect('' . BASE_URL . 'auth/login');
            return;
        }

        // Login exitoso - Guardar datos en sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();

        // Redirigir al dashboard
        $this->redirect('' . BASE_URL . '');
    }

    /**
     *! Cerrar sesión
     */
    public function logout()
    {
        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Destruir la sesión
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        session_destroy();

        // Redirigir al login
        $this->redirect('' . BASE_URL . 'auth/login');
    }

    /**
     *! Verificar si el usuario está autenticado
     */
    public static function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     *! Verificar si el usuario es admin
     */
    public static function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     *! Verificar si el usuario es staff
     */
    public static function isStaff()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'staff';
    }

    /**
     *! Middleware: Requerir autenticación
     */
    public static function requireAuth()
    {
        if (!self::isAuthenticated()) {
            $_SESSION['login_error'] = 'Debes iniciar sesión para acceder';
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }

    /**
     *! Middleware: Requerir rol de administrador
     */
    public static function requireAdmin()
    {
        self::requireAuth(); // Primero verificar autenticación

        if (!self::isAdmin()) {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección';
            header('Location: ' . BASE_URL . '');
            exit;
        }
    }

    /**
     *! Verificar si el usuario tiene un permiso específico
     */
    public static function hasPermission($permission)
    {
        // Admin tiene todos los permisos
        if (self::isAdmin()) {
            return true;
        }

        // Permisos para Staff
        $staffPermissions = [
            'view_products',
            'view_sales',
            'create_sales',
            'view_dashboard'
        ];

        return in_array($permission, $staffPermissions);
    }
}