<?php

require_once ROOT . '/app/models/Unidad.php';

class UnidadesController {

    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $this->modelo = new Unidad();
    }

    private function limpiarNombreArchivo($texto) {
        $texto = strtolower($texto);
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $texto = preg_replace('/[^a-z0-9]/', '_', $texto);
        return trim($texto, '_');
    }

    public function index() {
        $unidades = $this->modelo->obtenerTodos();
        $contenido = ROOT . '/app/views/admin/unidades/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function crear() {
        $contenido = ROOT . '/app/views/admin/unidades/crear.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = $_POST['nombre'];
            $sigla = $_POST['sigla'];
            $imagen = null;

            if (!empty($_FILES['imagen']['name'])) {

                $directorio = ROOT . '/public/assets/img/unidades/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
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

        header('Location: ' . BASE_URL . '/unidades');
    }

    public function editar() {
        $id = $_GET['id'];
        $unidad = $this->modelo->obtenerPorId($id);

        $contenido = ROOT . '/app/views/admin/unidades/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $sigla = $_POST['sigla'];
            $imagen = null;

            $unidadActual = $this->modelo->obtenerPorId($id);

            if (!empty($_FILES['imagen']['name'])) {

                $directorio = ROOT . '/public/assets/img/unidades/';

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombreLimpio = $this->limpiarNombreArchivo($nombre);
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $nombreArchivo = $nombreLimpio . '.' . $extension;
                $rutaDestino = $directorio . $nombreArchivo;

                if ($unidadActual && !empty($unidadActual['imagen'])) {
                    $rutaAnterior = $directorio . $unidadActual['imagen'];
                    if (file_exists($rutaAnterior)) {
                        unlink($rutaAnterior);
                    }
                }

                if (file_exists($rutaDestino)) {
                    unlink($rutaDestino);
                }

                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
                $imagen = $nombreArchivo;
            }

            $this->modelo->actualizar($id, $nombre, $sigla, $imagen);
        }

        header('Location: ' . BASE_URL . '/unidades');
    }

    public function activar() {
        $this->modelo->cambiarEstado($_POST['id'], 'Activo');
        header('Location: ' . BASE_URL . '/unidades');
    }

    public function inactivar() {
        $this->modelo->cambiarEstado($_POST['id'], 'Inactivo');
        header('Location: ' . BASE_URL . '/unidades');
    }

    public function eliminar() {

        $id = $_POST['id'];
        $unidad = $this->modelo->obtenerPorId($id);

        if ($unidad && !empty($unidad['imagen'])) {
            $ruta = ROOT . '/public/assets/img/unidades/' . $unidad['imagen'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        $this->modelo->eliminar($id);

        header('Location: ' . BASE_URL . '/unidades');
    }
}