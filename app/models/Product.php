<?php

class Product extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'products';
    }

    /**
     * Obtener todos los productos con información de categoría y proveedor
     */
    public function getAllWithDetails()
    {
        $query = "SELECT p.*, 
                         c.name as category_name, 
                         s.company_name as supplier_name 
                  FROM {$this->table} p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN suppliers s ON p.supplier_id = s.id
                  ORDER BY p.id DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar producto por ID con detalles
     */
    public function getByIdWithDetails($id)
    {
        $query = "SELECT p.*, 
                         c.name as category_name, 
                         s.company_name as supplier_name 
                  FROM {$this->table} p
                  LEFT JOIN categories c ON p.category_id = c.id
                  LEFT JOIN suppliers s ON p.supplier_id = s.id
                  WHERE p.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar producto por código
     */
    public function findByCode($code)
    {
        $query = "SELECT * FROM {$this->table} WHERE code = :code LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crear nuevo producto
     */
    public function create($data)
    {
        $query = "INSERT INTO {$this->table} 
                  (category_id, supplier_id, code, name, price, stock, image) 
                  VALUES (:category_id, :supplier_id, :code, :name, :price, :stock, :image)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':supplier_id', $data['supplier_id']);
        $stmt->bindParam(':code', $data['code']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':image', $data['image']);
        
        return $stmt->execute();
    }

    /**
     * Actualizar producto
     */
    public function update($id, $data)
    {
        $query = "UPDATE {$this->table} 
                  SET category_id = :category_id,
                      supplier_id = :supplier_id,
                      code = :code,
                      name = :name,
                      price = :price,
                      stock = :stock,
                      image = :image
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':supplier_id', $data['supplier_id']);
        $stmt->bindParam(':code', $data['code']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':image', $data['image']);
        
        return $stmt->execute();
    }

    /**
     * Obtener productos con stock bajo
     */
    public function getLowStock($limit = 10)
    {
        $query = "SELECT * FROM {$this->table} WHERE stock < :limit ORDER BY stock ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}