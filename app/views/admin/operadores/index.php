<div class="p-3 md:p-4 text-white bg-black min-h-screen">

    <!-- TÍTULO -->
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">📋</span>
        <h1 class="text-[20px] font-semibold text-white">Panel de Operadores</h1>
    </div>

  
    <!-- FILTRO -->
    <form method="GET" action="<?= BASE_URL ?>/operadores"
        class="mb-5 bg-[#111827] border border-[#2b3d57] rounded p-4">

        <div class="grid md:grid-cols-4 gap-4">

            <!-- BUSCADOR -->
            <div>
                <label class="block text-sm mb-2 text-gray-300">Buscar</label>
                <input type="text" name="buscar" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
                    placeholder="Nombre o apellido"
                    class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
            </div>

            <!-- ESTADO -->
            <div>
                <label class="block text-sm mb-2 text-gray-300">Estado</label>
                <select name="estado" class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
                    <option value="">Todos</option>
                    <?php foreach ($estadosFiltro as $estado): ?>
                        <option value="<?= $estado ?>" <?= (($_GET['estado'] ?? '') == $estado) ? 'selected' : '' ?>>
                            <?= $estado ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- RANGO -->
            <div>
                <label class="block text-sm mb-2 text-gray-300">Rango</label>
                <select name="rango" class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
                    <option value="">Todos</option>
                    <?php foreach ($rangosFiltro as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= (($_GET['rango'] ?? '') == $r['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- ESPECIALIDAD PRINCIPAL -->
            <div>
                <label class="block text-sm mb-2 text-gray-300">Especialidad</label>
                <select name="especialidad" class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
                    <option value="">Todas</option>
                    <?php foreach ($especialidadesFiltro as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= (($_GET['especialidad'] ?? '') == $e['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <!-- BOTONES -->
        <div class="flex gap-3 mt-4">
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded text-sm">
                Filtrar
            </button>

            <a href="<?= BASE_URL ?>/operadores"
                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm">
                Limpiar
            </a>
        </div>

    </form>

    <!-- TABLA -->
    <div class="border border-[#2b3d57] bg-black overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-[#22324a] text-white">
                <tr>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Código</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Nombre</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Fecha Nac.</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Edad</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Rango</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Últ. ascenso</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Especialidad</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Unidades</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">País</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Teléfono</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Estado</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Gestión</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($operadores)): ?>
                    <?php foreach ($operadores as $op): ?>
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
                                <?= htmlspecialchars($op['edad'] ?? 'N/A') ?> años
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['rango'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['fecha_ultimo_ascenso'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1">
                                <?= htmlspecialchars($op['especialidad_principal'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1">
                                <?= htmlspecialchars($op['unidades'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['pais'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['telefono'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <form method="POST" action="<?= BASE_URL ?>/operadores/cambiarEstado" class="m-0">
                                    <input type="hidden" name="id" value="<?= $op['id'] ?>">

                                    <select name="estado" onchange="this.form.submit()"
                                        class="bg-black border border-gray-500 text-white text-xs px-2 py-[4px] rounded outline-none w-full">
                                        <option value="Activo" <?= (($op['estado'] ?? '') == 'Activo') ? 'selected' : '' ?>>🟢
                                            Activo</option>
                                        <option value="Reserva" <?= (($op['estado'] ?? '') == 'Reserva') ? 'selected' : '' ?>>🟡
                                            Reserva</option>
                                        <option value="Suspendido" <?= (($op['estado'] ?? '') == 'Suspendido') ? 'selected' : '' ?>>🔴 Suspendido</option>
                                        <option value="Retirado" <?= (($op['estado'] ?? '') == 'Retirado') ? 'selected' : '' ?>>⚫
                                            Retirado</option>
                                    </select>
                                </form>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <a href="<?= BASE_URL ?>/operadores/ver?id=<?= $op['id'] ?>"
                                        class="inline-block bg-slate-700 hover:bg-slate-800 text-white text-xs px-3 py-1 rounded">
                                        Ver
                                    </a>

                                    <a href="<?= BASE_URL ?>/operadores/editar?id=<?= $op['id'] ?>"
                                        class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-xs px-3 py-1 rounded">
                                        Editar
                                    </a>

                                    <a href="<?= BASE_URL ?>/operadores/asignar?id=<?= $op['id'] ?>"
                                        class="inline-block bg-green-700 hover:bg-green-800 text-white text-xs px-3 py-1 rounded">
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