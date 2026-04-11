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

// ================= ADMIN OPERADORES =================
$router->get('/operadores', 'OperadoresController@index');
$router->get('/operadores/editar', 'OperadoresController@editar');
$router->post('/operadores/actualizar', 'OperadoresController@actualizar');
$router->post('/operadores/cambiarEstado', 'OperadoresController@cambiarEstado');
$router->get('/operadores/asignar', 'OperadoresController@asignar');
$router->post('/operadores/guardarAsignaciones', 'OperadoresController@guardarAsignaciones');

// ================= ADMIN RANGOS =================
$router->get('/rangos', 'RangosController@index');
$router->get('/rangos/crear', 'RangosController@crear');
$router->post('/rangos/guardar', 'RangosController@guardar');
$router->get('/rangos/editar', 'RangosController@editar');
$router->post('/rangos/actualizar', 'RangosController@actualizar');
$router->post('/rangos/activar', 'RangosController@activar');
$router->post('/rangos/inactivar', 'RangosController@inactivar');
$router->post('/rangos/eliminar', 'RangosController@eliminar');

// ================= ADMIN ESPECIALIDADES =================
$router->get('/especialidades', 'EspecialidadesController@index');
$router->get('/especialidades/crear', 'EspecialidadesController@crear');
$router->post('/especialidades/guardar', 'EspecialidadesController@guardar');
$router->get('/especialidades/editar', 'EspecialidadesController@editar');
$router->post('/especialidades/actualizar', 'EspecialidadesController@actualizar');
$router->post('/especialidades/activar', 'EspecialidadesController@activar');
$router->post('/especialidades/inactivar', 'EspecialidadesController@inactivar');
$router->post('/especialidades/eliminar', 'EspecialidadesController@eliminar');

// ================= ADMIN UNIDADES =================
$router->get('/unidades', 'UnidadesController@index');
$router->get('/unidades/crear', 'UnidadesController@crear');
$router->post('/unidades/guardar', 'UnidadesController@guardar');
$router->get('/unidades/editar', 'UnidadesController@editar');
$router->post('/unidades/actualizar', 'UnidadesController@actualizar');
$router->post('/unidades/activar', 'UnidadesController@activar');
$router->post('/unidades/inactivar', 'UnidadesController@inactivar');
$router->post('/unidades/eliminar', 'UnidadesController@eliminar');

// ================= ADMIN CURSOS =================
$router->get('/cursos', 'CursosController@index');
$router->get('/cursos/crear', 'CursosController@crear');
$router->post('/cursos/guardar', 'CursosController@guardar');
$router->get('/cursos/editar', 'CursosController@editar');
$router->post('/cursos/actualizar', 'CursosController@actualizar');
$router->post('/cursos/activar', 'CursosController@activar');
$router->post('/cursos/inactivar', 'CursosController@inactivar');
$router->post('/cursos/eliminar', 'CursosController@eliminar');

// --------------------------------------------
// ▶️ EJECUTAR APLICACIÓN
// --------------------------------------------
$router->run();

