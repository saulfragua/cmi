<?php

require_once ROOT . '/app/models/Rango.php';

class RangosController {

    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $this->modelo = new Rango();
    }

    public function index() {
        $rangos = $this->modelo->obtenerTodos();
        $contenido = ROOT . '/app/views/admin/rangos/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    private function limpiarNombreArchivo($texto) {
        $texto = strtolower($texto);
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $texto = preg_replace('/[^a-z0-9]/', '_', $texto);
        $texto = preg_replace('/_+/', '_', $texto);
        return trim($texto, '_');
    }

    public function crear() {
        $contenido = ROOT . '/app/views/admin/rangos/crear.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $sigla  = trim($_POST['sigla'] ?? '');
            $imagen = null;

            if (!empty($_FILES['imagen']['name'])) {
                $directorio = ROOT . '/public/assets/img/rangos/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $nombreArchivo = $nombreLimpio . '.' . $extension;
                $rutaDestino = $directorio . $nombreArchivo;

                $contador = 1;
                while (file_exists($rutaDestino)) {
                    $nombreArchivo = $nombreLimpio . '_' . $contador . '.' . $extension;
                    $rutaDestino = $directorio . $nombreArchivo;
                    $contador++;
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = $nombreArchivo;
                }
            }

            $this->modelo->crear($nombre, $sigla, $imagen);
        }

        header('Location: ' . BASE_URL . '/rangos');
        exit;
    }

    public function editar() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "❌ ID no recibido";
            exit;
        }

        $rango = $this->modelo->obtenerPorId($id);

        if (!$rango) {
            echo "❌ Rango no encontrado";
            exit;
        }

        $contenido = ROOT . '/app/views/admin/rangos/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');
            $sigla  = trim($_POST['sigla'] ?? '');
            $imagen = null;

            $rangoActual = $this->modelo->obtenerPorId($id);

            if (!empty($_FILES['imagen']['name'])) {
                $directorio = ROOT . '/public/assets/img/rangos/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $nombreArchivo = $nombreLimpio . '.' . $extension;
                $rutaDestino = $directorio . $nombreArchivo;

                // eliminar imagen anterior si existe y es diferente
                if ($rangoActual && !empty($rangoActual['imagen'])) {
                    $rutaImagenAnterior = $directorio . $rangoActual['imagen'];

                    if (file_exists($rutaImagenAnterior) && $rangoActual['imagen'] !== $nombreArchivo) {
                        unlink($rutaImagenAnterior);
                    }
                }

                // si ya existe una imagen con ese mismo nombre, la reemplaza
                if (file_exists($rutaDestino)) {
                    unlink($rutaDestino);
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = $nombreArchivo;
                }
            }

            $this->modelo->actualizar($id, $nombre, $sigla, $imagen);
        }

        header('Location: ' . BASE_URL . '/rangos');
        exit;
    }

    public function activar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $this->modelo->cambiarEstado($id, 'Activo');
        }

        header('Location: ' . BASE_URL . '/rangos');
        exit;
    }

    public function inactivar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $this->modelo->cambiarEstado($id, 'Inactivo');
        }

        header('Location: ' . BASE_URL . '/rangos');
        exit;
    }

    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $rango = $this->modelo->obtenerPorId($id);

                if ($rango && !empty($rango['imagen'])) {
                    $rutaImagen = ROOT . '/public/assets/img/rangos/' . $rango['imagen'];

                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }

                $this->modelo->eliminar($id);
            }
        }

        header('Location: ' . BASE_URL . '/rangos');
        exit;
    }
}