<?php

require_once __DIR__ . '/../../models/Formulario.php';
require_once __DIR__ . '/../../models/Operador.php';

class IncorporacionesController {

    private $modelo;
    private $operadorModelo;

    public function __construct() {
        $this->modelo = new Formulario();
        $this->operadorModelo = new Operador();
    }

    private function validarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index() {
        $this->validarSesion();

        $formularios = $this->modelo->obtenerTodos();

        $contenido = ROOT . '/app/views/admin/incorporaciones/index.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

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

    public function actualizarEstado() {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;
            $estado = $_POST['estado_id'] ?? null;
            $observaciones = trim($_POST['observaciones'] ?? '');

            if (!$id || !$estado) {
                die('❌ Faltan datos para actualizar el estado');
            }

            $evaluador = $_SESSION['user']['id'];

            $this->modelo->cambiarEstado($id, $estado, $observaciones, $evaluador);

            if ((int)$estado === 3) {
                $formulario = $this->modelo->obtenerPorId($id);

                if ($formulario) {
                    $existe = $this->operadorModelo->existeOperador(
                        $formulario['nombre_completo'],
                        $formulario['fecha_nacimiento'],
                        $formulario['telefono']
                    );

                    if (!$existe) {
                        $codigo = $this->operadorModelo->generarCodigo();

                        $this->operadorModelo->crear([
                            'codigo' => $codigo,
                            'clave' => password_hash('123456', PASSWORD_DEFAULT),
                            'foto_operador' => null,
                            'nombre_completo' => $formulario['nombre_completo'],
                            'fecha_nacimiento' => $formulario['fecha_nacimiento'],
                            'rango_id' => null,
                            'especialidad_id' => null,
                            'unidad_id' => null,
                            'pais' => $formulario['pais'],
                            'telefono' => $formulario['telefono'],
                            'rol' => 'operador',
                            'fecha_ultimo_ascenso' => null,
                            'usuario_actualiza' => $evaluador
                        ]);
                    }
                }
            }

            header('Location: ' . BASE_URL . '/admin/incorporaciones');
            exit;
        }
    }

    public function eliminar($id) {
        $this->validarSesion();

        $this->modelo->eliminar($id);

        header('Location: ' . BASE_URL . '/admin/incorporaciones');
        exit;
    }
}