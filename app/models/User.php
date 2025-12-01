<?php

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    /**
     * Buscar usuario por username
     * 
     * @param string $username Nombre de usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public function findByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar usuario por ID (sobrescribe el método de Model para personalizar)
     * 
     * @param int $id ID del usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los usuarios (sobrescribe getAll para excluir la contraseña)
     * 
     * @return array Lista de usuarios
     */
    public function getAll()
    {
        $query = "SELECT id, username, role, created_at FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear nuevo usuario
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña (sin hashear)
     * @param string $role Rol del usuario (admin/staff)
     * @return bool Resultado de la operación
     */
    public function create($username, $password, $role = 'staff')
    {
        $query = "INSERT INTO " . $this->table . " (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->db->prepare($query);

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    /**
     * Verificar contraseña
     * 
     * @param string $password Contraseña ingresada
     * @param string $hashedPassword Hash almacenado
     * @return bool True si coincide, False si no
     */
    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Actualizar usuario
     * 
     * @param int $id ID del usuario
     * @param array $data Datos a actualizar (username, role, password opcional)
     * @return bool Resultado de la operación
     */
    public function updateUser($id, $data)
    {
        $query = "UPDATE " . $this->table . " SET username = :username, role = :role";

        // Solo actualizar contraseña si se proporciona
        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id);

        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        return $stmt->execute();
    }

    /**
     * Eliminar usuario
     * 
     * @param int $id ID del usuario
     * @return bool Resultado de la operación
     */
    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}