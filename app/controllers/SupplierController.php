<?php

class SupplierController extends Controller
{
    public function __construct()
    {
        AuthController::requireAuth();
    }

    /**
     * Listar todos los proveedores
     */
    public function index()
    {
        $supplierModel = $this->model('Supplier');
        $suppliers = $supplierModel->getAll();

        $data = [
            'title' => 'Proveedores - Sistema de Inventario',
            'suppliers' => $suppliers,
            'success' => $_SESSION['supplier_success'] ?? null,
            'error' => $_SESSION['supplier_error'] ?? null
        ];

        unset($_SESSION['supplier_success'], $_SESSION['supplier_error']);

        $this->view('suppliers/index', $data);
    }

    /**
     * Mostrar formulario para crear proveedor
     */
    public function create()
    {
        AuthController::requireAdmin();

        $data = [
            'title' => 'Nuevo Proveedor',
            'error' => $_SESSION['supplier_error'] ?? null
        ];

        unset($_SESSION['supplier_error']);

        $this->view('suppliers/create', $data);
    }

    /**
     * Guardar nuevo proveedor
     */
    public function store()
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        // Validar datos
        $company_name = trim($_POST['company_name'] ?? '');
        $contact_email = trim($_POST['contact_email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (empty($company_name)) {
            $_SESSION['supplier_error'] = 'El nombre de la empresa es obligatorio';
            $this->redirect('/GestionInventario/public/supplier/create');
            return;
        }

        // Preparar datos
        $data = [
            'company_name' => $company_name,
            'contact_email' => $contact_email,
            'phone' => $phone
        ];

        // Crear proveedor
        $supplierModel = $this->model('Supplier');
        if ($supplierModel->create($data)) {
            $_SESSION['supplier_success'] = 'Proveedor creado exitosamente';
            $this->redirect('/GestionInventario/public/supplier');
        } else {
            $_SESSION['supplier_error'] = 'Error al crear el proveedor';
            $this->redirect('/GestionInventario/public/supplier/create');
        }
    }

    /**
     * Mostrar formulario para editar proveedor
     * 
     * @param array $params Parámetros de la URL (ID del proveedor)
     */
    public function edit($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        $supplierModel = $this->model('Supplier');
        $supplier = $supplierModel->getById($id);

        if (!$supplier) {
            $_SESSION['supplier_error'] = 'Proveedor no encontrado';
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        $data = [
            'title' => 'Editar Proveedor',
            'supplier' => $supplier,
            'error' => $_SESSION['supplier_error'] ?? null
        ];

        unset($_SESSION['supplier_error']);

        $this->view('suppliers/edit', $data);
    }

    /**
     * Actualizar proveedor
     * 
     * @param array $params Parámetros de la URL (ID del proveedor)
     */
    public function update($params)
    {
        AuthController::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        // Validar datos
        $company_name = trim($_POST['company_name'] ?? '');
        $contact_email = trim($_POST['contact_email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (empty($company_name)) {
            $_SESSION['supplier_error'] = 'El nombre de la empresa es obligatorio';
            $this->redirect('/GestionInventario/public/supplier/edit/' . $id);
            return;
        }

        // Preparar datos
        $data = [
            'company_name' => $company_name,
            'contact_email' => $contact_email,
            'phone' => $phone
        ];

        // Actualizar proveedor
        $supplierModel = $this->model('Supplier');
        if ($supplierModel->update($id, $data)) {
            $_SESSION['supplier_success'] = 'Proveedor actualizado exitosamente';
            $this->redirect('/GestionInventario/public/supplier');
        } else {
            $_SESSION['supplier_error'] = 'Error al actualizar el proveedor';
            $this->redirect('/GestionInventario/public/supplier/edit/' . $id);
        }
    }

    /**
     * Eliminar proveedor
     * 
     * @param array $params Parámetros de la URL (ID del proveedor)
     */
    public function deleteAction($params)
    {
        AuthController::requireAdmin();

        $id = $params[0] ?? null;

        if (!$id) {
            $_SESSION['supplier_error'] = 'ID no válido';
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        $supplierModel = $this->model('Supplier');

        // Verificar si hay productos asociados a este proveedor
        $productModel = $this->model('Product');
        $products = $productModel->getAll();

        $hasProducts = false;
        foreach ($products as $product) {
            if ($product['supplier_id'] == $id) {
                $hasProducts = true;
                break;
            }
        }

        if ($hasProducts) {
            $_SESSION['supplier_error'] = 'No se puede eliminar el proveedor porque tiene productos asociados. Primero elimine o reasigne los productos.';
            $this->redirect('/GestionInventario/public/supplier');
            return;
        }

        if ($supplierModel->delete($id)) {
            $_SESSION['supplier_success'] = 'Proveedor eliminado exitosamente';
        } else {
            $_SESSION['supplier_error'] = 'Error al eliminar el proveedor';
        }

        $this->redirect('/GestionInventario/public/supplier');
    }
}
