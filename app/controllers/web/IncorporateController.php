<?php

require_once ROOT . '/app/models/Formulario.php';
require_once ROOT . '/app/models/Pais.php';

class incorporateController
{
    public function formulario()
    {
        $paisModel = new Pais();
        $paises = $paisModel->obtenerActivos();

        require ROOT . '/app/views/web/incorporate.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL);
            exit;
        }

        // Honeypot anti-spam
        if (!empty($_POST['website'])) {
            header("Location: " . BASE_URL);
            exit;
        }

        // Validar checks obligatorios
        if (!isset($_POST['normas']) || !isset($_POST['datos'])) {
            die("❌ Debes aceptar las normas y el tratamiento de datos.");
        }

        $data = [
            'nombre_completo'  => trim($_POST['nombre_completo'] ?? ''),
            'fecha_nacimiento' => trim($_POST['fecha_nacimiento'] ?? ''),
            'pais_id'          => trim($_POST['pais_id'] ?? ''),
            'telefono'         => trim($_POST['telefono'] ?? ''),
            'indicativo'       => trim($_POST['indicativo'] ?? ''),
            'discord'          => trim($_POST['discord'] ?? ''),
            'motivo'           => trim($_POST['motivo'] ?? '')
        ];

        // Validaciones básicas
        if (
            empty($data['nombre_completo']) ||
            empty($data['fecha_nacimiento']) ||
            empty($data['pais_id']) ||
            empty($data['telefono'])
        ) {
            die("❌ Faltan campos obligatorios por completar.");
        }

        $modelo = new Formulario();
        $resultado = $modelo->crear($data);

        if ($resultado) {
            header("Location: " . BASE_URL . "/?ok=1");
            exit;
        } else {
            die("❌ No se pudo guardar la solicitud.");
        }
    }
}