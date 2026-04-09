<?php

class OperadorController {

    public function index() {

        // Iniciar sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar sesión
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Verificar rol operador
        if ($_SESSION['user']['tipo'] !== 'operador') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Datos opcionales
        $usuario = $_SESSION['user'];

        // Cargar vista operador
        require ROOT . '/app/views/operador/index.php';
    }
}