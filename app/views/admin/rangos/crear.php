<div class="p-4 text-white bg-black min-h-screen">
    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">➕ Crear Rango</h1>

    <form action="<?= BASE_URL ?>/rangos/guardar" method="POST" enctype="multipart/form-data"
          class="max-w-xl bg-[#111827] border border-[#2b3d57] p-6 rounded">

        <div class="mb-4">
            <label class="block text-sm mb-2">Nombre</label>
            <input type="text" name="nombre" required
                   class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-2">Sigla</label>
            <input type="text" name="sigla" required
                   class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-2">Imagen</label>
            <input type="file" name="imagen"
                   class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Guardar
            </button>

            <a href="<?= BASE_URL ?>/rangos"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>