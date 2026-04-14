<?php

class Operador
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function existeOperador($nombre, $fecha, $telefono)
    {
        $sql = "SELECT id
                FROM operadores
                WHERE nombre_completo = :nombre
                  AND fecha_nacimiento = :fecha
                  AND telefono = :telefono
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':fecha' => $fecha,
            ':telefono' => $telefono
        ]);

        return $stmt->fetch();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    TIMESTAMPDIFF(YEAR, o.fecha_nacimiento, CURDATE()) AS edad,
                    (
                        SELECT e.nombre
                        FROM operador_especialidad oe
                        INNER JOIN especialidades e ON oe.especialidad_id = e.id
                        WHERE oe.operador_id = o.id
                          AND oe.principal = 1
                        LIMIT 1
                    ) AS especialidad_principal,
                    (
                        SELECT GROUP_CONCAT(DISTINCT u.nombre SEPARATOR ', ')
                        FROM operador_unidad ou
                        INNER JOIN unidades u ON ou.unidad_id = u.id
                        WHERE ou.operador_id = o.id
                    ) AS unidades,
                    (
                        SELECT GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ')
                        FROM operador_curso oc
                        INNER JOIN cursos c ON oc.curso_id = c.id
                        WHERE oc.operador_id = o.id
                    ) AS cursos
                FROM operadores o
                LEFT JOIN rangos r ON o.rango_id = r.id
                ORDER BY o.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    TIMESTAMPDIFF(YEAR, o.fecha_nacimiento, CURDATE()) AS edad,
                    (
                        SELECT e.nombre
                        FROM operador_especialidad oe
                        INNER JOIN especialidades e ON oe.especialidad_id = e.id
                        WHERE oe.operador_id = o.id
                          AND oe.principal = 1
                        LIMIT 1
                    ) AS especialidad_principal,
                    (
                        SELECT GROUP_CONCAT(DISTINCT e.sigla SEPARATOR ', ')
                        FROM operador_especialidad oe
                        INNER JOIN especialidades e ON oe.especialidad_id = e.id
                        WHERE oe.operador_id = o.id
                    ) AS especialidades,
                    (
                        SELECT GROUP_CONCAT(DISTINCT u.nombre SEPARATOR ', ')
                        FROM operador_unidad ou
                        INNER JOIN unidades u ON ou.unidad_id = u.id
                        WHERE ou.operador_id = o.id
                    ) AS unidades,
                    (
                        SELECT GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ')
                        FROM operador_curso oc
                        INNER JOIN cursos c ON oc.curso_id = c.id
                        WHERE oc.operador_id = o.id
                    ) AS cursos
                FROM operadores o
                LEFT JOIN rangos r ON o.rango_id = r.id
                WHERE o.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    public function crear($datos)
    {
        $sql = "INSERT INTO operadores (
                    codigo,
                    foto_operador,
                    nombre_completo,
                    fecha_nacimiento,
                    rango_id,
                    fecha_ultimo_ascenso,
                    pais,
                    telefono,
                    rol,
                    estado,
                    usuario_actualiza,
                    clave
                ) VALUES (
                    :codigo,
                    :foto_operador,
                    :nombre_completo,
                    :fecha_nacimiento,
                    :rango_id,
                    :fecha_ultimo_ascenso,
                    :pais,
                    :telefono,
                    :rol,
                    :estado,
                    :usuario_actualiza,
                    :clave
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':codigo' => $datos['codigo'],
            ':foto_operador' => $datos['foto_operador'] ?? null,
            ':nombre_completo' => $datos['nombre_completo'],
            ':fecha_nacimiento' => $datos['fecha_nacimiento'],
            ':rango_id' => $datos['rango_id'] ?? null,
            ':fecha_ultimo_ascenso' => $datos['fecha_ultimo_ascenso'] ?? null,
            ':pais' => $datos['pais'],
            ':telefono' => $datos['telefono'],
            ':rol' => $datos['rol'] ?? 'operador',
            ':estado' => $datos['estado'] ?? 'Activo',
            ':usuario_actualiza' => $datos['usuario_actualiza'] ?? null,
            ':clave' => $datos['clave'] ?? null
        ]);
    }

    public function actualizar($id, $datos)
    {
        if (!empty($datos['foto_operador'])) {
            $sql = "UPDATE operadores SET
                        foto_operador = :foto_operador,
                        nombre_completo = :nombre_completo,
                        fecha_nacimiento = :fecha_nacimiento,
                        rango_id = :rango_id,
                        fecha_ultimo_ascenso = :fecha_ultimo_ascenso,
                        pais = :pais,
                        telefono = :telefono,
                        rol = :rol,
                        estado = :estado,
                        usuario_actualiza = :usuario_actualiza
                    WHERE id = :id";
        } else {
            $sql = "UPDATE operadores SET
                        nombre_completo = :nombre_completo,
                        fecha_nacimiento = :fecha_nacimiento,
                        rango_id = :rango_id,
                        fecha_ultimo_ascenso = :fecha_ultimo_ascenso,
                        pais = :pais,
                        telefono = :telefono,
                        rol = :rol,
                        estado = :estado,
                        usuario_actualiza = :usuario_actualiza
                    WHERE id = :id";
        }

        $stmt = $this->db->prepare($sql);

        $params = [
            ':nombre_completo' => $datos['nombre_completo'],
            ':fecha_nacimiento' => $datos['fecha_nacimiento'],
            ':rango_id' => $datos['rango_id'] ?? null,
            ':fecha_ultimo_ascenso' => $datos['fecha_ultimo_ascenso'] ?? null,
            ':pais' => $datos['pais'],
            ':telefono' => $datos['telefono'],
            ':rol' => $datos['rol'],
            ':estado' => $datos['estado'],
            ':usuario_actualiza' => $datos['usuario_actualiza'] ?? null,
            ':id' => $id
        ];

        if (!empty($datos['foto_operador'])) {
            $params[':foto_operador'] = $datos['foto_operador'];
        }

        return $stmt->execute($params);
    }

    public function cambiarEstado($id, $estado, $usuario_actualiza)
    {
        $sql = "UPDATE operadores
                SET estado = :estado,
                    usuario_actualiza = :usuario_actualiza
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado' => $estado,
            ':usuario_actualiza' => $usuario_actualiza,
            ':id' => $id
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM operadores WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function contarTotal()
    {
        $sql = "SELECT COUNT(*) AS total FROM operadores";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function contarPorEstado()
    {
        $sql = "SELECT estado, COUNT(*) AS total
                FROM operadores
                GROUP BY estado";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorEstado($estado)
    {
        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    TIMESTAMPDIFF(YEAR, o.fecha_nacimiento, CURDATE()) AS edad,
                    (
                        SELECT e.nombre
                        FROM operador_especialidad oe
                        INNER JOIN especialidades e ON oe.especialidad_id = e.id
                        WHERE oe.operador_id = o.id
                          AND oe.principal = 1
                        LIMIT 1
                    ) AS especialidad_principal,
                    (
                        SELECT GROUP_CONCAT(DISTINCT u.nombre SEPARATOR ', ')
                        FROM operador_unidad ou
                        INNER JOIN unidades u ON ou.unidad_id = u.id
                        WHERE ou.operador_id = o.id
                    ) AS unidades,
                    (
                        SELECT GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ')
                        FROM operador_curso oc
                        INNER JOIN cursos c ON oc.curso_id = c.id
                        WHERE oc.operador_id = o.id
                    ) AS cursos
                FROM operadores o
                LEFT JOIN rangos r ON o.rango_id = r.id
                WHERE o.estado = :estado
                ORDER BY o.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':estado' => $estado
        ]);

        return $stmt->fetchAll();
    }

    public function obtenerPorCodigo($codigo)
    {
        $sql = "SELECT * FROM operadores WHERE codigo = :codigo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo
        ]);

        return $stmt->fetch();
    }

    public function obtenerUltimoCodigo()
    {
        $sql = "SELECT codigo
                FROM operadores
                WHERE codigo LIKE 'CMI%'
                ORDER BY id DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function generarCodigo()
    {
        $ultimo = $this->obtenerUltimoCodigo();

        if (!$ultimo || empty($ultimo['codigo'])) {
            return 'CMI0001';
        }

        $numero = (int) str_replace('CMI', '', $ultimo['codigo']);
        $numero++;

        return 'CMI' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    public function obtenerRangosActivos()
    {
        return $this->db->query("SELECT id, nombre FROM rangos WHERE estado = 'Activo' ORDER BY nombre ASC")->fetchAll();
    }

    public function obtenerEspecialidadesActivas()
    {
        return $this->db->query("SELECT id, nombre, sigla FROM especialidades WHERE estado = 'Activo' ORDER BY nombre ASC")->fetchAll();
    }

    public function obtenerUnidadesActivas()
    {
        return $this->db->query("SELECT id, nombre FROM unidades WHERE estado = 'Activo' ORDER BY nombre ASC")->fetchAll();
    }

    public function obtenerCursosActivos()
    {
        return $this->db->query("SELECT id, nombre FROM cursos WHERE estado = 'Activo' ORDER BY nombre ASC")->fetchAll();
    }

    public function obtenerEspecialidadesAsignadas($operadorId)
    {
        $sql = "SELECT especialidad_id
                FROM operador_especialidad
                WHERE operador_id = :operador_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':operador_id' => $operadorId
        ]);

        return array_column($stmt->fetchAll(), 'especialidad_id');
    }

    public function obtenerCursosAsignados($operadorId)
    {
        $sql = "SELECT curso_id
                FROM operador_curso
                WHERE operador_id = :operador_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':operador_id' => $operadorId
        ]);

        return array_column($stmt->fetchAll(), 'curso_id');
    }

    public function obtenerUnidadesAsignadas($operadorId)
    {
        $sql = "SELECT unidad_id
                FROM operador_unidad
                WHERE operador_id = :operador_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':operador_id' => $operadorId
        ]);

        return array_column($stmt->fetchAll(), 'unidad_id');
    }

    public function guardarEspecialidadesAsignadas($operadorId, $especialidades = [], $principalId = null)
    {
        $sqlDelete = "DELETE FROM operador_especialidad WHERE operador_id = :operador_id";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->execute([
            ':operador_id' => $operadorId
        ]);

        if (!empty($especialidades)) {
            $sqlInsert = "INSERT INTO operador_especialidad (operador_id, especialidad_id, principal)
                          VALUES (:operador_id, :especialidad_id, :principal)";
            $stmtInsert = $this->db->prepare($sqlInsert);

            foreach ($especialidades as $especialidadId) {
                $stmtInsert->execute([
                    ':operador_id' => $operadorId,
                    ':especialidad_id' => $especialidadId,
                    ':principal' => ((string) $principalId === (string) $especialidadId) ? 1 : 0
                ]);
            }
        }
    }

    public function guardarCursosAsignados($operadorId, $cursos = [])
    {
        $sqlDelete = "DELETE FROM operador_curso WHERE operador_id = :operador_id";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->execute([
            ':operador_id' => $operadorId
        ]);

        if (!empty($cursos)) {
            $sqlInsert = "INSERT INTO operador_curso (operador_id, curso_id)
                          VALUES (:operador_id, :curso_id)";
            $stmtInsert = $this->db->prepare($sqlInsert);

            foreach ($cursos as $cursoId) {
                $stmtInsert->execute([
                    ':operador_id' => $operadorId,
                    ':curso_id' => $cursoId
                ]);
            }
        }
    }

    public function guardarUnidadesAsignadas($operadorId, $unidades = [])
    {
        $sqlDelete = "DELETE FROM operador_unidad WHERE operador_id = :operador_id";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->execute([
            ':operador_id' => $operadorId
        ]);

        if (!empty($unidades)) {
            $sqlInsert = "INSERT INTO operador_unidad (operador_id, unidad_id)
                          VALUES (:operador_id, :unidad_id)";
            $stmtInsert = $this->db->prepare($sqlInsert);

            foreach ($unidades as $unidadId) {
                $stmtInsert->execute([
                    ':operador_id' => $operadorId,
                    ':unidad_id' => $unidadId
                ]);
            }
        }
    }

    public function obtenerEspecialidadPrincipal($operadorId)
    {
        $sql = "SELECT especialidad_id
                FROM operador_especialidad
                WHERE operador_id = :operador_id
                  AND principal = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':operador_id' => $operadorId
        ]);

        $fila = $stmt->fetch();
        return $fila ? $fila['especialidad_id'] : null;
    }


