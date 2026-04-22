<?php

/**
 * ============================================
 * VISTA DE LOGIN
 * ============================================
 */
include ROOT . '/app/views/layouts/header.php';

$mensajeError = '';

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'credenciales':
            $mensajeError = 'Código o contraseña incorrectos.';
            break;
        case 'campos':
            $mensajeError = 'Por favor complete todos los campos.';
            break;
        case 'estado':
            $mensajeError = 'Tu usuario no está habilitado para ingresar.';
            break;
        case 'permiso':
            $mensajeError = 'No tienes permisos para ingresar a este panel.';
            break;
        case 'tipo':
            $mensajeError = 'Tipo de acceso no válido.';
            break;
        default:
            $mensajeError = 'Ocurrió un error al intentar iniciar sesión.';
            break;
    }
}
?>

<!-- FONDO OSCURO TIPO MODAL -->
<div class="fixed inset-0 z-[9999] bg-black/75 backdrop-blur-[2px] flex items-center justify-center px-4">

    <!-- CAJA MODAL -->
    <div class="relative w-full max-w-md bg-gradient-to-b from-[#1a1a1a] to-[#101010]
                border border-[#2a2a2a] rounded-lg
                shadow-[0_0_40px_rgba(0,0,0,0.9)] p-8">

        <!-- Línea superior dorada -->
        <div class="absolute top-0 left-0 w-full h-[2px] bg-[#c8982e] rounded-t-lg"></div>

        <!-- BOTÓN CERRAR -->
        <button onclick="window.location.href='<?= BASE_URL ?>'"
                class="absolute top-3 right-4 text-gray-400 hover:text-[#c8982e] text-2xl leading-none">
            ×
        </button>

        <!-- LOGO -->
        <div class="flex justify-center mb-4">
            <img src="<?= BASE_URL ?>/assets/img/logos/escudo-Photoroom.png"
                 alt="Escudo CMI"
                 class="h-16 w-auto">
        </div>

        <!-- TÍTULO -->
        <h2 class="text-2xl font-bold text-white tracking-widest mb-6 text-center">
            ACCESO CMI
        </h2>

        <!-- ALERTA VISUAL -->
        <?php if (!empty($mensajeError)): ?>
            <div class="mb-4 bg-red-900/40 border border-red-700 text-red-200 px-4 py-3 rounded-md text-sm text-center">
                <?= htmlspecialchars($mensajeError) ?>
            </div>

            <script>
                alert('<?= addslashes($mensajeError) ?>');
            </script>
        <?php endif; ?>

        <!-- FORMULARIO -->
        <form action="<?= BASE_URL ?>/login" method="POST" class="space-y-5">
            <input type="text"
                   name="codigo"
                   placeholder="Código"
                   value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>"
                   class="w-full bg-black border border-[#333] px-4 py-3 text-white outline-none focus:border-[#c8982e]">

            <input type="password"
                   name="clave"
                   placeholder="Clave"
                   class="w-full bg-black border border-[#333] px-4 py-3 text-white outline-none focus:border-[#c8982e]">

            <select name="tipo"
                    class="w-full bg-black border border-[#333] px-4 py-3 text-white outline-none focus:border-[#c8982e]">
                <option value="">Seleccione</option>
                <option value="operador">Operador</option>
                <option value="mando">Mando</option>
                <option value="admin">Administrador</option>
            </select>

            <button type="submit"
                    class="w-full bg-[#c8982e] hover:bg-[#b88a24] transition-all duration-300 py-3 font-bold text-black tracking-wide">
                INGRESAR
            </button>
        </form>
    </div>
</div>