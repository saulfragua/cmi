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

        require ROOT . '/app/views/web/operador/ver.php';
    }
}