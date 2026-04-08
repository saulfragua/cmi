<?php
/**
 * ============================================
 * CLASE ROUTER
 * ============================================
 * Se encarga de:
 * - Registrar rutas
 * - Detectar URL
 * - Ejecutar controlador y método
 */

class Router {

    private $routes = [];

    /**
     * Registrar rutas GET
     */
    public function get($url, $action) {
        $this->routes['GET'][$url] = $action;
    }

    /**
     * Registrar rutas POST
     */
    public function post($url, $action) {
        $this->routes['POST'][$url] = $action;
    }

    /**
     * Ejecutar la ruta solicitada
     */
    public function run() {

        // Método HTTP (GET o POST)
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtener URL amigable
        $url = $_GET['url'] ?? '/';
        $url = '/' . trim($url, '/');

        // Validar si existe la ruta
        if (!isset($this->routes[$method][$url])) {
            echo "❌ 404 - Página no encontrada";
            return;
        }

        // Obtener controlador y método
        $action = $this->routes[$method][$url];
        list($controllerName, $methodName) = explode('@', $action);

        // Validar controlador
        if (!class_exists($controllerName)) {
            echo "❌ Controlador no encontrado: $controllerName";
            return;
        }

        $controller = new $controllerName();

        // Validar método
        if (!method_exists($controller, $methodName)) {
            echo "❌ Método no encontrado: $methodName";
            return;
        }

        // Ejecutar método
        call_user_func([$controller, $methodName]);
    }
}