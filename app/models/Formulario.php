<?php

class Formulario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function crear($datos)
    {
        $sql = "INSERT INTO formulario 
                (nombre_completo, fecha_nacimiento, pais, telefono, estado_id, motivo)
                VALUES (:nombre, :fecha, :pais, :telefono, 1, :motivo)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':fecha' => $datos['fecha'],
            ':pais' => $datos['pais'],
            ':telefono' => $datos['telefono'],
            ':motivo' => $datos['motivo'] ?? null
        ]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT f.*, e.nombre AS estado
                FROM formulario f
                INNER JOIN estados_formulario e ON f.estado_id = e.id
                ORDER BY f.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT f.*, e.nombre AS estado
                FROM formulario f
                INNER JOIN estados_formulario e ON f.estado_id = e.id
                WHERE f.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    public function cambiarEstado($id, $estado, $observaciones, $evaluador)
    {
        $sql = "UPDATE formulario
                SET estado_id = :estado,
                    observaciones = :observaciones,
                    evaluado_por = :evaluador
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado' => $estado,
            ':observaciones' => $observaciones,
            ':evaluador' => $evaluador,
            ':id' => $id
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM formulario WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function contarPorEstado()
    {
        $sql = "SELECT estado_id, COUNT(*) AS total
                FROM formulario
                GROUP BY estado_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorEstado($estado_id)
    {
        $sql = "SELECT f.*, e.nombre AS estado
                FROM formulario f
                INNER JOIN estados_formulario e ON f.estado_id = e.id
                WHERE f.estado_id = :estado
                ORDER BY f.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':estado' => $estado_id
        ]);

        return $stmt->fetchAll();
    }
}