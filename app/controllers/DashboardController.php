<?php

class DashboardController extends Controller
{

    /**
     *! Constructor
     */
    public function __construct()
    {
        // Requerir autenticación para acceder al dashboard
        AuthController::requireAuth();
    }

    /**
     *! Mostrar dashboard
     */
    public function index()
    {
        // Obtener estadísticas
        $productModel = $this->model('Product');
        $products = $productModel->getAll();

        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getAll();

        $supplierModel = $this->model('Supplier');
        $suppliers = $supplierModel->getAll();

        //! Obtener productos con un stock por debajo de 10 (permite alertar para reponer)
        $lowStockProducts = $productModel->getLowStock(10);

        //! Obtener estadísticas de ventas
        $saleModel = $this->model('Sale');
        $salesMonth = $saleModel->getMonthSales();
        $salesHistory = $saleModel->getLastSixMonthsSales();
        $topProducts = $saleModel->getTopSellingProducts();

        //! Obtener tipos de cambio
        require_once __DIR__ . '/../services/ExchangeRateService.php';
        $exchangeService = new ExchangeRateService();
        $exchangeRates = $exchangeService->getMultipleRates('USD', ['EUR', 'GBP', 'MXN']);

        $data = [
            'title' => 'Dashboard - Sistema de Inventario',
            'welcome_message' => 'Bienvenido ' . $_SESSION['username'],
            'total_products' => count($products),
            'total_categories' => count($categories),
            'total_suppliers' => count($suppliers),
            'total_sales' => $salesMonth['total'] ?? 0,
            'low_stock_products' => $lowStockProducts,
            'sales_history' => $salesHistory,
            'top_products' => $topProducts,
            'exchange_rates' => $exchangeRates
        ];
        $this->view('dashboard/index', $data);
    }
}