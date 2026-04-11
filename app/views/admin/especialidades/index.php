<div class="p-4 text-white bg-black min-h-screen">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-[#c8982e]">🛠 Panel de Especialidades</h1>

        <a href="<?= BASE_URL ?>/especialidades/crear"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
            + Crear Especialidad
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
                <?php if (!empty($especialidades)): ?>
                    <?php foreach ($especialidades as $e): ?>
                        <tr class="hover:bg-[#0b1220]">

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= $e['id'] ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if (!empty($e['imagen'])): ?>
                                    <img src="<?= BASE_URL ?>/assets/img/especialidades/<?= htmlspecialchars($e['imagen']) ?>"
                                         class="w-10 h-10 object-cover rounded border border-gray-600">
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">N/A</span>
                                <?php endif; ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= htmlspecialchars($e['nombre']) ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= htmlspecialchars($e['sigla']) ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if ($e['estado'] == 'Activo'): ?>
                                    <span class="text-green-400">🟢 Activo</span>
                                <?php else: ?>
                                    <span class="text-red-400">🔴 Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <div class="flex flex-wrap gap-2">

                                    <a href="<?= BASE_URL ?>/especialidades/editar?id=<?= $e['id'] ?>"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 text-xs rounded">
                                        Editar
                                    </a>

                                    <?php if ($e['estado'] == 'Activo'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/especialidades/inactivar">
                                            <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                            <button class="bg-yellow-600 hover:bg-yellow-700 text-xs px-2 py-1 rounded">
                                                Inactivar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?= BASE_URL ?>/especialidades/activar">
                                            <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                            <button class="bg-green-600 hover:bg-green-700 text-xs px-2 py-1 rounded">
                                                Activar
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <form method="POST" action="<?= BASE_URL ?>/especialidades/eliminar"
                                          onsubmit="return confirm('¿Eliminar esta especialidad?')">
                                        <input type="hidden" name="id" value="<?= $e['id'] ?>">
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
                            No hay especialidades registradas
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>