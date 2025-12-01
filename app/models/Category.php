<?php

class Category extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'categories';
    }

    /**
     * Obtener todas las categorías
     */
    public function getAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByName($name)
    {
        $query = "SELECT * FROM {$this->table} WHERE name = :name LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $query = "UPDATE {$this->table} SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);

        return $stmt->execute();
    }
}

