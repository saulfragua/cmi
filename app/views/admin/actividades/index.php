<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="border-l-4 border-[#c8982e] pl-4">
            <h1 class="text-2xl font-bold tracking-widest text-[#c8982e]">
                [CMI] PANEL DE ACTIVIDADES
            </h1>
            <p class="text-sm text-gray-400">
                Registro y control de actividades operativas
            </p>
        </div>

        <a href="<?= BASE_URL ?>/actividades/crear"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#c8982e] text-black font-bold hover:opacity-90 transition">
            ➕ Nueva actividad
        </a>
    </div>

    <div class="overflow-x-auto bg-[#0b1220] border border-[#1f2937] rounded-xl shadow-lg">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#111827] text-[#c8982e] uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Actividad</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Hora</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Participación</th>
                    <th class="px-4 py-3">Registra</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($actividades)): ?>
                    <?php foreach ($actividades as $a): ?>
                        <tr class="border-t border-[#1f2937] hover:bg-[#0f172a] transition">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-white"><?= htmlspecialchars($a['nombre']) ?></div>
                                <div class="text-xs text-gray-400">
                                    <?= htmlspecialchars($a['operador_nombre']) ?>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-gray-300"><?= htmlspecialchars($a['tipo']) ?></td>
                            <td class="px-4 py-3 text-gray-300"><?= htmlspecialchars($a['fecha']) ?></td>
                            <td class="px-4 py-3 text-gray-300"><?= htmlspecialchars(substr($a['hora_inicio'], 0, 5)) ?></td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    <?php
                                    switch ($a['estado']) {
                                        case 'Publicada':
                                            echo 'bg-green-900 text-green-300';
                                            break;
                                        case 'Finalizada':
                                            echo 'bg-blue-900 text-blue-300';
                                            break;
                                        case 'Cancelada':
                                            echo 'bg-red-900 text-red-300';
                                            break;
                                        default:
                                            echo 'bg-yellow-900 text-yellow-300';
                                            break;
                                    }
                                    ?>">
                                    <?= htmlspecialchars($a['estado']) ?>
                                </span>
                            </td>

                            <td class="px-4 py-3 text-xs">
                                <div class="text-green-400">Asisten: <?= (int) $a['total_asisten'] ?></div>
                                <div class="text-red-400">No asisten: <?= (int) $a['total_no_asisten'] ?></div>
                                <div class="text-yellow-400">Pendientes: <?= (int) $a['total_pendientes'] ?></div>
                            </td>

                            <td class="px-4 py-3 text-gray-300">
                                <?= htmlspecialchars($a['usuario_registra'] ?? 'N/A') ?>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    <a href="<?= BASE_URL ?>/actividades/ver?id=<?= $a['id'] ?>"
                                        class="px-3 py-1 rounded bg-blue-700 hover:bg-blue-600 text-white text-xs font-bold">
                                        Ver
                                    </a>

                                    <a href="<?= BASE_URL ?>/actividades/editar?id=<?= $a['id'] ?>"
                                        class="px-3 py-1 rounded bg-yellow-600 hover:bg-yellow-500 text-black text-xs font-bold">
                                        Editar
                                    </a>

                                    <form action="<?= BASE_URL ?>/actividades/eliminar" method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar esta actividad?')">
                                        <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                        <button type="submit"
                                            class="px-3 py-1 rounded bg-red-700 hover:bg-red-600 text-white text-xs font-bold">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                            No hay actividades registradas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>