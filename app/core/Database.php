<?php

class Database {

    private static $instance = null;
    private $conexion;

    private $host = "localhost";
    private $db_name = "cmi";
    private $username = "root";
    private $password = "";
    private $charset = "utf8mb4";

    private function __construct() {

        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";

        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->conexion = new PDO($dsn, $this->username, $this->password, $opciones);
        } catch (PDOException $e) {
            die("❌ Error de conexión: " . $e->getMessage());
        }
    }

    // 🔁 Singleton (una sola conexión en todo el sistema)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conexion;
    }
}