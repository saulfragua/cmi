<?php

require_once ROOT . '/app/models/Actividad.php';

class OperadorActividadesController
{
    private $actividadModel;

    public function __construct()
    {
        $this->actividadModel = new Actividad();
    }

    private function validarSesionOperador()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if (!in_array($_SESSION['user']['rol'], ['operador', 'mando'])) {
            header('Location: ' . BASE_URL . '/login?error=permiso');
            exit;
        }
    }

    public function calendario()
    {
        $this->validarSesionOperador();

        $mesActual  = date('n');
        $anioActual = date('Y');

        $mes = isset($_GET['mes']) ? (int) $_GET['mes'] : $mesActual;
        $anio = isset($_GET['anio']) ? (int) $_GET['anio'] : $anioActual;

        if ($mes < 1 || $mes > 12) {
            $mes = $mesActual;
        }

        if ($anio < 2026) {
            $anio = 2026;
        }

        $actividades = $this->actividadModel->obtenerPorMesAnio($mes, $anio);

        require ROOT . '/app/views/web/operador/calendario.php';
    }

public function ver()
{
    $this->validarSesionOperador();

    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if ($id <= 0) {
        header('Location: ' . BASE_URL . '/operador/calendario');
        exit;
    }

    $actividad = $this->actividadModel->obtenerPorId($id);

    if (!$actividad) {
        header('Location: ' . BASE_URL . '/operador/calendario');
        exit;
    }

    $participantes = $this->actividadModel->obtenerParticipacionPorActividad($id);

    $operadorSesionId = (int) ($_SESSION['user']['id'] ?? 0);
    $miParticipacion = null;

    foreach ($participantes as $p) {
        if ((int) ($p['operador_id'] ?? 0) === $operadorSesionId) {
            $miParticipacion = $p;
            break;
        }
    }

    require ROOT . '/app/views/web/operador/ver.php';
}

    public function responderParticipacion()
{
    $this->validarSesionOperador();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '/operador/calendario');
        exit;
    }

    $actividad_id = (int) ($_POST['actividad_id'] ?? 0);
    $estado       = trim($_POST['estado'] ?? 'Pendiente');
    $observacion  = trim($_POST['observacion'] ?? '');

    if ($actividad_id <= 0) {
        header('Location: ' . BASE_URL . '/operador/calendario');
        exit;
    }

    $actividad = $this->actividadModel->obtenerPorId($actividad_id);

    if (!$actividad) {
        header('Location: ' . BASE_URL . '/operador/calendario');
        exit;
    }

    // Si la actividad ya terminó o fue cancelada, no permitir responder
    if (in_array($actividad['estado'], ['Finalizada', 'Cancelada'])) {
        header('Location: ' . BASE_URL . '/operador/ver?id=' . $actividad_id);
        exit;
    }

    // Validar estados permitidos
    $estadosValidos = ['Pendiente', 'Asiste', 'No asiste'];
    if (!in_array($estado, $estadosValidos)) {
        $estado = 'Pendiente';
    }

    // Tomar el operador logueado desde sesión
    $operador_id = (int) ($_SESSION['user']['id'] ?? 0);

    if ($operador_id <= 0) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $this->actividadModel->actualizarEstadoParticipacion(
        $actividad_id,
        $operador_id,
        $estado,
        $observacion !== '' ? $observacion : null
    );

    header('Location: ' . BASE_URL . '/operador/ver?id=' . $actividad_id);
    exit;
}
}