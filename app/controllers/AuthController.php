<?php

class AuthController {

    // Mostrar login
    public function login() {
        require ROOT . '/app/views/auth/login.php';
    }

    // Procesar login
    public function autenticar() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $codigo = $_POST['codigo'] ?? '';
        $clave  = $_POST['clave'] ?? '';
        $tipo   = $_POST['tipo'] ?? '';

        // Validación básica
        if (empty($codigo) || empty($clave) || empty($tipo)) {
            header('Location: ' . BASE_URL . '/login?error=campos');
            exit;
        }

        // 🔥 CONEXIÓN AL MODELO
        require_once ROOT . '/app/models/AuthModel.php';
        $modelo = new AuthModel();

        $usuario = $modelo->login($codigo, $clave, $tipo);

        if ($usuario) {

            // Guardar sesión
            $_SESSION['user'] = [
                'id' => $usuario['id'],
                'codigo' => $usuario['codigo'],
                'tipo' => $usuario['tipo'],
                'nombre' => $usuario['nombre']
            ];

            // 🔁 Redirección por rol
            switch ($usuario['tipo']) {
                case 'admin':
                    header('Location: ' . BASE_URL . '/admin');
                    break;

                case 'mando':
                    header('Location: ' . BASE_URL . '/mando');
                    break;

                case 'operador':
                    header('Location: ' . BASE_URL . '/operador');
                    break;

                default:
                    header('Location: ' . BASE_URL . '/login');
                    break;
            }

            exit;

        } else {
            header('Location: ' . BASE_URL . '/login?error=credenciales');
            exit;
        }
    }

    // Cerrar sesión
    public function logout() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}