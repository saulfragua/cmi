<?php
require_once ROOT . '/app/models/Formulario.php';
class incorporateController
{


  public function formulario()
  {
    require_once __DIR__ . '/../../views/web/incorporate.php';
  }


public function guardar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['normas']) || !isset($_POST['datos'])) {
            die("❌ Debes aceptar las normas y el tratamiento de datos");
        }

        $modelo = new Formulario();

        $modelo->crear([
            'nombre' => $_POST['nombre'] ?? '',
            'fecha' => $_POST['fecha_nacimiento'] ?? '',
            'pais' => $_POST['pais'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'motivo' => $_POST['motivo'] ?? ''
        ]);

        header("Location: " . BASE_URL);
        exit;
    }
}
}