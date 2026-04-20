<?php

class AuthModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerPorCodigo($codigo)
    {
        $sql = "SELECT 
                    id,
                    codigo,
                    clave,
                    foto_operador,
                    nombre_completo,
                    fecha_nacimiento,
                    rango_id,
                    pais,
                    telefono,
                    rol,
                    estado
                FROM operadores
                WHERE codigo = :codigo
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}