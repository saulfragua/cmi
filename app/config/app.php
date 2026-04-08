<?php
/**
 * ============================================
 * CONFIGURACIÓN GLOBAL DEL SISTEMA
 * ============================================
 */

// --------------------------------------------
// 🌍 ZONA HORARIA
// --------------------------------------------
date_default_timezone_set('America/Bogota');

// --------------------------------------------
// 🔗 URL BASE DEL PROYECTO
// --------------------------------------------
define('BASE_URL', '/cmi/public');

// --------------------------------------------
// 💰 MONEDA
// --------------------------------------------
define('MONEDA', 'COP');
define('SIMBOLO_MONEDA', '$');

// --------------------------------------------
// 🏢 NOMBRE DEL SISTEMA
// --------------------------------------------
define('APP_NAME', 'Comando Militar Internacional');

// --------------------------------------------
// 🔐 ENTORNO
// --------------------------------------------
define('ENV', 'local'); // local | produccion

// --------------------------------------------
// ⚠️ MOSTRAR ERRORES (solo desarrollo)
// --------------------------------------------
if (ENV === 'local') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}