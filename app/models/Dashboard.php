<?php

class Dashboard
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // =========================
    // OPERADORES
    // =========================
    public function obtenerTotalOperadores()
    {
        $sql = "SELECT COUNT(*) AS total FROM operadores";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch();

        return (int)($resultado['total'] ?? 0);
    }

    public function obtenerOperadoresPorEstado()
    {
        $sql = "SELECT estado, COUNT(*) AS total
                FROM operadores
                GROUP BY estado
                ORDER BY estado ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerOperadoresPorRol()
    {
        $sql = "SELECT rol, COUNT(*) AS total
                FROM operadores
                GROUP BY rol
                ORDER BY rol ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerOperadoresPorRango()
    {
        $sql = "SELECT 
                    r.nombre AS rango,
                    COUNT(o.id) AS total
                FROM operadores o
                INNER JOIN rangos r ON r.id = o.rango_id
                GROUP BY r.id, r.nombre
                ORDER BY r.id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // =========================
    // FORMULARIOS
    // =========================
    public function obtenerTotalFormularios()
    {
        $sql = "SELECT COUNT(*) AS total FROM formulario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch();

        return (int)($resultado['total'] ?? 0);
    }

    public function obtenerFormulariosPorEstado()
    {
        $sql = "SELECT 
                    ef.nombre AS estado,
                    COUNT(f.id) AS total
                FROM formulario f
                INNER JOIN estados_formulario ef ON ef.id = f.estado_id
                GROUP BY ef.id, ef.nombre
                ORDER BY ef.id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}