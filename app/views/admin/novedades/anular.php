<div class="min-h-screen bg-[#0f172a] text-white p-6">
    <div class="max-w-2xl mx-auto bg-[#111827] border border-red-500/20 rounded-2xl shadow-xl p-6">
        <h1 class="text-3xl font-bold text-red-400 mb-2">Anular novedad</h1>
        <p class="text-sm text-gray-400 mb-6">Esta acción marcará la novedad como anulada y guardará el motivo.</p>

        <div class="bg-[#0f172a] border border-[#374151] rounded-xl p-4 mb-6">
            <p><strong class="text-[#c8982e]">Tipo:</strong> <?= htmlspecialchars($novedad['tipo']) ?></p>
            <p><strong class="text-[#c8982e]">Descripción:</strong> <?= htmlspecialchars($novedad['descripcion']) ?></p>
            <p><strong class="text-[#c8982e]">Estado actual:</strong> <?= htmlspecialchars($novedad['estado']) ?></p>
        </div>

        <form action="<?= BASE_URL ?>/novedades/guardarAnulacion" method="POST" class="space-y-5">
            <input type="hidden" name="id" value="<?= $novedad['id'] ?>">

            <div>
                <label class="block text-sm font-semibold mb-2">Motivo de anulación</label>
                <textarea name="motivo_anulacion"
                          rows="5"
                          required
                          class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white resize-none"
                          placeholder="Escriba el motivo por el cual se anula esta novedad..."></textarea>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Confirmar anulación
                </button>

                <a href="<?= BASE_URL ?>/novedades"
                   class="bg-gray-700 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>