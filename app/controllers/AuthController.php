<?php

class AuthController
{
    // Mostrar login
    public function login()
    {
        require ROOT . '/app/views/auth/login.php';
    }

    // Procesar login
    public function autenticar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $codigo = trim($_POST['codigo'] ?? '');
        $clave  = trim($_POST['clave'] ?? '');
        $tipo   = trim($_POST['tipo'] ?? ''); // admin | mando | operador

        // Validación básica
        if (empty($codigo) || empty($clave) || empty($tipo)) {
            header('Location: ' . BASE_URL . '/login?error=campos');
            exit;
        }

        require_once ROOT . '/app/models/AuthModel.php';
        $modelo = new AuthModel();

        // Buscar usuario por código
        $usuario = $modelo->obtenerPorCodigo($codigo);

        if (!$usuario) {
            header('Location: ' . BASE_URL . '/login?error=credenciales');
            exit;
        }

        // Validar estado
        if (!in_array($usuario['estado'], ['Activo', 'Reserva'])) {
            header('Location: ' . BASE_URL . '/login?error=estado');
            exit;
        }

        // Validar contraseña
        $claveValida = false;

        if (!empty($usuario['clave']) && password_verify($clave, $usuario['clave'])) {
            $claveValida = true;
        }

        if (!$claveValida && $clave === $usuario['clave']) {
            $claveValida = true;
        }

        if (!$claveValida) {
            header('Location: ' . BASE_URL . '/login?error=credenciales');
            exit;
        }

        $rolUsuario = $usuario['rol'];

        // =========================
        // PANEL ADMIN / MANDO
        // =========================
        if ($tipo === 'admin' || $tipo === 'mando') {
            if (!in_array($rolUsuario, ['admin', 'mando'])) {
                header('Location: ' . BASE_URL . '/login?error=permiso');
                exit;
            }

            $_SESSION['user'] = [
                'id'            => $usuario['id'],
                'codigo'        => $usuario['codigo'],
                'tipo'          => $rolUsuario,
                'nombre'        => $usuario['nombre_completo'],
                'rol'           => $usuario['rol'],
                'panel'         => 'admin',
                'foto_operador' => $usuario['foto_operador'] ?? '',
                'rango_id'      => $usuario['rango_id'] ?? null,
                'estado'        => $usuario['estado'],
                'steam'         => $usuario['steam'] ?? ''
            ];

            header('Location: ' . BASE_URL . '/admin');
            exit;
        }

        // =========================
        // PANEL OPERADOR
        // =========================
        if ($tipo === 'operador') {
            if (!in_array($rolUsuario, ['operador', 'mando'])) {
                header('Location: ' . BASE_URL . '/login?error=permiso');
                exit;
            }

            $_SESSION['user'] = [
                'id'            => $usuario['id'],
                'codigo'        => $usuario['codigo'],
                'tipo'          => $rolUsuario,
                'nombre'        => $usuario['nombre_completo'],
                'rol'           => $usuario['rol'],
                'panel'         => 'operador',
                'foto_operador' => $usuario['foto_operador'] ?? '',
                'rango_id'      => $usuario['rango_id'] ?? null,
                'estado'        => $usuario['estado'],
                'steam'         => $usuario['steam'] ?? ''
            ];

            // Si es mando y no tiene steam registrado, obligarlo a registrar
            if ($rolUsuario === 'mando' && empty(trim($usuario['steam'] ?? ''))) {
                header('Location: ' . BASE_URL . '/operador/registrar-steam');
                exit;
            }

            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        header('Location: ' . BASE_URL . '/login?error=tipo');
        exit;
    }

    // Logout
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
}