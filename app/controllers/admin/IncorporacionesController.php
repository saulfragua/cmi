<?php

require_once ROOT . '/app/models/Formulario.php';

class IncorporacionesController {

    private $modelo;

    public function __construct() {
        $this->modelo = new Formulario();
    }

    /**
     * 🔐 Validar sesión (evita repetir código)
     */
    private function validarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /**
     * 📋 Mostrar listado de incorporaciones
     */
    public function index() {

        $this->validarSesion();

        // Obtener datos desde el modelo
        $formularios = $this->modelo->obtenerTodos();

        // Vista
        $contenido = ROOT . '/app/views/admin/incorporaciones/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    /**
     * 💾 Guardar nueva incorporación
     * (Siempre inicia en estado 1 = Pendiente)
     */
    public function guardar() {

        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = [
                'nombre' => $_POST['nombre_completo'],
                'fecha' => $_POST['fecha_nacimiento'],
                'pais' => $_POST['pais'],
                'telefono' => $_POST['telefono']
            ];

            $this->modelo->crear($datos);

            header('Location: ' . BASE_URL . '/admin/incorporaciones');
            exit;
        }
    }

    /**
     * 🔄 Cambiar estado del formulario
     */
    public function actualizarEstado() {

        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $estado = $_POST['estado_id'];
            $observaciones = $_POST['observaciones'];

            // 👤 Toma automáticamente el usuario logueado
            $evaluador = $_SESSION['user']['id'];

            $this->modelo->cambiarEstado($id, $estado, $observaciones, $evaluador);

            header('Location: ' . BASE_URL . '/admin/incorporaciones');
            exit;
        }
    }

    /**
     * ❌ Eliminar registro
     */
    public function eliminar($id) {

        $this->validarSesion();

        $this->modelo->eliminar($id);

        header('Location: ' . BASE_URL . '/admin/incorporaciones');
        exit;
    }
}