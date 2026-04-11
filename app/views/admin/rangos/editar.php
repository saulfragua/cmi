<div class="p-4 text-white bg-black min-h-screen">
    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">✏️ Editar Rango</h1>

    <form action="<?= BASE_URL ?>/rangos/actualizar" method="POST" enctype="multipart/form-data"
          class="max-w-xl bg-[#111827] border border-[#2b3d57] p-6 rounded">

        <input type="hidden" name="id" value="<?= $rango['id'] ?>">

        <div class="mb-4">
            <label class="block text-sm mb-2">Nombre</label>
            <input type="text" name="nombre" required
                   value="<?= htmlspecialchars($rango['nombre']) ?>"
                   class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-2">Sigla</label>
            <input type="text" name="sigla" required
                   value="<?= htmlspecialchars($rango['sigla']) ?>"
                   class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-2">Imagen actual</label>
            <?php if (!empty($rango['imagen'])): ?>
                <img src="<?= BASE_URL ?>/assets/img/rangos/<?= htmlspecialchars($rango['imagen']) ?>"
                     alt="Rango"
                     class="w-16 h-16 object-cover rounded border border-gray-600 mb-3">
            <?php else: ?>
                <p class="text-gray-500 text-sm mb-3">Sin imagen</p>
            <?php endif; ?>

            <label class="block text-sm mb-2">Cambiar imagen</label>
            <input type="file" name="imagen"
                   class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Actualizar
            </button>

            <a href="<?= BASE_URL ?>/rangos"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>