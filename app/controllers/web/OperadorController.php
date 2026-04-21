<?php

class OperadorController
{
    private $model;

    public function __construct()
    {
        $this->model = new Operador();
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

        // Solo permite operador o mando en panel operador
        if (!in_array($_SESSION['user']['rol'], ['operador', 'mando'])) {
            header('Location: ' . BASE_URL . '/login?error=permiso');
            exit;
        }

        $id = $_SESSION['user']['id'];

        $operador = $this->model->obtenerPorId($id);
        $historial = $this->model->obtenerHistorialActividades($id); // ya limitado a 5 asistidas

        require ROOT . '/app/views/web/operador/index.php';
    }

    public function actualizarPerfil()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        $id = $_SESSION['user']['id'];

        $datos = [
            'nombre_completo'   => trim($_POST['nombre_completo'] ?? ''),
            'fecha_nacimiento'  => trim($_POST['fecha_nacimiento'] ?? ''),
            'telefono'          => trim($_POST['telefono'] ?? ''),
            'pais'              => trim($_POST['pais'] ?? '')
        ];

        // Validación básica
        if (
            empty($datos['nombre_completo']) ||
            empty($datos['fecha_nacimiento']) ||
            empty($datos['telefono']) ||
            empty($datos['pais'])
        ) {
            $_SESSION['error_operador'] = 'Todos los campos editables son obligatorios.';
            header('Location: ' . BASE_URL . '/operador');
            exit;
        }

        $ok = $this->model->actualizarPerfilOperador($id, $datos);

        if ($ok) {
            $_SESSION['user']['nombre_completo'] = $datos['nombre_completo'];
            $_SESSION['success_operador'] = 'Perfil actualizado correctamente.';
        } else {
            $_SESSION['error_operador'] = 'No se pudo actualizar el perfil.';
        }

        header('Location: ' . BASE_URL . '/operador');
        exit;
    }

    public function actualizarFoto()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if (!empty($_FILES['foto']['name'])) {
            $directorio = ROOT . '/public/assets/img/operadores/';

            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreArchivo = time() . '_' . preg_replace('/\s+/', '_', $_FILES['foto']['name']);
            $rutaDestino = $directorio . $nombreArchivo;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                $this->model->actualizarFoto($_SESSION['user']['id'], $nombreArchivo);
                $_SESSION['user']['foto_operador'] = $nombreArchivo;
            }
        }

        header('Location: ' . BASE_URL . '/operador');
        exit;
    }
    public function misObservador()
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

        $id = $_SESSION['user']['id'];

        $operador = $this->model->obtenerPorId($id);
        $novedades = $this->model->obtenerNovedadesPorOperador($id);

        require ROOT . '/app/views/web/operador/mis_observador.php';
    }

    public function cambiarClave()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $operadorId = $_SESSION['user']['id'];
    $nueva = $_POST['nueva_clave'];
    $confirmar = $_POST['confirmar_clave'];

    if ($nueva !== $confirmar) {
        header('Location: ' . BASE_URL . '/operador?error=clave_no_coincide');
        exit;
    }

    // Encriptar clave
    $claveHash = password_hash($nueva, PASSWORD_BCRYPT);

    $this->model->actualizarClave($operadorId, $claveHash);

    header('Location: ' . BASE_URL . '/operador?success=clave_actualizada');
}

public function registrarSteam()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    require_once ROOT . '/app/models/AuthModel.php';
    $modelo = new AuthModel();

    $id = $_SESSION['user']['id'];

    // 🔥 CONSULTA REAL A BD
    $usuario = $modelo->obtenerPorId($id);

    // ✅ Si ya tiene steam → NO mostrar formulario
    if (!empty(trim($usuario['steam'] ?? ''))) {
        header('Location: ' . BASE_URL . '/operador');
        exit;
    }

    require ROOT . '/app/views/web/operador/registrar_steam.php';
}

public function guardarSteam()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $steam = trim($_POST['steam'] ?? '');
    $id = $_SESSION['user']['id'] ?? null;

    if (empty($id) || empty($steam)) {
        header('Location: ' . BASE_URL . '/operador/registrar-steam?error=vacío');
        exit;
    }

    require_once ROOT . '/app/models/AuthModel.php';
    $modelo = new AuthModel();

    $guardado = $modelo->actualizarSteam($id, $steam);

    if ($guardado) {
        $_SESSION['user']['steam'] = $steam;

        // lo envías al perfil o al panel
        header('Location: ' . BASE_URL . '/operador');
        exit;
    }

    header('Location: ' . BASE_URL . '/operador/registrar-steam?error=guardar');
    exit;
}
}