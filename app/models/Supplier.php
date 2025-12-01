<?php

class Supplier extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'suppliers';
    }

    /**
     * Obtener todos los proveedores
     */
    public function getAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY company_name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear nuevo proveedor
     */
    public function create($data)
    {
        $query = "INSERT INTO {$this->table} (company_name, contact_email, phone) 
                  VALUES (:company_name, :contact_email, :phone)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':company_name', $data['company_name']);
        $stmt->bindParam(':contact_email', $data['contact_email']);
        $stmt->bindParam(':phone', $data['phone']);
        
        return $stmt->execute();
    }

    /**
     * Actualizar proveedor
     */
    public function update($id, $data)
    {
        $query = "UPDATE {$this->table} 
                  SET company_name = :company_name,
                      contact_email = :contact_email,
                      phone = :phone
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':company_name', $data['company_name']);
        $stmt->bindParam(':contact_email', $data['contact_email']);
        $stmt->bindParam(':phone', $data['phone']);
        
        return $stmt->execute();
    }
}


