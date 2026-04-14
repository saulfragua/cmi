<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <div class="mb-6 border-l-4 border-yellow-500 pl-4">
        <h1 class="text-2xl font-bold tracking-widest text-yellow-400">[CMI] EDITAR ACTIVIDAD</h1>
        <p class="text-sm text-gray-400">Actualizar información de la actividad</p>
    </div>

    <form action="<?= BASE_URL ?>/actividades/actualizar"
          method="POST"
          enctype="multipart/form-data"
          class="grid md:grid-cols-2 gap-6 bg-[#0b1220] p-6 rounded-xl border border-[#1f2937]">

        <input type="hidden" name="id" value="<?= $actividad['id'] ?>">

        <div>
            <label class="block mb-2 text-sm text-gray-300">Nombre de actividad</label>
            <input type="text" name="nombre" required
                   value="<?= htmlspecialchars($actividad['nombre']) ?>"
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Tipo</label>
            <select name="tipo" required
                    class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
                <?php
                $tipos = ['curso', 'entrenamiento', 'mision', 'operacion', 'ejercicio'];
                foreach ($tipos as $tipo):
                ?>
                    <option value="<?= $tipo ?>" <?= $actividad['tipo'] === $tipo ? 'selected' : '' ?>>
                        <?= ucfirst($tipo) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 text-sm text-gray-300">Descripción</label>
            <textarea name="descripcion" rows="4"
                      class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white"><?= htmlspecialchars($actividad['descripcion']) ?></textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Imagen actual</label>
            <?php if (!empty($actividad['imagen'])): ?>
                <img src="<?= BASE_URL . '/' . $actividad['imagen'] ?>" alt="Imagen"
                     class="w-40 h-28 object-cover rounded-lg border border-[#374151] mb-3">
            <?php else: ?>
                <div class="text-gray-400 text-sm mb-3">Sin imagen</div>
            <?php endif; ?>

            <input type="file" name="imagen" accept="image/*"
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Estado</label>
            <select name="estado" required
                    class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
                <?php
                $estados = ['Borrador', 'Publicada', 'Finalizada', 'Cancelada'];
                foreach ($estados as $estado):
                ?>
                    <option value="<?= $estado ?>" <?= $actividad['estado'] === $estado ? 'selected' : '' ?>>
                        <?= $estado ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Fecha</label>
            <input type="date" name="fecha" required
                   value="<?= htmlspecialchars($actividad['fecha']) ?>"
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Hora inicio</label>
            <input type="time" name="hora_inicio" required
                   value="<?= htmlspecialchars(substr($actividad['hora_inicio'], 0, 5)) ?>"
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 text-sm text-gray-300">Operador responsable</label>
            <select name="operador_id" required
                    class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
                <?php foreach ($operadores as $o): ?>
                    <option value="<?= $o['id'] ?>" <?= (int)$actividad['operador_id'] === (int)$o['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($o['nombre_completo']) ?> - <?= htmlspecialchars($o['estado']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="md:col-span-2 flex gap-3">
            <button type="submit"
                    class="px-6 py-3 rounded-lg bg-yellow-500 text-black font-bold hover:opacity-90">
                Actualizar
            </button>

            <a href="<?= BASE_URL ?>/actividades"
               class="px-6 py-3 rounded-lg bg-gray-700 text-white font-bold hover:bg-gray-600">
                Cancelar
            </a>
        </div>
    </form>
</div>