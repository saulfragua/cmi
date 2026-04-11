<div class="p-4 text-white bg-black min-h-screen">

    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">✏️ Editar Especialidad</h1>

    <form action="<?= BASE_URL ?>/especialidades/actualizar"
          method="POST"
          enctype="multipart/form-data"
          class="max-w-xl bg-[#111827] border border-[#2b3d57] p-6 rounded">

        <input type="hidden" name="id" value="<?= $especialidad['id'] ?>">

        <div class="mb-4">
            <label>Nombre</label>
            <input type="text" name="nombre"
                   value="<?= htmlspecialchars($especialidad['nombre']) ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label>Sigla</label>
            <input type="text" name="sigla"
                   value="<?= htmlspecialchars($especialidad['sigla']) ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label>Imagen actual</label><br>

            <?php if (!empty($especialidad['imagen'])): ?>
                <img src="<?= BASE_URL ?>/assets/img/especialidades/<?= htmlspecialchars($especialidad['imagen']) ?>"
                     class="w-16 h-16 mb-2 border border-gray-600">
            <?php else: ?>
                <span class="text-gray-500 text-sm">Sin imagen</span>
            <?php endif; ?>

            <input type="file" name="imagen"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded mt-2">
        </div>

        <div class="flex gap-3">
            <button class="bg-blue-600 px-4 py-2 rounded">Actualizar</button>
            <a href="<?= BASE_URL ?>/especialidades" class="bg-gray-600 px-4 py-2 rounded">Cancelar</a>
        </div>

    </form>

</div>