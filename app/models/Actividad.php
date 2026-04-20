<?php

class Actividad
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodas()
    {
        $sql = "SELECT 
                    a.*,
                    o.nombre_completo AS operador_nombre,
                    a.registrado_por AS usuario_registra,
                    (
                        SELECT COUNT(*)
                        FROM actividad_operador ao
                        WHERE ao.actividad_id = a.id
                    ) AS total_operadores,
                    (
                        SELECT COUNT(*)
                        FROM actividad_operador ao
                        WHERE ao.actividad_id = a.id
                          AND ao.estado = 'Asiste'
                    ) AS total_asisten,
                    (
                        SELECT COUNT(*)
                        FROM actividad_operador ao
                        WHERE ao.actividad_id = a.id
                          AND ao.estado = 'No asiste'
                    ) AS total_no_asisten,
                    (
                        SELECT COUNT(*)
                        FROM actividad_operador ao
                        WHERE ao.actividad_id = a.id
                          AND ao.estado = 'Pendiente'
                    ) AS total_pendientes
                FROM actividades a
                INNER JOIN operadores o ON a.operador_id = o.id
                ORDER BY a.fecha DESC, a.hora_inicio DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                    a.*,
                    o.nombre_completo AS operador_nombre,
                    a.registrado_por AS usuario_registra
                FROM actividades a
                INNER JOIN operadores o ON a.operador_id = o.id
                WHERE a.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

public function crear($data)
{
    $sql = "INSERT INTO actividades (
                nombre,
                descripcion,
                imagen,
                tipo,
                fecha,
                hora_inicio,
                operador_id,
                registrado_por,
                estado
            ) VALUES (
                :nombre,
                :descripcion,
                :imagen,
                :tipo,
                :fecha,
                :hora_inicio,
                :operador_id,
                :registrado_por,
                :estado
            )";

    $stmt = $this->db->prepare($sql);
    $ok = $stmt->execute([
        ':nombre'         => $data['nombre'],
        ':descripcion'    => $data['descripcion'] ?? null,
        ':imagen'         => $data['imagen'] ?? null,
        ':tipo'           => $data['tipo'],
        ':fecha'          => $data['fecha'],
        ':hora_inicio'    => $data['hora_inicio'],
        ':operador_id'    => $data['operador_id'],
        ':registrado_por' => null, // 👈 forzar null mientras no exista tabla usuarios
        ':estado'         => $data['estado'] ?? 'Borrador'
    ]);

    if (!$ok) {
        return false;
    }

    return $this->db->lastInsertId();
}

    public function actualizar($id, $data)
    {
        $sql = "UPDATE actividades SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    imagen = :imagen,
                    tipo = :tipo,
                    fecha = :fecha,
                    hora_inicio = :hora_inicio,
                    operador_id = :operador_id,
                    estado = :estado
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':imagen'      => $data['imagen'] ?? null,
            ':tipo'        => $data['tipo'],
            ':fecha'       => $data['fecha'],
            ':hora_inicio' => $data['hora_inicio'],
            ':operador_id' => $data['operador_id'],
            ':estado'      => $data['estado'],
            ':id'          => $id
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM actividades WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerOperadoresActivosReserva()
    {
        $sql = "SELECT 
                    id,
                    codigo,
                    nombre_completo,
                    telefono,
                    estado
                FROM operadores
                WHERE estado IN ('Activo', 'Reserva')
                ORDER BY nombre_completo ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function obtenerParticipacionPorActividad($actividad_id)
    {
        $sql = "SELECT 
                    ao.id AS actividad_operador_id,
                    ao.actividad_id,
                    ao.operador_id,
                    ao.estado AS estado_participacion,
                    ao.fecha_respuesta,
                    ao.observacion,
                    o.codigo,
                    o.nombre_completo,
                    o.telefono,
                    o.estado AS estado_operador
                FROM actividad_operador ao
                INNER JOIN operadores o ON ao.operador_id = o.id
                WHERE ao.actividad_id = :actividad_id
                  AND o.estado IN ('Activo', 'Reserva')
                ORDER BY o.nombre_completo ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':actividad_id' => $actividad_id]);
        return $stmt->fetchAll();
    }

    public function crearParticipacionInicial($actividad_id)
    {
        $sql = "INSERT INTO actividad_operador (actividad_id, operador_id, estado)
                SELECT :actividad_id, o.id, 'Pendiente'
                FROM operadores o
                WHERE o.estado IN ('Activo', 'Reserva')
                  AND NOT EXISTS (
                        SELECT 1
                        FROM actividad_operador ao
                        WHERE ao.actividad_id = :actividad_id_2
                          AND ao.operador_id = o.id
                  )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':actividad_id'   => $actividad_id,
            ':actividad_id_2' => $actividad_id
        ]);
    }

    public function actualizarEstadoParticipacion($actividad_id, $operador_id, $estado, $observacion = null)
    {
        $sql = "UPDATE actividad_operador SET
                    estado = :estado,
                    fecha_respuesta = NOW(),
                    observacion = :observacion
                WHERE actividad_id = :actividad_id
                  AND operador_id = :operador_id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado'       => $estado,
            ':observacion'  => $observacion,
            ':actividad_id' => $actividad_id,
            ':operador_id'  => $operador_id
        ]);
    }

