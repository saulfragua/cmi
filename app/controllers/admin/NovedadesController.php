<?php

class NovedadesController
{
    private $model;

    public function __construct()
    {
        $this->model = new Novedad();
    }

    private function validarSesion()
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
    }

    public function index()
    {
        $this->validarSesion();

        $usuario = $_SESSION['user'];
        $novedades = $this->model->obtenerTodas();

        $contenido = ROOT . '/app/views/admin/novedades/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function crear()
    {
        $this->validarSesion();

        $usuario = $_SESSION['user'];
        $operadores = $this->model->obtenerOperadoresActivosYReserva();

        $contenido = ROOT . '/app/views/admin/novedades/crear.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardar()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $tipo = trim($_POST['tipo'] ?? '');
        $nivel = trim($_POST['nivel'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');

        if ($tipo === 'Felicitación') {
            $nivel = null;
            $categoria = null;
        }

        $data = [
            'operador_id'    => $_POST['operador_id'] ?? null,
            'tipo'           => $tipo,
            'nivel'          => $nivel ?: null,
            'categoria'      => $categoria ?: null,
            'descripcion'    => trim($_POST['descripcion'] ?? ''),
            'observaciones'  => trim($_POST['observaciones'] ?? ''),
            'estado'         => $_POST['estado'] ?? 'Activo',
            'registrado_por' => $_SESSION['user']['id'] ?? null
        ];

        $this->model->crear($data);

        header('Location: ' . BASE_URL . '/novedades');
        exit;
    }

    public function editar()
    {
        $this->validarSesion();

        $usuario = $_SESSION['user'];
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $novedad = $this->model->obtenerPorId($id);
        $operadores = $this->model->obtenerOperadoresActivosYReserva();

        if (!$novedad) {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $contenido = ROOT . '/app/views/admin/novedades/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $tipo = trim($_POST['tipo'] ?? '');
        $nivel = trim($_POST['nivel'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');

        if ($tipo === 'Felicitación') {
            $nivel = null;
            $categoria = null;
        }

        $data = [
            'operador_id'   => $_POST['operador_id'] ?? null,
            'tipo'          => $tipo,
            'nivel'         => $nivel ?: null,
            'categoria'     => $categoria ?: null,
            'descripcion'   => trim($_POST['descripcion'] ?? ''),
            'observaciones' => trim($_POST['observaciones'] ?? ''),
            'estado'        => $_POST['estado'] ?? 'Activo'
        ];

        $this->model->actualizar($id, $data);

        header('Location: ' . BASE_URL . '/novedades');
        exit;
    }

    public function anular()
    {
        $this->validarSesion();

        $usuario = $_SESSION['user'];
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $novedad = $this->model->obtenerPorId($id);

        if (!$novedad) {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $contenido = ROOT . '/app/views/admin/novedades/anular.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardarAnulacion()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $motivo = trim($_POST['motivo_anulacion'] ?? '');

        if (!$id || $motivo === '') {
            header('Location: ' . BASE_URL . '/novedades');
            exit;
        }

        $this->model->anular($id, $motivo);

        header('Location: ' . BASE_URL . '/novedades');
        exit;
    }


}