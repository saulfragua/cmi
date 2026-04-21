<?php

require_once ROOT . '/app/models/Dashboard.php';

class DashboardController
{
    private $model;

    public function __construct()
    {
        $this->model = new Dashboard();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if ($_SESSION['user']['tipo'] !== 'admin' && $_SESSION['user']['tipo'] !== 'mando') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $usuario = $_SESSION['user'];

        $totalOperadores = $this->model->obtenerTotalOperadores();
        $operadoresPorEstado = $this->model->obtenerOperadoresPorEstado();
        $operadoresPorRol = $this->model->obtenerOperadoresPorRol();
        $operadoresPorRango = $this->model->obtenerOperadoresPorRango();

        $totalFormularios = $this->model->obtenerTotalFormularios();
        $formulariosPorEstado = $this->model->obtenerFormulariosPorEstado();

        $contenido = ROOT . '/app/views/admin/dashboard/index.php';

        require ROOT . '/app/views/admin/layouts/main.php';
    }
}