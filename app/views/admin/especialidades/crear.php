<div class="p-4 text-white bg-black min-h-screen">

    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">➕ Crear Especialidad</h1>

    <form action="<?= BASE_URL ?>/especialidades/guardar"
          method="POST"
          enctype="multipart/form-data"
          class="max-w-xl bg-[#111827] border border-[#2b3d57] p-6 rounded">

        <div class="mb-4">
            <label>Nombre</label>
            <input type="text" name="nombre" required
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label>Sigla</label>
            <input type="text" name="sigla" required
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label>Imagen</label>
            <input type="file" name="imagen"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div class="flex gap-3">
            <button class="bg-green-600 px-4 py-2 rounded">Guardar</button>
            <a href="<?= BASE_URL ?>/especialidades" class="bg-gray-600 px-4 py-2 rounded">Cancelar</a>
        </div>

    </form>

</div>