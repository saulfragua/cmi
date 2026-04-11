<div class="p-3 md:p-4 text-white bg-black min-h-screen">

    <!-- TÍTULO -->
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">📋</span>
        <h1 class="text-[20px] font-semibold text-white">Panel de Operadores</h1>
    </div>

    <!-- TABLA -->
    <div class="border border-[#2b3d57] bg-black overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-[#22324a] text-white">
                <tr>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Código</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Nombre</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Fecha Nac.</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Rango</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Últ. ascenso</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Especialidad</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Unidad</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">País</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Teléfono</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Estado</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Acción</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Editar</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($operadores)): ?>
                    <?php foreach ($operadores as $op): ?>

                        <?php
                            $estado = strtolower(trim($op['estado'] ?? 'activo'));
                            $estadoTexto = ucfirst($estado);
                            $estadoColor = 'text-green-400';
                            $estadoPunto = '🟢';

                            if ($estado === 'reserva') {
                                $estadoColor = 'text-yellow-400';
                                $estadoPunto = '🟡';
                                $estadoTexto = 'Reserva';
                            } elseif ($estado === 'suspendido') {
                                $estadoColor = 'text-red-400';
                                $estadoPunto = '🔴';
                                $estadoTexto = 'Suspendido';
                            } elseif ($estado === 'retirado') {
                                $estadoColor = 'text-gray-400';
                                $estadoPunto = '⚫';
                                $estadoTexto = 'Retirado';
                            } else {
                                $estadoTexto = 'Activo';
                            }
                        ?>

                        <tr class="hover:bg-[#0b1220]">
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap text-yellow-300 font-semibold">
                                <?= htmlspecialchars($op['codigo'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['nombre_completo'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['fecha_nacimiento'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['rango'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['fecha_ultimo_ascenso'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['especialidad'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['unidad'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['pais'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['telefono'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <span class="<?= $estadoColor ?>">
                                    <?= $estadoPunto ?> <?= $estadoTexto ?>
                                </span>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <form method="POST" action="<?= BASE_URL ?>/admin/operadores/cambiarEstado" class="m-0">
                                    <input type="hidden" name="id" value="<?= $op['id'] ?>">
                                    <select name="estado"
                                            onchange="this.form.submit()"
                                            class="bg-black border border-gray-500 text-white text-xs px-2 py-[2px] outline-none">
                                        <option value="">Cambiar</option>
                                        <option value="Activo" <?= (($op['estado'] ?? '') == 'Activo') ? 'selected' : '' ?>>Activo</option>
                                        <option value="Reserva" <?= (($op['estado'] ?? '') == 'Reserva') ? 'selected' : '' ?>>Reserva</option>
                                        <option value="Suspendido" <?= (($op['estado'] ?? '') == 'Suspendido') ? 'selected' : '' ?>>Suspendido</option>
                                        <option value="Retirado" <?= (($op['estado'] ?? '') == 'Retirado') ? 'selected' : '' ?>>Retirado</option>
                                    </select>
                                </form>
                            </td>

<td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
    <div class="flex gap-2">
        <a href="<?= BASE_URL ?>/operadores/editar?id=<?= $op['id'] ?>"
           class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-xs px-3 py-1">
            Editar
        </a>

        <a href="<?= BASE_URL ?>/operadores/asignar?id=<?= $op['id'] ?>"
           class="inline-block bg-green-700 hover:bg-green-800 text-white text-xs px-3 py-1">
            Asignar
        </a>
    </div>
</td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="border border-[#2b3d57] px-2 py-3 text-center text-gray-400">
                            No hay operadores registrados
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>