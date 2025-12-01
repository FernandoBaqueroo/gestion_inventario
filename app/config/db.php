<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct()
    {
        // Usar variables de entorno si existen (Railway), si no, usar valores locales (XAMPP)
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'inventory_system';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        $this->port = getenv('DB_PORT') ?: '3306';
    }

    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            // En producción no queremos mostrar el error exacto por seguridad, pero para debug es útil
            // echo 'Connection Error: ' . $e->getMessage();
            die('Error de conexión a la base de datos.');
        }

        return $this->conn;
    }
}