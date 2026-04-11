<?php

class Especialidad {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM especialidades ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM especialidades WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($nombre, $sigla, $imagen) {
        $sql = "INSERT INTO especialidades (nombre, sigla, imagen, estado) VALUES (?, ?, ?, 'Activo')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $sigla, $imagen]);
    }

    public function actualizar($id, $nombre, $sigla, $imagen = null) {
        if ($imagen) {
            $sql = "UPDATE especialidades SET nombre = ?, sigla = ?, imagen = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nombre, $sigla, $imagen, $id]);
        } else {
            $sql = "UPDATE especialidades SET nombre = ?, sigla = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nombre, $sigla, $id]);
        }
    }

    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE especialidades SET estado = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$estado, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM especialidades WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}