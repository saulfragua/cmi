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

        // ✅ CORREGIDO
        $codigo = $_POST['codigo'] ?? '';
        $clave  = $_POST['clave'] ?? '';
        $tipo   = $_POST['tipo'] ?? '';

        // Validación
        if (empty($codigo) || empty($clave) || empty($tipo)) {
            header('Location: ' . BASE_URL . '/login?error=campos');
            exit;
        }

        // ================= USUARIOS DEMO =================
        $usuariosDemo = [
            [
                'codigo' => 'admin',
                'clave' => '123456',
                'tipo' => 'admin',
                'nombre' => 'Administrador'
            ],
            [
                'codigo' => 'mando',
                'clave' => '123456',
                'tipo' => 'mando',
                'nombre' => 'Mando'
            ],
            [
                'codigo' => 'operador',
                'clave' => '123456',
                'tipo' => 'operador',
                'nombre' => 'Operador'
            ]
        ];

        $usuario = null;

        // 🔍 Buscar usuario demo correctamente
        foreach ($usuariosDemo as $u) {
            if ($u['codigo'] === $codigo && $u['clave'] === $clave && $u['tipo'] === $tipo) {
                $usuario = $u;
                break;
            }
        }

        // ================= LOGIN DEMO =================
        if ($usuario) {

            $_SESSION['user'] = [
                'id' => 0,
                'codigo' => $usuario['codigo'],
                'tipo' => $usuario['tipo'],
                'nombre' => $usuario['nombre']
            ];

        } else {

            // 🔥 LOGIN REAL (BD)
            require_once ROOT . '/app/models/AuthModel.php';
            $modelo = new AuthModel();

            $usuario = $modelo->login($codigo, $clave, $tipo);

            if (!$usuario) {
                header('Location: ' . BASE_URL . '/login?error=credenciales');
                exit;
            }

            $_SESSION['user'] = [
                'id' => $usuario['id'],
                'codigo' => $usuario['codigo'],
                'tipo' => $usuario['tipo'],
                'nombre' => $usuario['nombre']
            ];
        }

        // ================= REDIRECCIÓN =================
        switch ($_SESSION['user']['tipo']) {

            case 'admin':
            case 'mando':
                header('Location: ' . BASE_URL . '/admin');
                break;

            case 'operador':
                header('Location: ' . BASE_URL . '/operador');
                break;

            default:
                header('Location: ' . BASE_URL . '/login');
                break;
        }

        exit;
    }

    // Logout
    public function logout() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: ' . BASE_URL . '');
        exit;
    }
}