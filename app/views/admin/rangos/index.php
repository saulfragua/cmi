<div class="p-4 text-white bg-black min-h-screen">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-[#c8982e]">🎖 Panel de Rangos</h1>

        <a href="<?= BASE_URL ?>/rangos/crear"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
            + Crear rango
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
                <?php if (!empty($rangos)): ?>
                    <?php foreach ($rangos as $r): ?>
                        <tr class="hover:bg-[#0b1220]">
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= $r['id'] ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if (!empty($r['imagen'])): ?>
                                    <img src="<?= BASE_URL ?>/assets/img/rangos/<?= htmlspecialchars($r['imagen']) ?>"
                                         alt="Rango"
                                         class="w-10 h-10 object-cover rounded border border-gray-600">
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">Sin imagen</span>
                                <?php endif; ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= htmlspecialchars($r['nombre']) ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?= htmlspecialchars($r['sigla']) ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if ($r['estado'] === 'Activo'): ?>
                                    <span class="text-green-400">🟢 Activo</span>
                                <?php else: ?>
                                    <span class="text-red-400">🔴 Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td class="border border-[#2b3d57] px-3 py-2">
                                <div class="flex flex-wrap gap-2">

<a href="<?= BASE_URL ?>/rangos/editar?id=<?= $r['id'] ?>"
   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
    Editar
</a>

                                    <?php if ($r['estado'] === 'Activo'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>/rangos/inactivar" onsubmit="return confirm('¿Inactivar este rango?')">
                                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                            <button type="submit"
                                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-xs">
                                                Inactivar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?= BASE_URL ?>/rangos/activar" onsubmit="return confirm('¿Activar este rango?')">
                                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                            <button type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                                Activar
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <form method="POST" action="<?= BASE_URL ?>/rangos/eliminar" onsubmit="return confirm('¿Eliminar este rango?')">
                                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="border border-[#2b3d57] px-3 py-4 text-center text-gray-400">
                            No hay rangos registrados.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>