<?php

require_once ROOT . '/app/models/Especialidad.php';

class EspecialidadesController {

    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $this->modelo = new Especialidad();
    }

    private function limpiarNombreArchivo($texto) {
        $texto = strtolower($texto);
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $texto = preg_replace('/[^a-z0-9]/', '_', $texto);
        $texto = preg_replace('/_+/', '_', $texto);
        return trim($texto, '_');
    }

    public function index() {
        $especialidades = $this->modelo->obtenerTodos();
        $contenido = ROOT . '/app/views/admin/especialidades/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function crear() {
        $contenido = ROOT . '/app/views/admin/especialidades/crear.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $sigla  = trim($_POST['sigla'] ?? '');
            $imagen = null;

            if (!empty($_FILES['imagen']['name'])) {
                $directorio = ROOT . '/public/assets/img/especialidades/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $nombreArchivo = $nombreLimpio . '.' . $extension;
                $rutaDestino = $directorio . $nombreArchivo;

                if (file_exists($rutaDestino)) {
                    unlink($rutaDestino);
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = $nombreArchivo;
                }
            }

            $this->modelo->crear($nombre, $sigla, $imagen);
        }

        header('Location: ' . BASE_URL . '/especialidades');
        exit;
    }

    public function editar() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "❌ ID no recibido";
            exit;
        }

        $especialidad = $this->modelo->obtenerPorId($id);

        if (!$especialidad) {
            echo "❌ Especialidad no encontrada";
            exit;
        }

        $contenido = ROOT . '/app/views/admin/especialidades/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');
            $sigla  = trim($_POST['sigla'] ?? '');
            $imagen = null;

            $especialidadActual = $this->modelo->obtenerPorId($id);

            if (!empty($_FILES['imagen']['name'])) {
                $directorio = ROOT . '/public/assets/img/especialidades/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $nombreArchivo = $nombreLimpio . '.' . $extension;
                $rutaDestino = $directorio . $nombreArchivo;

                if ($especialidadActual && !empty($especialidadActual['imagen'])) {
                    $rutaImagenAnterior = $directorio . $especialidadActual['imagen'];

                    if (file_exists($rutaImagenAnterior) && $especialidadActual['imagen'] !== $nombreArchivo) {
                        unlink($rutaImagenAnterior);
                    }
                }

                if (file_exists($rutaDestino)) {
                    unlink($rutaDestino);
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = $nombreArchivo;
                }
            }

            $this->modelo->actualizar($id, $nombre, $sigla, $imagen);
        }

        header('Location: ' . BASE_URL . '/especialidades');
        exit;
    }

    public function activar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $this->modelo->cambiarEstado($id, 'Activo');
        }

        header('Location: ' . BASE_URL . '/especialidades');
        exit;
    }

    public function inactivar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $this->modelo->cambiarEstado($id, 'Inactivo');
        }

        header('Location: ' . BASE_URL . '/especialidades');
        exit;
    }

    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $especialidad = $this->modelo->obtenerPorId($id);

                if ($especialidad && !empty($especialidad['imagen'])) {
                    $rutaImagen = ROOT . '/public/assets/img/especialidades/' . $especialidad['imagen'];

                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }

                $this->modelo->eliminar($id);
            }
        }

        header('Location: ' . BASE_URL . '/especialidades');
        exit;
    }
}