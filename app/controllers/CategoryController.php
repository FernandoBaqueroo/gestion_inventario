<?php

class CategoryController extends Controller
{

    public function __construct()
    {
        AuthController::requireAuth();
    }

    /**
     * Listar todas las categorías
     */
    public function index()
    {
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getAll();

        $data = [
            'title' => 'Categorías - Sistema de Inventario',
            'categories' => $categories,
            'success' => $_SESSION['category_success'] ?? null,
            'error' => $_SESSION['category_error'] ?? null
        ];

        unset($_SESSION['category_success'], $_SESSION['category_error']);

        $this->view('categories/index', $data);
    }

    /**
     * Mostrar formulario para crear categoría
     */
    public function create()
    {
        AuthController::requireAdmin();

        $categoryModel = $this->model('Category');

        $data = [
            'title' => 'Nueva Categoría',
            'error' => $_SESSION['category_error'] ?? null
        ];

        unset($_SESSION['category_error']);

        $this->view('categories/create', $data);
    }

    /**
     * Guardar nueva categoría
     */
    public function store()
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        //! 1. Validar los datos
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name) || empty($description)) {
            $_SESSION['category_error'] = 'Todos los campos obligatorios deben ser completados';
            $this->redirect('' . BASE_URL . 'category/create');
            return;
        }

        //! 2. Verificar que el nombre no exista
        $categoryModel = $this->model('Category');
        if ($categoryModel->getByName($name)) {
            $_SESSION['category_error'] = 'El nombre de la categoría ya existe';
            $this->redirect('' . BASE_URL . 'category/create');
            return;
        }

        //! 3. Preparar los datos
        $data = [
            'name' => $name,
            'description' => $description
        ];

        //! 4. Crear la categoría
        if ($categoryModel->create($data)) {
            $_SESSION['category_success'] = 'Categoría creada exitosamente';
            $this->redirect('' . BASE_URL . 'category');
        } else {
            $_SESSION['category_error'] = 'Error al crear la categoría';
            $this->redirect('' . BASE_URL . 'category/create');
        }
    }

    /**
     * Mostrar formulario de edicion
     *
     * @param array $params Parámetros de la URL (ID de la categoría)
     */
    public function edit($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        $categoryModel = $this->model('Category');
        $category = $categoryModel->getById($id);

        if (!$category) {
            $_SESSION['category_error'] = 'Categoría no encontrada';
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        $data = [
            'title' => 'Editar Categoría',
            'category' => $category,
            'error' => $_SESSION['category_error'] ?? null
        ];

        unset($_SESSION['category_error']);

        $this->view('categories/edit', $data);
    }

    /**
     * Actualizar categoría
     *
     * @param array $params Parámetros de la URL (ID de la categoría)
     */
    public function update($params)
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        // Validar datos
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['category_error'] = 'El nombre es obligatorio';
            $this->redirect('' . BASE_URL . 'category/edit/' . $id);
            return;
        }

        // Preparar datos
        $data = [
            'name' => $name,
            'description' => $description
        ];

        // Actualizar categoría
        $categoryModel = $this->model('Category');
        if ($categoryModel->update($id, $data)) {
            $_SESSION['category_success'] = 'Categoría actualizada exitosamente';
            $this->redirect('' . BASE_URL . 'category');
        } else {
            $_SESSION['category_error'] = 'Error al actualizar la categoría';
            $this->redirect('' . BASE_URL . 'category/edit/' . $id);
        }
    }

    /**
     * Eliminar categoría
     *
     * @param array $params Parámetros de la URL (ID de la categoría)
     */
    public function deleteAction($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $_SESSION['category_error'] = 'ID no válido';
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        $categoryModel = $this->model('Category');

        // Verificar si hay productos asociados a esta categoría
        $productModel = $this->model('Product');
        $products = $productModel->getAll();

        $hasProducts = false;
        foreach ($products as $product) {
            if ($product['category_id'] == $id) {
                $hasProducts = true;
                break;
            }
        }

        if ($hasProducts) {
            $_SESSION['category_error'] = 'No se puede eliminar la categoría porque tiene productos asociados. Primero elimine o reasigne los productos.';
            $this->redirect('' . BASE_URL . 'category');
            return;
        }

        if ($categoryModel->delete($id)) {
            $_SESSION['category_success'] = 'Categoría eliminada exitosamente';
        } else {
            $_SESSION['category_error'] = 'Error al eliminar la categoría';
        }

        $this->redirect('' . BASE_URL . 'category');
    }
}