public function guardarResumenHistorico($actividad_id)
{
    $sql = "UPDATE actividades a
            SET 
                total_convocados = (
                    SELECT COUNT(*)
                    FROM actividad_operador ao
                    WHERE ao.actividad_id = a.id
                ),
                total_asistieron = (
                    SELECT COUNT(*)
                    FROM actividad_operador ao
                    WHERE ao.actividad_id = a.id
                      AND ao.estado = 'Asiste'
                ),
                total_no_asistieron = (
                    SELECT COUNT(*)
                    FROM actividad_operador ao
                    WHERE ao.actividad_id = a.id
                      AND ao.estado = 'No asiste'
                ),
                total_pendientes_cierre = (
                    SELECT COUNT(*)
                    FROM actividad_operador ao
                    WHERE ao.actividad_id = a.id
                      AND ao.estado = 'Pendiente'
                ),
                fecha_cierre = NOW()
            WHERE a.id = :actividad_id";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':actividad_id' => $actividad_id
    ]);
}

public function guardarParticipantesHistoricos($actividad_id)
{
    $sqlVerificar = "SELECT COUNT(*) AS total
                     FROM actividad_operador_historico
                     WHERE actividad_id = :actividad_id";

    $stmtVerificar = $this->db->prepare($sqlVerificar);
    $stmtVerificar->execute([':actividad_id' => $actividad_id]);
    $existe = $stmtVerificar->fetch();

    if (($existe['total'] ?? 0) > 0) {
        return true;
    }

    $sql = "INSERT INTO actividad_operador_historico (
                actividad_id,
                operador_id,
                codigo_operador,
                nombre_completo,
                telefono,
                estado_operador,
                estado_participacion,
                observacion,
                fecha_respuesta,
                fecha_cierre_historico
            )
            SELECT
                ao.actividad_id,
                ao.operador_id,
                o.codigo,
                o.nombre_completo,
                o.telefono,
                o.estado,
                ao.estado,
                ao.observacion,
                ao.fecha_respuesta,
                NOW()
            FROM actividad_operador ao
            INNER JOIN operadores o ON ao.operador_id = o.id
            WHERE ao.actividad_id = :actividad_id";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':actividad_id' => $actividad_id
    ]);
}

public function obtenerParticipacionHistorica($actividad_id)
{
    $sql = "SELECT *
            FROM actividad_operador_historico
            WHERE actividad_id = :actividad_id
            ORDER BY nombre_completo ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':actividad_id' => $actividad_id
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerPorMesAnio($mes, $anio)
{
    $sql = "SELECT 
                a.*,
                o.nombre_completo AS operador_nombre,
                a.registrado_por AS usuario_registra,
                (
                    SELECT COUNT(*) 
                    FROM actividad_operador ao 
                    WHERE ao.actividad_id = a.id
                ) AS total_operadores,
                (
                    SELECT COUNT(*) 
                    FROM actividad_operador ao 
                    WHERE ao.actividad_id = a.id 
                      AND ao.estado = 'Asiste'
                ) AS total_asisten,
                (
                    SELECT COUNT(*) 
                    FROM actividad_operador ao 
                    WHERE ao.actividad_id = a.id 
                      AND ao.estado = 'No asiste'
                ) AS total_no_asisten,
                (
                    SELECT COUNT(*) 
                    FROM actividad_operador ao 
                    WHERE ao.actividad_id = a.id 
                      AND ao.estado = 'Pendiente'
                ) AS total_pendientes
            FROM actividades a
            LEFT JOIN operadores o ON a.operador_id = o.id
            WHERE MONTH(a.fecha) = :mes
              AND YEAR(a.fecha) = :anio
            ORDER BY a.fecha ASC, a.hora_inicio ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':mes', (int)$mes, PDO::PARAM_INT);
    $stmt->bindValue(':anio', (int)$anio, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function cambiarEstadoParticipacion()
{
    $this->validarSesion();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '/actividades');
        exit;
    }

    $actividad_id = (int) ($_POST['actividad_id'] ?? 0);
    $operador_id  = (int) ($_POST['operador_id'] ?? 0);
    $estado       = trim($_POST['estado'] ?? 'Pendiente');
    $observacion  = trim($_POST['observacion'] ?? '');

    $actividad = $this->actividadModel->obtenerPorId($actividad_id);

    if (!$actividad) {
        header('Location: ' . BASE_URL . '/actividades');
        exit;
    }

    if ($actividad['estado'] === 'Finalizada') {
        header('Location: ' . BASE_URL . '/actividades/ver?id=' . $actividad_id);
        exit;
    }

    if ($actividad_id > 0 && $operador_id > 0) {
        $this->actividadModel->actualizarEstadoParticipacion(
            $actividad_id,
            $operador_id,
            $estado,
            $observacion !== '' ? $observacion : null
        );
    }

    header('Location: ' . BASE_URL . '/actividades/ver?id=' . $actividad_id);
    exit;
}
}