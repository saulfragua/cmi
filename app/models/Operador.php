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

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    p.nombre AS pais_nombre,
                    p.bandera AS pais_bandera,
                    p.indicativo AS pais_indicativo,
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
                LEFT JOIN paises p ON p.nombre = o.pais
                ORDER BY o.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    p.nombre AS pais_nombre,
                    p.bandera AS pais_bandera,
                    p.indicativo AS pais_indicativo,
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
                LEFT JOIN paises p ON p.nombre = o.pais
                WHERE o.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos)
    {
        $sql = "INSERT INTO operadores (
                    codigo,
                    clave,
                    foto_operador,
                    nombre_completo,
                    alias,
                    fecha_nacimiento,
                    rango_id,
                    pais,
                    telefono,
                    discord,
                    steam,
                    rol,
                    fecha_ultimo_ascenso,
                    usuario_actualiza,
                    estado
                ) VALUES (
                    :codigo,
                    :clave,
                    :foto_operador,
                    :nombre_completo,
                    :alias,
                    :fecha_nacimiento,
                    :rango_id,
                    :pais,
                    :telefono,
                    :discord,
                    :steam,
                    :rol,
                    :fecha_ultimo_ascenso,
                    :usuario_actualiza,
                    :estado
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':codigo' => $datos['codigo'],
            ':clave' => $datos['clave'] ?? null,
            ':foto_operador' => $datos['foto_operador'] ?? null,
            ':nombre_completo' => $datos['nombre_completo'],
            ':alias' => $datos['alias'] ?? null,
            ':fecha_nacimiento' => $datos['fecha_nacimiento'],
            ':rango_id' => $datos['rango_id'] ?? null,
            ':pais' => $datos['pais'] ?? null,
            ':telefono' => $datos['telefono'] ?? null,
            ':discord' => $datos['discord'] ?? null,
            ':steam' => $datos['steam'] ?? null,
            ':rol' => $datos['rol'] ?? 'operador',
            ':fecha_ultimo_ascenso' => $datos['fecha_ultimo_ascenso'] ?? null,
            ':usuario_actualiza' => $datos['usuario_actualiza'] ?? null,
            ':estado' => $datos['estado'] ?? 'Activo'
        ]);
    }

    public function actualizar($id, $datos)
    {
        if (!empty($datos['foto_operador'])) {
            $sql = "UPDATE operadores SET
                        foto_operador = :foto_operador,
                        nombre_completo = :nombre_completo,
                        alias = :alias,
                        fecha_nacimiento = :fecha_nacimiento,
                        rango_id = :rango_id,
                        fecha_ultimo_ascenso = :fecha_ultimo_ascenso,
                        pais = :pais,
                        telefono = :telefono,
                        discord = :discord,
                        steam = :steam,
                        rol = :rol,
                        estado = :estado,
                        usuario_actualiza = :usuario_actualiza
                    WHERE id = :id";
        } else {
            $sql = "UPDATE operadores SET
                        nombre_completo = :nombre_completo,
                        alias = :alias,
                        fecha_nacimiento = :fecha_nacimiento,
                        rango_id = :rango_id,
                        fecha_ultimo_ascenso = :fecha_ultimo_ascenso,
                        pais = :pais,
                        telefono = :telefono,
                        discord = :discord,
                        steam = :steam,
                        rol = :rol,
                        estado = :estado,
                        usuario_actualiza = :usuario_actualiza
                    WHERE id = :id";
        }

        $stmt = $this->db->prepare($sql);

        $params = [
            ':nombre_completo'      => $datos['nombre_completo'] ?? null,
            ':alias'                => $datos['alias'] ?? null,
            ':fecha_nacimiento'     => $datos['fecha_nacimiento'] ?? null,
            ':rango_id'             => $datos['rango_id'] ?? null,
            ':fecha_ultimo_ascenso' => $datos['fecha_ultimo_ascenso'] ?? null,
            ':pais'                 => $datos['pais'] ?? null,
            ':telefono'             => $datos['telefono'] ?? null,
            ':discord'              => $datos['discord'] ?? null,
            ':steam'                => $datos['steam'] ?? null,
            ':rol'                  => $datos['rol'] ?? 'operador',
            ':estado'               => $datos['estado'] ?? 'Activo',
            ':usuario_actualiza'    => $datos['usuario_actualiza'] ?? null,
            ':id'                   => $id
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

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarPorEstado()
    {
        $sql = "SELECT estado, COUNT(*) AS total
                FROM operadores
                GROUP BY estado";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorEstado($estado)
    {
        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    p.nombre AS pais_nombre,
                    p.bandera AS pais_bandera,
                    p.indicativo AS pais_indicativo,
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
                LEFT JOIN paises p ON p.nombre = o.pais
                WHERE o.estado = :estado
                ORDER BY o.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':estado' => $estado
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCodigo($codigo)
    {
        $sql = "SELECT * FROM operadores WHERE codigo = :codigo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerRangosActivos()
    {
        $sql = "SELECT id, nombre
                FROM rangos
                WHERE estado = 'Activo'
                ORDER BY nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEspecialidadesActivas()
    {
        $sql = "SELECT id, nombre
                FROM especialidades
                WHERE estado = 'Activo'
                ORDER BY nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUnidadesActivas()
    {
        $sql = "SELECT id, nombre
                FROM unidades
                WHERE estado = 'Activo'
                ORDER BY nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCursosActivos()
    {
        $sql = "SELECT id, nombre
                FROM cursos
                WHERE estado = 'Activo'
                ORDER BY nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'especialidad_id');
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

        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'unidad_id');
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

        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'curso_id');
    }

    public function guardarEspecialidadesAsignadas($operadorId, $especialidades, $especialidadPrincipal = null)
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
                    ':principal' => ((int)$especialidadPrincipal === (int)$especialidadId) ? 1 : 0
                ]);
            }
        }
    }

    public function guardarUnidadesAsignadas($operadorId, $unidades)
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

    public function guardarCursosAsignados($operadorId, $cursos)
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

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? $fila['especialidad_id'] : null;
    }

    public function filtrar($filtros = [])
    {
        $where = [];
        $params = [];

        if (!empty($filtros['buscar'])) {
            $where[] = "o.nombre_completo LIKE :buscar";
            $params[':buscar'] = '%' . trim($filtros['buscar']) . '%';
        }

        if (!empty($filtros['estado'])) {
            $where[] = "o.estado = :estado";
            $params[':estado'] = trim($filtros['estado']);
        }

        if (!empty($filtros['rango'])) {
            $where[] = "o.rango_id = :rango";
            $params[':rango'] = (int)$filtros['rango'];
        }

        if (!empty($filtros['especialidad'])) {
            $where[] = "EXISTS (
                SELECT 1
                FROM operador_especialidad oe
                WHERE oe.operador_id = o.id
                  AND oe.principal = 1
                  AND oe.especialidad_id = :especialidad
            )";
            $params[':especialidad'] = (int)$filtros['especialidad'];
        }

        $sql = "SELECT 
                    o.*,
                    r.nombre AS rango,
                    p.nombre AS pais_nombre,
                    p.bandera AS pais_bandera,
                    p.indicativo AS pais_indicativo,
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
                LEFT JOIN paises p ON p.nombre = o.pais";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $sql .= " ORDER BY o.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function actualizarFoto($id, $foto)
    {
        $sql = "UPDATE operadores
                SET foto_operador = :foto,
                    fecha_modificacion = CURRENT_TIMESTAMP
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':foto' => $foto,
            ':id'   => $id
        ]);
    }

    public function actualizarPerfilOperador($id, $datos)
    {
        $sql = "UPDATE operadores
                SET nombre_completo = :nombre_completo,
                    alias = :alias,
                    fecha_nacimiento = :fecha_nacimiento,
                    telefono = :telefono,
                    pais = :pais,
                    discord = :discord,
                    steam = :steam,
                    fecha_modificacion = CURRENT_TIMESTAMP
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre_completo'  => $datos['nombre_completo'],
            ':alias'            => $datos['alias'] ?? null,
            ':fecha_nacimiento' => $datos['fecha_nacimiento'],
            ':telefono'         => $datos['telefono'],
            ':pais'             => $datos['pais'],
            ':discord'          => $datos['discord'] ?? null,
            ':steam'            => $datos['steam'] ?? null,
            ':id'               => $id
        ]);
    }

    public function obtenerHistorialActividades($operadorId)
    {
        $sql = "SELECT 
                    a.id,
                    a.nombre,
                    a.tipo,
                    a.fecha,
                    a.hora_inicio,
                    a.estado AS estado_actividad,
                    ao.estado AS estado_participacion,
                    ao.fecha_respuesta,
                    ao.observacion
                FROM actividad_operador ao
                INNER JOIN actividades a ON a.id = ao.actividad_id
                WHERE ao.operador_id = :operador_id
                  AND ao.estado = 'Asiste'
                ORDER BY a.fecha DESC, a.hora_inicio DESC
                LIMIT 5";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':operador_id' => $operadorId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNovedadesPorOperador($operadorId)
    {
        $sql = "SELECT 
                    n.id,
                    n.tipo,
                    n.descripcion,
                    n.motivo_anulacion,
                    n.estado,
                    n.fecha_registro,
                    u.nombre_completo AS registrado_por_nombre
                FROM novedades n
                LEFT JOIN operadores u ON n.registrado_por = u.id
                WHERE n.operador_id = :operador_id
                ORDER BY n.fecha_registro DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':operador_id' => $operadorId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarClave($id, $clave)
    {
        $sql = "UPDATE operadores SET clave = :clave WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':clave' => $clave,
            ':id' => $id
        ]);
    }

    public function obtenerPaisesActivos()
{
    $sql = "SELECT id, nombre, iso2, bandera, indicativo
            FROM paises
            WHERE estado = 'Activo'
            ORDER BY nombre ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerPorIdCarnet($id)
{
    $sql = "SELECT 
    o.*,
    r.nombre AS rango_nombre,
    e.nombre AS especialidad_nombre,
    u.nombre AS unidad_nombre
FROM operadores o
LEFT JOIN rangos r ON r.id = o.rango_id
LEFT JOIN operador_especialidad oe ON oe.operador_id = o.id AND oe.principal = 1
LEFT JOIN especialidades e ON e.id = oe.especialidad_id
LEFT JOIN operador_unidad ou ON ou.operador_id = o.id
LEFT JOIN unidades u ON u.id = ou.unidad_id
WHERE o.id = :id
LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}