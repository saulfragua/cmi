<div class="min-h-screen bg-[#0f172a] text-white p-6">
    <div class="max-w-4xl mx-auto bg-[#111827] border border-[#374151] rounded-2xl shadow-xl p-6">
        <h1 class="text-3xl font-bold text-[#c8982e] mb-2">Editar novedad</h1>
        <p class="text-sm text-gray-400 mb-6">Actualizar información de la novedad</p>

        <form action="<?= BASE_URL ?>/novedades/actualizar" method="POST" class="space-y-5">
            <input type="hidden" name="id" value="<?= $novedad['id'] ?>">

            <div>
                <label class="block text-sm font-semibold mb-2">Operador</label>
                <select name="operador_id" required class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white">
                    <option value="">Seleccione un operador</option>
                    <?php foreach ($operadores as $op): ?>
                        <option value="<?= $op['id'] ?>" <?= $novedad['operador_id'] == $op['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($op['codigo'] . ' - ' . $op['nombre_completo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Tipo</label>
                    <select name="tipo" id="tipo" required class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white">
                        <option value="Llamado de atención" <?= $novedad['tipo'] === 'Llamado de atención' ? 'selected' : '' ?>>Llamado de atención</option>
                        <option value="Felicitación" <?= $novedad['tipo'] === 'Felicitación' ? 'selected' : '' ?>>Felicitación</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Estado</label>
                    <select name="estado" required class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white">
                        <option value="Activo" <?= $novedad['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="Cerrado" <?= $novedad['estado'] === 'Cerrado' ? 'selected' : '' ?>>Cerrado</option>
                        <option value="Anulado" <?= $novedad['estado'] === 'Anulado' ? 'selected' : '' ?>>Anulado</option>
                    </select>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-5" id="camposLlamado">
                <div>
                    <label class="block text-sm font-semibold mb-2">Nivel</label>
                    <select name="nivel" id="nivel" class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white">
                        <option value="">Seleccione</option>
                        <option value="Leve" <?= $novedad['nivel'] === 'Leve' ? 'selected' : '' ?>>Leve</option>
                        <option value="Moderado" <?= $novedad['nivel'] === 'Moderado' ? 'selected' : '' ?>>Moderado</option>
                        <option value="Grave" <?= $novedad['nivel'] === 'Grave' ? 'selected' : '' ?>>Grave</option>
                        <option value="Muy Grave" <?= $novedad['nivel'] === 'Muy Grave' ? 'selected' : '' ?>>Muy Grave</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Categoría</label>
                    <select name="categoria" id="categoria" class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white">
                        <option value="">Seleccione</option>
                        <option value="Disciplinario" <?= $novedad['categoria'] === 'Disciplinario' ? 'selected' : '' ?>>Disciplinario</option>
                        <option value="Operativo" <?= $novedad['categoria'] === 'Operativo' ? 'selected' : '' ?>>Operativo</option>
                        <option value="Administrativo" <?= $novedad['categoria'] === 'Administrativo' ? 'selected' : '' ?>>Administrativo</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Descripción</label>
                <textarea name="descripcion" rows="4" required class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white resize-none"><?= htmlspecialchars($novedad['descripcion']) ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Observaciones</label>
                <textarea name="observaciones" rows="3" class="w-full bg-[#0f172a] border border-[#374151] rounded-lg px-4 py-3 text-white resize-none"><?= htmlspecialchars($novedad['observaciones']) ?></textarea>
            </div>

            <?php if ($novedad['estado'] === 'Anulado'): ?>
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                    <p class="text-red-400 font-semibold mb-2">Novedad anulada</p>
                    <p class="text-sm text-gray-300"><strong>Fecha anulación:</strong> <?= $novedad['fecha_anulacion'] ? date('d/m/Y H:i', strtotime($novedad['fecha_anulacion'])) : 'No registrada' ?></p>
                    <p class="text-sm text-gray-300 mt-2"><strong>Motivo:</strong> <?= htmlspecialchars($novedad['motivo_anulacion'] ?? 'Sin motivo') ?></p>
                </div>
            <?php endif; ?>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                        class="bg-[#c8982e] hover:bg-[#d4a73a] text-black font-semibold px-6 py-3 rounded-lg transition">
                    Actualizar
                </button>

                <a href="<?= BASE_URL ?>/novedades"
                   class="bg-gray-700 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipo = document.getElementById('tipo');
    const camposLlamado = document.getElementById('camposLlamado');
    const nivel = document.getElementById('nivel');
    const categoria = document.getElementById('categoria');

    function toggleCampos() {
        if (tipo.value === 'Felicitación') {
            camposLlamado.style.display = 'none';
            nivel.value = '';
            categoria.value = '';
        } else {
            camposLlamado.style.display = 'grid';
        }
    }

    tipo.addEventListener('change', toggleCampos);
    toggleCampos();
});
</script>