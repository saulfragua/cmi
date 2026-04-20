<div class="p-4 text-white bg-black min-h-screen">

    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">✏️ Editar Operador</h1>

    <form action="<?= BASE_URL ?>/operadores/actualizar"
          method="POST"
          enctype="multipart/form-data"
          class="max-w-4xl bg-[#111827] border border-[#2b3d57] p-6 rounded grid md:grid-cols-2 gap-4">

        <input type="hidden" name="id" value="<?= htmlspecialchars($operador['id'] ?? '') ?>">

        <div>
            <label class="block mb-1">Código</label>
            <input type="text"
                   value="<?= htmlspecialchars($operador['codigo'] ?? '') ?>"
                   class="w-full bg-[#0b1220] border border-gray-700 px-3 py-2 rounded"
                   disabled>
        </div>

        <div>
            <label class="block mb-1">Foto operador</label>
            <input type="file"
                   name="foto_operador"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
            <?php if (!empty($operador['foto_operador'])): ?>
                <img src="<?= BASE_URL ?>/public/assets/img/operadores/<?= htmlspecialchars($operador['foto_operador']) ?>"
                     class="w-16 h-16 mt-2 border border-gray-600 rounded object-cover">
            <?php endif; ?>
        </div>

        <div>
            <label class="block mb-1">Nombre completo</label>
            <input type="text"
                   name="nombre_completo"
                   value="<?= htmlspecialchars($operador['nombre_completo'] ?? '') ?>"
                   required
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Alias</label>
            <input type="text"
                   name="alias"
                   value="<?= htmlspecialchars($operador['alias'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded"
                   placeholder="Alias del operador">
        </div>

        <div>
            <label class="block mb-1">Fecha nacimiento</label>
            <input type="date"
                   name="fecha_nacimiento"
                   value="<?= htmlspecialchars($operador['fecha_nacimiento'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Rango</label>
            <select name="rango_id"
                    id="rango_id"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="">Seleccione</option>
                <?php foreach ($rangos as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= (($operador['rango_id'] ?? '') == $r['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['nombre'] ?? '') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-1">Fecha último ascenso</label>
            <input type="date"
                   name="fecha_ultimo_ascenso"
                   id="fecha_ultimo_ascenso"
                   value="<?= htmlspecialchars($operador['fecha_ultimo_ascenso'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
            <p class="text-xs text-gray-400 mt-1">
                Se actualizará automáticamente si cambias el rango.
            </p>
        </div>

        <div>
            <label class="block mb-1">País</label>
            <select name="pais"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="">Seleccione un país</option>
                <?php foreach ($paises as $pais): ?>
                    <option value="<?= htmlspecialchars($pais['nombre']) ?>"
                        <?= (($operador['pais'] ?? '') === $pais['nombre']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($pais['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-1">Teléfono</label>
            <input type="text"
                   name="telefono"
                   value="<?= htmlspecialchars($operador['telefono'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Discord</label>
            <input type="text"
                   name="discord"
                   value="<?= htmlspecialchars($operador['discord'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded"
                   placeholder="Usuario de Discord">
        </div>

        <div>
            <label class="block mb-1">Steam</label>
            <input type="text"
                   name="steam"
                   value="<?= htmlspecialchars($operador['steam'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded"
                   placeholder="Steam ID">
        </div>

        <div>
            <label class="block mb-1">Nueva clave</label>
            <input type="password"
                   name="clave"
                   value=""
                   autocomplete="new-password"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded"
                   placeholder="Dejar en blanco para no cambiar">
            <p class="text-xs text-gray-400 mt-1">
                Si este campo queda vacío, la clave actual se conserva.
            </p>
        </div>

        <div>
            <label class="block mb-1">Rol</label>
            <select name="rol"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="operador" <?= (($operador['rol'] ?? '') == 'operador') ? 'selected' : '' ?>>Operador</option>
                <option value="mando" <?= (($operador['rol'] ?? '') == 'mando') ? 'selected' : '' ?>>Mando</option>
                <option value="admin" <?= (($operador['rol'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Estado</label>
            <select name="estado"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="Activo" <?= (($operador['estado'] ?? '') == 'Activo') ? 'selected' : '' ?>>Activo</option>
                <option value="Reserva" <?= (($operador['estado'] ?? '') == 'Reserva') ? 'selected' : '' ?>>Reserva</option>
                <option value="Suspendido" <?= (($operador['estado'] ?? '') == 'Suspendido') ? 'selected' : '' ?>>Suspendido</option>
                <option value="Retirado" <?= (($operador['estado'] ?? '') == 'Retirado') ? 'selected' : '' ?>>Retirado</option>
            </select>
        </div>

        <div class="md:col-span-2 flex justify-end gap-3 pt-4">
            <a href="<?= BASE_URL ?>/operadores"
               class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded">
                Cancelar
            </a>

            <button type="submit"
                    class="bg-[#c8982e] hover:bg-[#d6a93a] text-black font-semibold px-5 py-2 rounded">
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rango = document.getElementById('rango_id');
    const fechaAscenso = document.getElementById('fecha_ultimo_ascenso');
    const rangoInicial = rango ? rango.value : '';

    if (rango) {
        rango.addEventListener('change', function () {
            if (this.value !== '' && this.value !== rangoInicial) {
                const hoy = new Date();
                const yyyy = hoy.getFullYear();
                const mm = String(hoy.getMonth() + 1).padStart(2, '0');
                const dd = String(hoy.getDate()).padStart(2, '0');
                fechaAscenso.value = `${yyyy}-${mm}-${dd}`;
            }
        });
    }
});
</script>