<?php

class Novedad
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtener todas las novedades con datos del operador
     */
    public function obtenerTodas()
    {
        $sql = "SELECT 
                    n.*,
                    o.codigo,
                    o.nombre_completo
                FROM novedades n
                INNER JOIN operadores o ON n.operador_id = o.id
                ORDER BY n.fecha_registro DESC, n.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtener una novedad por ID
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                    n.*,
                    o.codigo,
                    o.nombre_completo
                FROM novedades n
                INNER JOIN operadores o ON n.operador_id = o.id
                WHERE n.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Obtener operadores activos y en reserva
     */
    public function obtenerOperadoresActivosYReserva()
    {
        $sql = "SELECT 
                    id, 
                    codigo, 
                    nombre_completo, 
                    estado
                FROM operadores
                WHERE estado IN ('Activo', 'Reserva')
                ORDER BY nombre_completo ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Crear novedad
     */
    public function crear($data)
    {
        $sql = "INSERT INTO novedades (
                    operador_id,
                    tipo,
                    nivel,
                    categoria,
                    descripcion,
                    observaciones,
                    estado,
                    registrado_por
                ) VALUES (
                    :operador_id,
                    :tipo,
                    :nivel,
                    :categoria,
                    :descripcion,
                    :observaciones,
                    :estado,
                    :registrado_por
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':operador_id'    => (int)$data['operador_id'],
            ':tipo'           => $data['tipo'],
            ':nivel'          => !empty($data['nivel']) ? $data['nivel'] : null,
            ':categoria'      => !empty($data['categoria']) ? $data['categoria'] : null,
            ':descripcion'    => $data['descripcion'],
            ':observaciones'  => !empty($data['observaciones']) ? $data['observaciones'] : null,
            ':estado'         => !empty($data['estado']) ? $data['estado'] : 'Activo',
            ':registrado_por' => !empty($data['registrado_por']) ? (int)$data['registrado_por'] : null
        ]);
    }

    /**
     * Actualizar novedad
     */
    public function actualizar($id, $data)
    {
        $sql = "UPDATE novedades SET
                    operador_id = :operador_id,
                    tipo = :tipo,
                    nivel = :nivel,
                    categoria = :categoria,
                    descripcion = :descripcion,
                    observaciones = :observaciones,
                    estado = :estado
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':operador_id'   => (int)$data['operador_id'],
            ':tipo'          => $data['tipo'],
            ':nivel'         => !empty($data['nivel']) ? $data['nivel'] : null,
            ':categoria'     => !empty($data['categoria']) ? $data['categoria'] : null,
            ':descripcion'   => $data['descripcion'],
            ':observaciones' => !empty($data['observaciones']) ? $data['observaciones'] : null,
            ':estado'        => $data['estado'],
            ':id'            => (int)$id
        ]);
    }

    /**
     * Anular novedad
     */
    public function anular($id, $motivo)
    {
        $sql = "UPDATE novedades SET
                    estado = 'Anulado',
                    fecha_anulacion = NOW(),
                    motivo_anulacion = :motivo
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id'     => (int)$id,
            ':motivo' => $motivo
        ]);
    }

    /**
     * Obtener novedades por operador
     */
    public function obtenerPorOperador($operadorId)
    {
        $sql = "SELECT *
                FROM novedades
                WHERE operador_id = :operador_id
                ORDER BY fecha_registro DESC, id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':operador_id', (int)$operadorId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Contar novedades por operador
     */
    public function contarPorOperador($operadorId)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM novedades
                WHERE operador_id = :operador_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':operador_id', (int)$operadorId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}