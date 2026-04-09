<?php
/**
 * ============================================
 * PUNTO DE ENTRADA DE LA APLICACIÓN
 * ============================================
 */

// --------------------------------------------
// 🔐 INICIAR SESIÓN
// --------------------------------------------
session_start();

// --------------------------------------------
// 📁 DEFINIR RUTA RAÍZ
// --------------------------------------------
define('ROOT', dirname(__DIR__));

// --------------------------------------------
// ⚙️ CARGAR CONFIGURACIÓN GLOBAL
// --------------------------------------------
require_once ROOT . '/app/config/app.php';

// --------------------------------------------
// 🔄 AUTOLOAD (CARGA AUTOMÁTICA)
// --------------------------------------------
spl_autoload_register(function ($class) {

    $paths = [
        ROOT . '/app/core/',
        ROOT . '/app/controllers/',
        ROOT . '/app/controllers/admin/',
        ROOT . '/app/controllers/web/',
        ROOT . '/app/controllers/operador/',
        ROOT . '/app/models/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// --------------------------------------------
// 🚀 INICIALIZAR ROUTER
// --------------------------------------------
$router = new Router();

// --------------------------------------------
// 🌐 RUTAS DEL SISTEMA
// --------------------------------------------

// ================= PÚBLICAS =================
$router->get('/', 'PaginaController@inicio');
$router->get('/nosotros', 'PaginaController@nosotros');
$router->get('/requisitos', 'PaginaController@requisitos');

// ================= AUTENTICACIÓN =================
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@autenticar');
$router->get('/logout', 'AuthController@logout');

// ================= DASHBOARD =================
$router->get('/admin', 'DashboardController@index');
$router->get('/incorporaciones', 'IncorporacionesController@index');
$router->get('/operadores', 'OperadoresController@index');

// ================= INCORPORACIÓN =================
$router->get('/incorporate', 'IncorporateController@index');
$router->get('/incorporate/formulario', 'IncorporateController@formulario');
$router->post('/incorporate/guardar', 'IncorporateController@guardar');

// ================= ADMIN INCORPORACIONES =================
$router->get('/admin/incorporaciones', 'IncorporacionesController@index');
$router->post('/admin/incorporaciones/guardar', 'IncorporacionesController@guardar');
$router->post('/admin/incorporaciones/actualizarEstado', 'IncorporacionesController@actualizarEstado');
$router->get('/admin/incorporaciones/eliminar', 'IncorporacionesController@eliminar');
// --------------------------------------------
// ▶️ EJECUTAR APLICACIÓN
// --------------------------------------------
$router->run();