public function filtrar($filtros = [])
{
    $where = [];
    $params = [];

    // Buscar por nombre completo
    if (!empty($filtros['buscar'])) {
        $where[] = "o.nombre_completo LIKE :buscar";
        $params[':buscar'] = '%' . trim($filtros['buscar']) . '%';
    }

    // Filtrar por estado
    if (!empty($filtros['estado'])) {
        $where[] = "o.estado = :estado";
        $params[':estado'] = trim($filtros['estado']);
    }

    // Filtrar por rango
    if (!empty($filtros['rango'])) {
        $where[] = "o.rango_id = :rango";
        $params[':rango'] = (int) $filtros['rango'];
    }

    // Filtrar por especialidad principal
    if (!empty($filtros['especialidad'])) {
        $where[] = "EXISTS (
            SELECT 1
            FROM operador_especialidad oe
            WHERE oe.operador_id = o.id
              AND oe.principal = 1
              AND oe.especialidad_id = :especialidad
        )";
        $params[':especialidad'] = (int) $filtros['especialidad'];
    }

    $sql = "SELECT 
                o.*,
                r.nombre AS rango,
                TIMESTAMPDIFF(YEAR, o.fecha_nacimiento, CURDATE()) AS edad,
                (
                    SELECT e.nombre
                    FROM operador_especialidad oe
                    INNER JOIN especialidades e ON oe.especialidad_id = e.id
                    WHERE oe.operador_id = o.id
                      AND oe.principal = 1
                    LIMIT 1
                ) AS especialidad_principal,
                (
                    SELECT GROUP_CONCAT(DISTINCT u.nombre SEPARATOR ', ')
                    FROM operador_unidad ou
                    INNER JOIN unidades u ON ou.unidad_id = u.id
                    WHERE ou.operador_id = o.id
                ) AS unidades,
                (
                    SELECT GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ')
                    FROM operador_curso oc
                    INNER JOIN cursos c ON oc.curso_id = c.id
                    WHERE oc.operador_id = o.id
                ) AS cursos
            FROM operadores o
            LEFT JOIN rangos r ON o.rango_id = r.id";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $sql .= " ORDER BY o.id DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

    public function obtenerEstadosFiltro()
    {
        return [
            'Activo',
            'Reserva',
            'Suspendido',
            'Retirado'
        ];
    }
}