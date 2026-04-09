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

      $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'pais' => $_POST['pais'] ?? '',
        'telefono' => $_POST['telefono'] ?? ''
      ];

      $modelo = new Formulario();
      $modelo->guardar($data);

      header("Location: " . BASE_URL . "");
      exit;
    }
    
    if (!isset($_POST['normas']) || !isset($_POST['datos'])) {
      die("❌ Debes aceptar las normas y el tratamiento de datos");
    }
  }
}