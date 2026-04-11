<?php

class Curso {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM cursos ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM cursos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($nombre, $sigla, $imagen) {
        $sql = "INSERT INTO cursos (nombre, sigla, imagen, estado) VALUES (?, ?, ?, 'Activo')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $sigla, $imagen]);
    }

    public function actualizar($id, $nombre, $sigla, $imagen = null) {
        if ($imagen) {
            $sql = "UPDATE cursos SET nombre = ?, sigla = ?, imagen = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nombre, $sigla, $imagen, $id]);
        } else {
            $sql = "UPDATE cursos SET nombre = ?, sigla = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nombre, $sigla, $id]);
        }
    }

    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE cursos SET estado = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$estado, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM cursos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}