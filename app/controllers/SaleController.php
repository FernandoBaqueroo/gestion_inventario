<?php

class SaleController extends Controller
{
    public function __construct()
    {
        AuthController::requireAuth();
    }

    /**
     * Listar todas las ventas
     */
    public function index()
    {
        $saleModel = $this->model('Sale');
        $sales = $saleModel->getAllWithDetails();

        $data = [
            'title' => 'Ventas - Sistema de Inventario',
            'sales' => $sales,
            'success' => $_SESSION['sale_success'] ?? null,
            'error' => $_SESSION['sale_error'] ?? null
        ];

        unset($_SESSION['sale_success'], $_SESSION['sale_error']);

        $this->view('sales/index', $data);
    }

    /**
     * Mostrar interfaz de punto de venta
     */
    public function create()
    {
        $data = [
            'title' => 'Nueva Venta - Punto de Venta',
            'error' => $_SESSION['sale_error'] ?? null
        ];

        unset($_SESSION['sale_error']);

        $this->view('sales/create', $data);
    }

    /**
     * Buscar productos (AJAX)
     */
    public function searchProducts()
    {
        header('Content-Type: application/json');
        
        $search = $_GET['q'] ?? '';
        
        if (empty($search)) {
            echo json_encode([]);
            return;
        }

        // Obtener conexión a la base de datos
        $database = new Database();
        $conn = $database->connect();
        
        $query = "SELECT id, code, name, price, stock 
                  FROM products 
                  WHERE (code LIKE :search OR name LIKE :search) 
                  AND stock > 0
                  LIMIT 10";
        
        $stmt = $conn->prepare($query);
        $searchParam = "%{$search}%";
        $stmt->bindParam(':search', $searchParam);
        $stmt->execute();
        
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($products);
    }

    /**
     * Procesar venta
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/GestionInventario/public/sale');
            return;
        }

        // Obtener items del carrito (JSON)
        $itemsJson = $_POST['items'] ?? '';
        $items = json_decode($itemsJson, true);

        if (empty($items)) {
            $_SESSION['sale_error'] = 'El carrito está vacío';
            $this->redirect('/GestionInventario/public/sale/create');
            return;
        }

        // Crear venta
        try {
            $saleModel = $this->model('Sale');
            $saleId = $saleModel->createSale($_SESSION['user_id'], $items);

            if ($saleId) {
                $_SESSION['sale_success'] = 'Venta registrada exitosamente';
                $_SESSION['last_sale_id'] = $saleId;
                $this->redirect('/GestionInventario/public/sale/show/' . $saleId);
            } else {
                $_SESSION['sale_error'] = 'Error al registrar la venta. Verifica el stock disponible.';
                $this->redirect('/GestionInventario/public/sale/create');
            }
        } catch (Exception $e) {
            $_SESSION['sale_error'] = 'Error al registrar la venta: ' . $e->getMessage();
            $this->redirect('/GestionInventario/public/sale/create');
        }
    }

    /**
     * Ver detalle de una venta
     */
    public function show($params)
    {
        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('/GestionInventario/public/sale');
            return;
        }

        $saleModel = $this->model('Sale');
        $sale = $saleModel->getSaleWithDetails($id);

        if (!$sale) {
            $_SESSION['sale_error'] = 'Venta no encontrada';
            $this->redirect('/GestionInventario/public/sale');
            return;
        }

        $data = [
            'title' => 'Detalle de Venta #' . $sale['id'],
            'sale' => $sale
        ];

        $this->view('sales/show', $data);
    }

    /**
     * Vista de impresión/ticket
     */
    public function ticket($params)
    {
        $id = $params[0] ?? null;

        if (!$id) {
            $this->redirect('/GestionInventario/public/sale');
            return;
        }

        $saleModel = $this->model('Sale');
        $sale = $saleModel->getSaleWithDetails($id);

        if (!$sale) {
            $_SESSION['sale_error'] = 'Venta no encontrada';
            $this->redirect('/GestionInventario/public/sale');
            return;
        }

        $data = [
            'title' => 'Ticket de Venta #' . $sale['id'],
            'sale' => $sale
        ];

        $this->view('sales/ticket', $data);
    }
}

