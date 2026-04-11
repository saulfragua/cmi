<?php

require_once ROOT . '/app/models/Curso.php';

class CursosController {

    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $this->modelo = new Curso();
    }

    private function limpiarNombreArchivo($texto) {
        $texto = strtolower($texto);
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $texto = preg_replace('/[^a-z0-9]/', '_', $texto);
        $texto = preg_replace('/_+/', '_', $texto);
        return trim($texto, '_');
    }

    public function index() {
        $cursos = $this->modelo->obtenerTodos();
        $contenido = ROOT . '/app/views/admin/cursos/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function crear() {
        $contenido = ROOT . '/app/views/admin/cursos/crear.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $sigla  = trim($_POST['sigla'] ?? '');
            $imagen = null;

            if (!empty($_FILES['imagen']['name'])) {
                $directorio = ROOT . '/public/assets/img/cursos/';

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

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function editar() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "❌ ID no recibido";
            exit;
        }

        $curso = $this->modelo->obtenerPorId($id);

        if (!$curso) {
            echo "❌ Curso no encontrado";
            exit;
        }

        $contenido = ROOT . '/app/views/admin/cursos/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');
            $sigla  = trim($_POST['sigla'] ?? '');
            $imagen = null;

            $cursoActual = $this->modelo->obtenerPorId($id);

            if (!empty($_FILES['imagen']['name'])) {
                $directorio = ROOT . '/public/assets/img/cursos/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $nombreArchivo = $nombreLimpio . '.' . $extension;
                $rutaDestino = $directorio . $nombreArchivo;

                if ($cursoActual && !empty($cursoActual['imagen'])) {
                    $rutaAnterior = $directorio . $cursoActual['imagen'];

                    if (file_exists($rutaAnterior) && $cursoActual['imagen'] !== $nombreArchivo) {
                        unlink($rutaAnterior);
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

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function activar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $this->modelo->cambiarEstado($id, 'Activo');
        }

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function inactivar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $this->modelo->cambiarEstado($id, 'Inactivo');
        }

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $curso = $this->modelo->obtenerPorId($id);

                if ($curso && !empty($curso['imagen'])) {
                    $rutaImagen = ROOT . '/public/assets/img/cursos/' . $curso['imagen'];

                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }

                $this->modelo->eliminar($id);
            }
        }

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }
}