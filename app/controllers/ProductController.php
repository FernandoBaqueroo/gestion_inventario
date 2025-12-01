<?php

class ProductController extends Controller
{
    public function __construct()
    {
        // Requerir autenticación
        AuthController::requireAuth();
    }

    /**
     * Listar todos los productos
     */
    public function index()
    {
        $productModel = $this->model('Product');
        $products = $productModel->getAllWithDetails();

        $data = [
            'title' => 'Productos - Sistema de Inventario',
            'products' => $products,
            'success' => $_SESSION['product_success'] ?? null,
            'error' => $_SESSION['product_error'] ?? null
        ];

        unset($_SESSION['product_success'], $_SESSION['product_error']);

        $this->view('products/index', $data);
    }

    /**
     * Mostrar formulario para crear producto
     */
    public function create()
    {
        AuthController::requireAdmin();

        $categoryModel = $this->model('Category');
        $supplierModel = $this->model('Supplier');

        $data = [
            'title' => 'Nuevo Producto',
            'categories' => $categoryModel->getAll(),
            'suppliers' => $supplierModel->getAll(),
            'error' => $_SESSION['product_error'] ?? null
        ];

        unset($_SESSION['product_error']);

        $this->view('products/create', $data);
    }

    /**
     * Guardar nuevo producto
     */
    public function store()
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        //! Validar datos
        $code = trim($_POST['code'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $stock = trim($_POST['stock'] ?? '');

        if (empty($code) || empty($name) || empty($price) || empty($stock)) {
            $_SESSION['product_error'] = 'Todos los campos obligatorios deben ser completados';
            $this->redirect('/GestionInventario/public/product/create');
            return;
        }

        //! Verificar que el código no exista
        $productModel = $this->model('Product');
        if ($productModel->findByCode($code)) {
            $_SESSION['product_error'] = 'El código del producto ya existe';
            $this->redirect('/GestionInventario/public/product/create');
            return;
        }

        //! Preparar datos
        $data = [
            'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
            'supplier_id' => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
            'code' => $code,
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
            'image' => $this->uploadImage($_FILES['image'] ?? [], $code)
        ];

        //! Crear producto
        if ($productModel->create($data)) {
            $_SESSION['product_success'] = 'Producto creado exitosamente';
            $this->redirect('/GestionInventario/public/product');
        } else {
            $_SESSION['product_error'] = 'Error al crear el producto';
            $this->redirect('/GestionInventario/public/product/create');
        }
    }

    /**
     * Mostrar formulario para editar producto
     * 
     * @param array $params Parámetros de la URL (ID del producto)
     */
    public function edit($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        $productModel = $this->model('Product');
        $product = $productModel->getByIdWithDetails($id);

        if (!$product) {
            $_SESSION['product_error'] = 'Producto no encontrado';
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        $categoryModel = $this->model('Category');
        $supplierModel = $this->model('Supplier');

        $data = [
            'title' => 'Editar Producto',
            'product' => $product,
            'categories' => $categoryModel->getAll(),
            'suppliers' => $supplierModel->getAll(),
            'error' => $_SESSION['product_error'] ?? null
        ];

        unset($_SESSION['product_error']);

        $this->view('products/edit', $data);
    }

    /**
     * Actualizar producto
     * 
     * @param array $params Parámetros de la URL (ID del producto)
     */
    public function update($params)
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        // Obtener el producto actual de la base de datos
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        if (!$product) {
            $_SESSION['product_error'] = 'Producto no encontrado';
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        // Validar datos
        $code = trim($_POST['code'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $stock = trim($_POST['stock'] ?? '');

        if (empty($code) || empty($name) || empty($price) || empty($stock)) {
            $_SESSION['product_error'] = 'Todos los campos obligatorios deben ser completados';
            $this->redirect('/GestionInventario/public/product/edit/' . $id);
            return;
        }

        // Si hay nueva imagen, eliminar la anterior
        if (!empty($_FILES['image']['tmp_name']) && !empty($product['image'])) {
            $this->deleteImage($product['image']);
        }

        // Preparar datos
        $data = [
            'category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
            'supplier_id' => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
            'code' => $code,
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
            'image' => !empty($_FILES['image']['tmp_name'])
                ? $this->uploadImage($_FILES['image'], $code)
                : $product['image']
        ];

        // Actualizar producto
        if ($productModel->update($id, $data)) {
            $_SESSION['product_success'] = 'Producto actualizado exitosamente';
            $this->redirect('/GestionInventario/public/product');
        } else {
            $_SESSION['product_error'] = 'Error al actualizar el producto';
            $this->redirect('/GestionInventario/public/product/edit/' . $id);
        }
    }

    /**
     * Eliminar producto
     * 
     * @param array $params Parámetros de la URL (ID del producto)
     */
    public function deleteAction($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $_SESSION['product_error'] = 'ID no válido';
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        $productModel = $this->model('Product');

        if ($productModel->delete($id)) {
            $_SESSION['product_success'] = 'Producto eliminado exitosamente';
        } else {
            $_SESSION['product_error'] = 'Error al eliminar el producto';
        }

        $this->redirect('/GestionInventario/public/product');
    }

    /**
     * Mostrar detalles de un producto
     * 
     * @param array $params Parámetros de la URL (ID del producto)
     */
    public function show($params)
    {
        $id = $params[0] ?? null;

        if (!$id) {
            $_SESSION['product_error'] = 'ID no válido';
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        $productModel = $this->model('Product');
        $product = $productModel->getByIdWithDetails($id);

        if (!$product) {
            $_SESSION['product_error'] = 'Producto no encontrado';
            $this->redirect('/GestionInventario/public/product');
            return;
        }

        $data = [
            'title' => 'Detalle del producto - ' . $product['name'],
            'product' => $product
        ];

        $this->view('products/show', $data);
    }

    /**
     * Subir imagen de producto
     * 
     * @param array $file Archivo de imagen desde $_FILES
     * @param string $productCode Código del producto para nombre identificativo
     * @return string Ruta de la imagen subida o cadena vacía
     */
    private function uploadImage($file, $productCode = '')
    {
        //! 1. Validar que se haya subido un archivo
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return '';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        //! 2. Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['product_error'] = 'Tipo de archivo no permitido. Solo JPG, PNG o WEBP';
            return '';
        }

        //! 3. Validar tamaño (máximo 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $_SESSION['product_error'] = 'La imagen es muy grande. Máximo 2MB';
            return '';
        }

        //! 4. Generar nombre identificativo
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Limpiar el código del producto para usarlo en el nombre
        $cleanCode = !empty($productCode) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $productCode) : 'product';

        // Nombre: codigo-producto_timestamp.jpg
        $fileName = $cleanCode . '_' . time() . '.' . $extension;
        $uploadPath = '../public/uploads/products/';
        $fullPath = $uploadPath . $fileName;

        //! 5. Crear directorio si no existe
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        //! 6. Mover archivo
        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            return '/GestionInventario/public/uploads/products/' . $fileName;
        }

        return '';
    }

    /**
     * Eliminar imagen antigua
     * 
     * @param string $imagePath Ruta relativa de la imagen
     */
    private function deleteImage($imagePath)
    {
        if (empty($imagePath)) {
            return;
        }

        //! 1. Convertir ruta web a ruta del sistema
        $filePath = str_replace('/GestionInventario/public/', '../public/', $imagePath);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
