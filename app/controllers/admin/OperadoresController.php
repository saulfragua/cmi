<?php

require_once __DIR__ . '/../../models/Operador.php';

class OperadoresController {

    private $modelo;

    public function __construct()
    {
        $this->modelo = new Operador();
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
    }

    private function subirFoto($archivo, $nombreOperador)
    {
        if (empty($archivo['name'])) {
            return null;
        }

        $directorio = ROOT . '/public/assets/img/operadores/';

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreLimpio = strtolower($nombreOperador);
        $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreLimpio);
        $nombreLimpio = preg_replace('/[^a-z0-9]/', '_', $nombreLimpio);
        $nombreLimpio = preg_replace('/_+/', '_', $nombreLimpio);
        $nombreLimpio = trim($nombreLimpio, '_');

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $nombreArchivo = $nombreLimpio . '.' . $extension;
        $rutaDestino = $directorio . $nombreArchivo;

        if (file_exists($rutaDestino)) {
            unlink($rutaDestino);
        }

        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            return $nombreArchivo;
        }

        return null;
    }

public function index()
{
    $this->validarSesion();

$filtros = [
    'buscar' => $_GET['buscar'] ?? '',
    'estado' => $_GET['estado'] ?? '',
    'rango' => $_GET['rango'] ?? '',
    'especialidad' => $_GET['especialidad'] ?? ''
];

    $operadores = $this->modelo->filtrar($filtros);
    $total_operadores = ['total' => count($operadores)];
    $conteo_estados = $this->modelo->contarPorEstado();

    $rangosFiltro = $this->modelo->obtenerRangosActivos();
    $especialidadesFiltro = $this->modelo->obtenerEspecialidadesActivas();
    $estadosFiltro = $this->modelo->obtenerEstadosFiltro();

    $contenido = ROOT . '/app/views/admin/operadores/index.php';
    require ROOT . '/app/views/admin/layouts/main.php';
}

    public function editar()
    {
        $this->validarSesion();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "❌ ID no recibido";
            exit;
        }

        $operador = $this->modelo->obtenerPorId($id);

        if (!$operador) {
            echo "❌ Operador no encontrado";
            exit;
        }

        $rangos = $this->modelo->obtenerRangosActivos();
        $especialidades = $this->modelo->obtenerEspecialidadesActivas();
        $unidades = $this->modelo->obtenerUnidadesActivas();
        $cursos = $this->modelo->obtenerCursosActivos();

        $contenido = ROOT . '/app/views/admin/operadores/editar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function actualizar()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo "❌ ID no recibido";
                exit;
            }

            $operadorActual = $this->modelo->obtenerPorId($id);
            $foto = null;

            if (!empty($_FILES['foto_operador']['name'])) {
                $foto = $this->subirFoto($_FILES['foto_operador'], $_POST['nombre_completo'] ?? 'operador');

                if ($operadorActual && !empty($operadorActual['foto_operador'])) {
                    $rutaAnterior = ROOT . '/public/assets/img/operadores/' . $operadorActual['foto_operador'];

                    if (file_exists($rutaAnterior) && $operadorActual['foto_operador'] !== $foto) {
                        unlink($rutaAnterior);
                    }
                }
            }

            $datos = [
                'foto_operador' => $foto,
                'nombre_completo' => trim($_POST['nombre_completo'] ?? ''),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
                'rango_id' => !empty($_POST['rango_id']) ? $_POST['rango_id'] : null,
                'fecha_ultimo_ascenso' => !empty($_POST['fecha_ultimo_ascenso']) ? $_POST['fecha_ultimo_ascenso'] : null,
                'especialidad_id' => !empty($_POST['especialidad_id']) ? $_POST['especialidad_id'] : null,
                'unidad_id' => !empty($_POST['unidad_id']) ? $_POST['unidad_id'] : null,
                'curso_id' => !empty($_POST['curso_id']) ? $_POST['curso_id'] : null,
                'pais' => trim($_POST['pais'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'rol' => $_POST['rol'] ?? 'operador',
                'estado' => $_POST['estado'] ?? 'Activo',
                'usuario_actualiza' => $_SESSION['user']['id'] ?? null
            ];

            $this->modelo->actualizar($id, $datos);
        }

        header('Location: ' . BASE_URL . '/operadores');
        exit;
    }

    public function cambiarEstado()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $estado = $_POST['estado'] ?? null;
            $usuario = $_SESSION['user']['id'] ?? null;

            if ($id && $estado) {
                $this->modelo->cambiarEstado($id, $estado, $usuario);
            }
        }

        header('Location: ' . BASE_URL . '/operadores');
        exit;
    }

        public function asignar()
    {
        $this->validarSesion();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "❌ ID no recibido";
            exit;
        }

        $operador = $this->modelo->obtenerPorId($id);

        if (!$operador) {
            echo "❌ Operador no encontrado";
            exit;
        }

        $especialidades = $this->modelo->obtenerEspecialidadesActivas();
        $unidades = $this->modelo->obtenerUnidadesActivas();
        $cursos = $this->modelo->obtenerCursosActivos();

        $especialidadPrincipal = $this->modelo->obtenerEspecialidadPrincipal($id);
        $especialidadesAsignadas = $this->modelo->obtenerEspecialidadesAsignadas($id);
        $unidadesAsignadas = $this->modelo->obtenerUnidadesAsignadas($id);
        $cursosAsignados = $this->modelo->obtenerCursosAsignados($id);

        $contenido = ROOT . '/app/views/admin/operadores/asignar.php';
        require ROOT . '/app/views/admin/layouts/main.php';
    }

    public function guardarAsignaciones()
    {
        $this->validarSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $operadorId = $_POST['operador_id'] ?? null;

            if (!$operadorId) {
                echo "❌ Operador no recibido";
                exit;
            }

           $especialidades = $_POST['especialidades'] ?? [];
$especialidadPrincipal = $_POST['especialidad_principal'] ?? null;
$unidades = $_POST['unidades'] ?? [];
$cursos = $_POST['cursos'] ?? [];

            $this->modelo->guardarEspecialidadesAsignadas($operadorId, $especialidades, $especialidadPrincipal);
            $this->modelo->guardarUnidadesAsignadas($operadorId, $unidades);
            $this->modelo->guardarCursosAsignados($operadorId, $cursos);
        }

        header('Location: ' . BASE_URL . '/operadores');
        exit;
    }

    public function ver()
{
    $this->validarSesion();

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "❌ ID no recibido";
        exit;
    }

    $operador = $this->modelo->obtenerPorId($id);

    if (!$operador) {
        echo "❌ Operador no encontrado";
        exit;
    }

    $contenido = ROOT . '/app/views/admin/operadores/ver.php';
    require ROOT . '/app/views/admin/layouts/main.php';
}
}