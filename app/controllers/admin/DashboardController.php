<?php

class DashboardController {

    public function index() {

        // Iniciar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar sesión
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Verificar rol (admin o mando)
        if ($_SESSION['user']['tipo'] !== 'admin' && $_SESSION['user']['tipo'] !== 'mando') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Datos para la vista
        $usuario = $_SESSION['user'];

        // 👇 DEFINIR CONTENIDO DINÁMICO
        $contenido = ROOT . '/app/views/admin/dashboard/index.php';

        // 👇 CARGAR LAYOUT PRINCIPAL
        require ROOT . '/app/views/admin/layouts/main.php';
    }
}