<?php

class ActividadesController
{
    private $actividadModel;

    public function __construct()
    {
        $this->actividadModel = new Actividad();
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
        $actividades = $this->actividadModel->obtenerTodas();

        $contenido = ROOT . '/app/views/admin/actividades/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function crear()
    {
        $this->validarSesion();

        $usuario = $_SESSION['user'];
        $operadores = $this->actividadModel->obtenerOperadoresActivosReserva();

        $contenido = ROOT . '/app/views/admin/actividades/crear.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardar()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $imagen = null;

        if (!empty($_FILES['imagen']['name'])) {
            $directorio = ROOT . '/public/uploads/actividades/';

            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreArchivo = time() . '_' . preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $_FILES['imagen']['name']);
            $rutaFisica = $directorio . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFisica)) {
                $imagen = 'uploads/actividades/' . $nombreArchivo;
            }
        }

        $data = [
            'nombre'         => trim($_POST['nombre'] ?? ''),
            'descripcion'    => trim($_POST['descripcion'] ?? ''),
            'imagen'         => $imagen,
            'tipo'           => trim($_POST['tipo'] ?? ''),
            'fecha'          => $_POST['fecha'] ?? '',
            'hora_inicio'    => $_POST['hora_inicio'] ?? '',
            'operador_id'    => (int) ($_POST['operador_id'] ?? 0),
            'registrado_por' => null,
            'estado'         => trim($_POST['estado'] ?? 'Borrador')
        ];

        $actividadId = $this->actividadModel->crear($data);

        if ($actividadId) {
            $this->actividadModel->crearParticipacionInicial($actividadId);
        }

        header('Location: ' . BASE_URL . '/actividades');
        exit;
    }

    public function editar()
    {
        $this->validarSesion();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $usuario = $_SESSION['user'];
        $actividad = $this->actividadModel->obtenerPorId($id);
        $operadores = $this->actividadModel->obtenerOperadoresActivosReserva();

        if (!$actividad) {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $contenido = ROOT . '/app/views/admin/actividades/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $actividadActual = $this->actividadModel->obtenerPorId($id);

        if (!$actividadActual) {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $imagen = $actividadActual['imagen'];

        if (!empty($_FILES['imagen']['name'])) {
            $directorio = ROOT . '/public/uploads/actividades/';

            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreArchivo = time() . '_' . preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $_FILES['imagen']['name']);
            $rutaFisica = $directorio . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFisica)) {
                $imagen = 'uploads/actividades/' . $nombreArchivo;
            }
        }

        $data = [
            'nombre'      => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'imagen'      => $imagen,
            'tipo'        => trim($_POST['tipo'] ?? ''),
            'fecha'       => $_POST['fecha'] ?? '',
            'hora_inicio' => $_POST['hora_inicio'] ?? '',
            'operador_id' => (int) ($_POST['operador_id'] ?? 0),
            'estado'      => trim($_POST['estado'] ?? 'Borrador')
        ];

        $this->actividadModel->actualizar($id, $data);

        header('Location: ' . BASE_URL . '/actividades');
        exit;
    }

    public function ver()
    {
        $this->validarSesion();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $usuario = $_SESSION['user'];
        $actividad = $this->actividadModel->obtenerPorId($id);

        if (!$actividad) {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $this->actividadModel->crearParticipacionInicial($id);
        $participantes = $this->actividadModel->obtenerParticipacionPorActividad($id);

        $contenido = ROOT . '/app/views/admin/actividades/ver.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function eliminar()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/actividades/eliminar');
            exit;
        }

        $id = $_POST['id'] ?? null;

        if ($id) {
            $this->actividadModel->eliminar($id);
        }

        header('Location: ' . BASE_URL . '/actividades');
        exit;
    }

    public function cambiarEstadoParticipacion()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/actividades');
            exit;
        }

        $actividad_id = (int) ($_POST['actividad_id'] ?? 0);
        $operador_id  = (int) ($_POST['operador_id'] ?? 0);
        $estado       = trim($_POST['estado'] ?? 'Pendiente');
        $observacion  = trim($_POST['observacion'] ?? '');

        if ($actividad_id > 0 && $operador_id > 0) {
            $this->actividadModel->actualizarEstadoParticipacion(
                $actividad_id,
                $operador_id,
                $estado,
                $observacion !== '' ? $observacion : null
            );
        }

        header('Location: ' . BASE_URL . '/actividades/ver?id=' . $actividad_id);
        exit;
    }
}