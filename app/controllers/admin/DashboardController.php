<?php

/**
 * ============================================
 * CONTROLADOR DEL DASHBOARD
 * ============================================
 */

class DashboardController {

    public function index() {

        // Protección de sesión
        if (!isset($_SESSION['user'])) {
            header('Location: /cmi/public/login');
            exit;
        }

        require ROOT . '/app/views/admin/dashboard.php';
    }
}