<?php

require_once ROOT . '/app/core/Database.php'; // SOLO esto si necesitas la conexión

class Formulario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function guardar($data)
    {
        $sql = "INSERT INTO formulario 
                (nombre_completo, fecha_nacimiento, pais, telefono) 
                VALUES 
                (:nombre, :fecha_nacimiento, :pais, :telefono)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':pais' => $data['pais'],
            ':telefono' => $data['telefono']
        ]);
    }
}