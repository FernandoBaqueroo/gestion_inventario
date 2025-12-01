<?php

class Sale extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'sales';
    }

    /**
     * Obtener todas las ventas con información del usuario
     */
    public function getAllWithDetails()
    {
        $query = "SELECT s.*, u.username 
                  FROM {$this->table} s
                  INNER JOIN users u ON s.user_id = u.id
                  ORDER BY s.sale_date DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener venta por ID con detalles
     */
    public function getSaleWithDetails($id)
    {
        // Obtener cabecera de la venta
        $query = "SELECT s.*, u.username 
                  FROM {$this->table} s
                  INNER JOIN users u ON s.user_id = u.id
                  WHERE s.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $sale = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sale) {
            return null;
        }

        // Obtener detalles de la venta
        $query = "SELECT sd.*, p.code, p.name as product_name 
                  FROM sale_details sd
                  INNER JOIN products p ON sd.product_id = p.id
                  WHERE sd.sale_id = :sale_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sale_id', $id);
        $stmt->execute();

        $sale['details'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $sale;
    }

    /**
     * Crear nueva venta con detalles (transacción)
     */
    public function createSale($userId, $items)
    {
        try {
            // Iniciar transacción
            $this->db->beginTransaction();

            // Calcular total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Insertar cabecera de venta
            $query = "INSERT INTO {$this->table} (user_id, total) VALUES (:user_id, :total)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':total', $total);
            $stmt->execute();

            $saleId = $this->db->lastInsertId();

            // Insertar detalles y actualizar stock
            $queryDetail = "INSERT INTO sale_details (sale_id, product_id, quantity, price, subtotal) 
                           VALUES (:sale_id, :product_id, :quantity, :price, :subtotal)";
            $stmtDetail = $this->db->prepare($queryDetail);

            $queryStock = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
            $stmtStock = $this->db->prepare($queryStock);

            foreach ($items as $item) {
                $subtotal = $item['price'] * $item['quantity'];

                // Insertar detalle
                $stmtDetail->bindParam(':sale_id', $saleId);
                $stmtDetail->bindParam(':product_id', $item['product_id']);
                $stmtDetail->bindParam(':quantity', $item['quantity']);
                $stmtDetail->bindParam(':price', $item['price']);
                $stmtDetail->bindParam(':subtotal', $subtotal);
                $stmtDetail->execute();

                // Reducir stock
                $stmtStock->bindParam(':quantity', $item['quantity']);
                $stmtStock->bindParam(':product_id', $item['product_id']);
                $stmtStock->execute();
            }

            // Confirmar transacción
            $this->db->commit();

            return $saleId;

        } catch (Exception $e) {
            // Revertir en caso de error
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Obtener ventas del día
     */
    public function getTodaySales()
    {
        $query = "SELECT COUNT(*) as total, SUM(total) as amount
                  FROM {$this->table}
                  WHERE DATE(sale_date) = CURDATE()";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener ventas del mes
     */
    public function getMonthSales()
    {
        $query = "SELECT COUNT(*) as total, SUM(total) as amount
                  FROM {$this->table}
                  WHERE YEAR(sale_date) = YEAR(CURDATE()) 
                  AND MONTH(sale_date) = MONTH(CURDATE())";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener ventas de los últimos 6 meses
     */
    public function getLastSixMonthsSales()
    {
        $query = "SELECT DATE_FORMAT(sale_date, '%Y-%m') as month, SUM(total) as total
                  FROM {$this->table}
                  WHERE sale_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                  GROUP BY DATE_FORMAT(sale_date, '%Y-%m')
                  ORDER BY month ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos más vendidos
     */
    public function getTopSellingProducts($limit = 5)
    {
        $query = "SELECT p.name, SUM(sd.quantity) as total_sold
                  FROM sale_details sd
                  JOIN products p ON sd.product_id = p.id
                  GROUP BY sd.product_id
                  ORDER BY total_sold DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

