
<?php include ROOT . '/app/views/layouts/header.php'; ?>
<div class="min-h-screen bg-[#0f172a] flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-[#111827] border border-[#374151] rounded-2xl shadow-xl p-6">
        <h1 class="text-2xl font-bold text-[#c8982e] mb-2">Registrar cuenta Steam</h1>
        <p class="text-sm text-gray-400 mb-6">
            Antes de continuar al perfil de operador, debes registrar tu usuario o enlace de Steam.
        </p>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'vacío'): ?>
            <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg text-sm">
                Debes ingresar tu Steam.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'guardar'): ?>
            <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg text-sm">
                No se pudo guardar el Steam. Intenta nuevamente.
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/operador/guardar-steam" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-300 mb-2">Steam</label>
                <input type="text"
                       name="steam"
                       placeholder="Ej: steamcommunity.com/id/usuario o tu usuario Steam"
                       class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white placeholder:text-gray-500 focus:outline-none focus:border-[#c8982e]"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-[#c8982e] hover:bg-[#d4a73a] text-black font-semibold py-3 rounded-lg transition">
                Guardar y continuar
            </button>
        </form>
    </div>
</div>