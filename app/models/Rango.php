<?php

class Rango {
    private $db;

    public function __construct() {
        // ✅ CORRECCIÓN AQUÍ
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM rangos ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM rangos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($nombre, $sigla, $imagen) {
        $stmt = $this->db->prepare("INSERT INTO rangos (nombre, sigla, imagen, estado) VALUES (?, ?, ?, 'Activo')");
        return $stmt->execute([$nombre, $sigla, $imagen]);
    }

    public function actualizar($id, $nombre, $sigla, $imagen = null) {
        if ($imagen) {
            $sql = "UPDATE rangos SET nombre = ?, sigla = ?, imagen = ? WHERE id = ?";
            return $this->db->prepare($sql)->execute([$nombre, $sigla, $imagen, $id]);
        } else {
            $sql = "UPDATE rangos SET nombre = ?, sigla = ? WHERE id = ?";
            return $this->db->prepare($sql)->execute([$nombre, $sigla, $id]);
        }
    }

    public function cambiarEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE rangos SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM rangos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}