<?php

class Pais
{
    private $db;

    public function __construct()
    {
        // 🔥 TU FORMA CORRECTA DE CONEXIÓN (según tu Database.php)
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerActivos()
    {
        $sql = "SELECT id, nombre, bandera, indicativo
                FROM paises
                WHERE estado = 'Activo'
                ORDER BY nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}