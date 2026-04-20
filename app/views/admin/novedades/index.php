<div class="p-4 text-white bg-black min-h-screen">

    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-[#c8982e]">📝 Panel de Novedades</h1>
            <p class="text-sm text-gray-400 mt-1">Gestión de llamados de atención y felicitaciones</p>
        </div>

        <a href="<?= BASE_URL ?>/novedades/crear"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
            + Registrar Novedad
        </a>
    </div>

    <div class="border border-[#2b3d57] bg-black overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-[#22324a] text-white">
                <tr>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Operador</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Tipo</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Nivel</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Categoría</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Descripción</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Registrado por</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Estado</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Fecha</th>
                    <th class="border border-[#2b3d57] px-3 py-2 text-left">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($novedades)): ?>
                    <?php foreach ($novedades as $n): ?>
                        <tr class="hover:bg-[#0b1220]">

                            <!-- Operador -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <div class="font-semibold text-white">
                                    <?= htmlspecialchars($n['nombre_completo']) ?>
                                </div>
                                <div class="text-xs text-gray-400">
                                    <?= htmlspecialchars($n['codigo'] ?? 'Sin código') ?>
                                </div>
                            </td>

                            <!-- Tipo -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if ($n['tipo'] === 'Llamado de atención'): ?>
                                    <span class="text-red-400 font-semibold">🔴 <?= htmlspecialchars($n['tipo']) ?></span>
                                <?php elseif ($n['tipo'] === 'Felicitación'): ?>
                                    <span class="text-green-400 font-semibold">🟢 <?= htmlspecialchars($n['tipo']) ?></span>
                                <?php else: ?>
                                    <span class="text-gray-400"><?= htmlspecialchars($n['tipo']) ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- Nivel -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if (!empty($n['nivel'])): ?>
                                    <?php if ($n['nivel'] === 'Leve'): ?>
                                        <span class="text-green-400">🟢 <?= htmlspecialchars($n['nivel']) ?></span>
                                    <?php elseif ($n['nivel'] === 'Moderado'): ?>
                                        <span class="text-yellow-400">🟡 <?= htmlspecialchars($n['nivel']) ?></span>
                                    <?php elseif ($n['nivel'] === 'Grave'): ?>
                                        <span class="text-orange-400">🟠 <?= htmlspecialchars($n['nivel']) ?></span>
                                    <?php elseif ($n['nivel'] === 'Muy Grave'): ?>
                                        <span class="text-red-400">🔴 <?= htmlspecialchars($n['nivel']) ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400"><?= htmlspecialchars($n['nivel']) ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">N/A</span>
                                <?php endif; ?>
                            </td>

                            <!-- Categoría -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if (!empty($n['categoria'])): ?>
                                    <?php if ($n['categoria'] === 'Disciplinario'): ?>
                                        <span class="text-red-400">🔴 <?= htmlspecialchars($n['categoria']) ?></span>
                                    <?php elseif ($n['categoria'] === 'Operativo'): ?>
                                        <span class="text-blue-400">🔵 <?= htmlspecialchars($n['categoria']) ?></span>
                                    <?php elseif ($n['categoria'] === 'Administrativo'): ?>
                                        <span class="text-yellow-400">🟡 <?= htmlspecialchars($n['categoria']) ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400"><?= htmlspecialchars($n['categoria']) ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">N/A</span>
                                <?php endif; ?>
                            </td>

                            <!-- Descripción -->
                            <td class="border border-[#2b3d57] px-3 py-2 max-w-xs">
                                <div class="truncate text-gray-200" title="<?= htmlspecialchars($n['descripcion']) ?>">
                                    <?= htmlspecialchars($n['descripcion']) ?>
                                </div>
                            </td>

                            <!-- Registrado por -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if (!empty($n['registrado_por'])): ?>
                                    <span class="text-indigo-400 font-semibold">
                                        ID: <?= htmlspecialchars($n['registrado_por']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">No registrado</span>
                                <?php endif; ?>
                            </td>

                            <!-- Estado -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <?php if ($n['estado'] === 'Activo'): ?>
                                    <span class="text-green-400">🟢 Activo</span>
                                <?php elseif ($n['estado'] === 'Cerrado'): ?>
                                    <span class="text-blue-400">🔵 Cerrado</span>
                                <?php elseif ($n['estado'] === 'Anulado'): ?>
                                    <span class="text-red-400">🔴 Anulado</span>
                                <?php else: ?>
                                    <span class="text-gray-400"><?= htmlspecialchars($n['estado']) ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- Fecha -->
                            <td class="border border-[#2b3d57] px-3 py-2 text-sm text-gray-300">
                                <?= !empty($n['fecha_registro']) ? date('d/m/Y H:i', strtotime($n['fecha_registro'])) : 'Sin fecha' ?>
                            </td>

                            <!-- Acciones -->
                            <td class="border border-[#2b3d57] px-3 py-2">
                                <div class="flex flex-wrap gap-2">

                                    <a href="<?= BASE_URL ?>/novedades/editar?id=<?= $n['id'] ?>"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 text-xs rounded">
                                        Editar
                                    </a>

                                    <?php if ($n['estado'] !== 'Anulado'): ?>
                                        <a href="<?= BASE_URL ?>/novedades/anular?id=<?= $n['id'] ?>"
                                           class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 text-xs rounded"
                                           onclick="return confirm('¿Deseas anular esta novedad?')">
                                            Anular
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-gray-500 py-4">
                            No hay novedades registradas
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>