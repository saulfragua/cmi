<?php

class OperadoresController {

    public function index() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $contenido = ROOT . '/app/views/admin/operadores/index.php';

                require ROOT . '/app/views/admin/layouts/main.php';
    }


}