<div class="p-4 text-white bg-black min-h-screen">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-[#c8982e]">🏢 Panel de Unidades</h1>

        <a href="<?= BASE_URL ?>/unidades/crear"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
            + Crear Unidad
        </a>
    </div>

    <div class="border border-[#2b3d57] bg-black overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-[#22324a] text-white">
                <tr>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">ID</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Imagen</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Nombre</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Sigla</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Estado</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($unidades)): ?>
                    <?php foreach ($unidades as $u): ?>
                        <tr class="hover:bg-[#0b1220]">

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= $u['id'] ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if (!empty($u['imagen'])): ?>
                                    <img src="<?= BASE_URL ?>/assets/img/unidades/<?= $u['imagen'] ?>"
                                         class="w-10 h-10 object-cover rounded border border-gray-600">
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">N/A</span>
                                <?php endif; ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= $u['nombre'] ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= $u['sigla'] ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if ($u['estado'] == 'Activo'): ?>
                                    <span class="text-green-400">🟢 Activo</span>
                                <?php else: ?>
                                    <span class="text-red-400">🔴 Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <div class="flex flex-wrap gap-2">

                                    <a href="<?= BASE_URL ?>/unidades/editar?id=<?= $u['id'] ?>"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 text-xs rounded">
                                        Editar
                                    </a>

                                    <?php if ($u['estado'] == 'Activo'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/unidades/inactivar">
                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                            <button class="bg-yellow-600 hover:bg-yellow-700 text-xs px-2 py-1 rounded">
                                                Inactivar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?= BASE_URL ?>/unidades/activar">
                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                            <button class="bg-green-600 hover:bg-green-700 text-xs px-2 py-1 rounded">
                                                Activar
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <form method="POST" action="<?= BASE_URL ?>/unidades/eliminar"
                                          onsubmit="return confirm('¿Eliminar esta unidad?')">
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <button class="bg-red-600 hover:bg-red-700 text-xs px-2 py-1 rounded">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">
                            No hay unidades registradas
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>