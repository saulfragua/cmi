<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <div class="mb-6 border-l-4 border-[#c8982e] pl-4">
        <h1 class="text-2xl font-bold tracking-widest text-[#c8982e]">[CMI] CREAR ACTIVIDAD</h1>
        <p class="text-sm text-gray-400">Registrar nueva actividad operativa</p>
    </div>

    <form action="<?= BASE_URL ?>/actividades/guardar"
          method="POST"
          enctype="multipart/form-data"
          class="grid md:grid-cols-2 gap-6 bg-[#0b1220] p-6 rounded-xl border border-[#1f2937]">

        <div>
            <label class="block mb-2 text-sm text-gray-300">Nombre de actividad</label>
            <input type="text" name="nombre" required
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Tipo</label>
            <select name="tipo" required
                    class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
                <option value="">Seleccione</option>
                <option value="curso">Curso</option>
                <option value="entrenamiento">Entrenamiento</option>
                <option value="mision">Misión</option>
                <option value="operacion">Operación</option>
                <option value="ejercicio">Ejercicio</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 text-sm text-gray-300">Descripción</label>
            <textarea name="descripcion" rows="4"
                      class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white"></textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Imagen</label>
            <input type="file" name="imagen" accept="image/*"
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Estado</label>
            <select name="estado" required
                    class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
                <option value="Borrador">Borrador</option>
                <option value="Publicada">Publicada</option>
                <option value="Finalizada">Finalizada</option>
                <option value="Cancelada">Cancelada</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Fecha</label>
            <input type="date" name="fecha" required
                   value="<?= htmlspecialchars($fechaSeleccionada ?? date('Y-m-d')) ?>"
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div>
            <label class="block mb-2 text-sm text-gray-300">Hora inicio</label>
            <input type="time" name="hora_inicio" required
                   class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 text-sm text-gray-300">Operador responsable</label>
            <select name="operador_id" required
                    class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white">
                <option value="">Seleccione operador</option>
                <?php foreach ($operadores as $o): ?>
                    <option value="<?= $o['id'] ?>">
                        <?= htmlspecialchars($o['nombre_completo']) ?> - <?= htmlspecialchars($o['estado']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="md:col-span-2 flex gap-3">
            <button type="submit"
                    class="px-6 py-3 rounded-lg bg-[#c8982e] text-black font-bold hover:opacity-90">
                Guardar actividad
            </button>

            <a href="<?= BASE_URL ?>/actividades"
               class="px-6 py-3 rounded-lg bg-gray-700 text-white font-bold hover:bg-gray-600">
                Cancelar
            </a>
        </div>
    </form>
</div>