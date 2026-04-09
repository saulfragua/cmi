<?php

class Controller {

    // 📦 Cargar modelo
    protected function model($model) {
        require_once "../app/models/" . $model . ".php";
        return new $model();
    }

    // 🖥️ Cargar vista
    protected function view($vista, $datos = []) {
        extract($datos);
        require_once "../app/views/" . $vista . ".php";
    }

    // 🔁 Redirección
    protected function redirect($ruta) {
        header("Location: " . $ruta);
        exit();
    }
}