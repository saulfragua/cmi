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

        public function actualizarSteam($id, $steam)
    {
        $sql = "UPDATE operadores 
                SET steam = :steam
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':steam' => $steam,
            ':id'    => $id
        ]);
    }

    public function obtenerPorId($id)
{
    $sql = "SELECT id, steam FROM operadores WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}
}