<?php

class Unidad {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodos() {
        return $this->db->query("SELECT * FROM unidades ORDER BY id DESC")->fetchAll();
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM unidades WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($nombre, $sigla, $imagen) {
        $stmt = $this->db->prepare("INSERT INTO unidades (nombre, sigla, imagen, estado) VALUES (?, ?, ?, 'Activo')");
        return $stmt->execute([$nombre, $sigla, $imagen]);
    }

    public function actualizar($id, $nombre, $sigla, $imagen = null) {
        if ($imagen) {
            $sql = "UPDATE unidades SET nombre = ?, sigla = ?, imagen = ? WHERE id = ?";
            return $this->db->prepare($sql)->execute([$nombre, $sigla, $imagen, $id]);
        } else {
            $sql = "UPDATE unidades SET nombre = ?, sigla = ? WHERE id = ?";
            return $this->db->prepare($sql)->execute([$nombre, $sigla, $id]);
        }
    }

    public function cambiarEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE unidades SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM unidades WHERE id = ?");
        return $stmt->execute([$id]);
    }
}