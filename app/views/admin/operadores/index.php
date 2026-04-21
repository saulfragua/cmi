<div class="p-3 md:p-4 text-white bg-black min-h-screen">

    <?php
    function limpiarNumero($numero)
    {
        return preg_replace('/[^0-9]/', '', (string) $numero);
    }

    function construirWhatsapp($indicativo, $telefono)
    {
        $codigo = limpiarNumero($indicativo);
        $numero = limpiarNumero($telefono);

        if (empty($numero)) {
            return '';
        }

        if (!empty($codigo) && strpos($numero, $codigo) === 0) {
            return $numero;
        }

        return !empty($codigo) ? $codigo . $numero : $numero;
    }

    ?>

    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">📋</span>
        <h1 class="text-[20px] font-semibold text-white">Panel de Operadores</h1>
    </div>

    <form method="GET" action="<?= BASE_URL ?>/operadores"
        class="mb-5 bg-[#111827] border border-[#2b3d57] rounded p-4">

        <div class="grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm mb-2 text-gray-300">Buscar</label>
                <input type="text" name="buscar" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
                    placeholder="Nombre o apellido"
                    class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
            </div>

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

            <div>
                <label class="block text-sm mb-2 text-gray-300">Rango</label>
                <select name="rango" class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
                    <option value="">Todos</option>
                    <?php foreach ($rangosFiltro as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= (($_GET['rango'] ?? '') == $r['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['nombre'] ?? '') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm mb-2 text-gray-300">Especialidad</label>
                <select name="especialidad" class="w-full bg-black border border-gray-600 text-white px-3 py-2 rounded">
                    <option value="">Todas</option>
                    <?php foreach ($especialidadesFiltro as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= (($_GET['especialidad'] ?? '') == $e['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['nombre'] ?? '') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

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

    <div class="border border-[#2b3d57] bg-black overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-[#22324a] text-white">
                <tr>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Código</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Foto</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Nombre</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Fecha Nac.</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Edad</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Teléfono</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">País</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Rango</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Últ. ascenso</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Alias</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Discord</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Steam</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Especialidad</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Unidades</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Estado</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Gestión</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($operadores)): ?>
                    <?php foreach ($operadores as $op): ?>
                        <?php
                        $paisNombre = $op['pais_nombre'] ?? ($op['pais'] ?? '');
                        $paisBandera = $op['pais_bandera'] ?? '';
                        $paisIndicativo = $op['pais_indicativo'] ?? '';
                        $telefono = $op['telefono'] ?? '';
                        $whatsappNumero = construirWhatsapp($paisIndicativo, $telefono);
                        $mensajeWhatsapp = rawurlencode("Hola, te contactamos desde CMI.");
                        $linkWhatsapp = !empty($whatsappNumero)
                            ? "https://wa.me/{$whatsappNumero}?text={$mensajeWhatsapp}"
                            : '';

                        $fotoOperador = !empty($op['foto_operador'])
                            ? BASE_URL . '/assets/img/operadores/' . $op['foto_operador']
                            : BASE_URL . '/assets/img/default-user.png';
                        ?>
                        <tr class="hover:bg-[#0b1220]">
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap text-yellow-300 font-semibold">
                                <?= htmlspecialchars($op['codigo'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <img src="<?= htmlspecialchars($fotoOperador) ?>"
                                        alt="Foto de <?= htmlspecialchars($op['nombre_completo'] ?? 'Operador') ?>"
                                        class="w-12 h-12  object-cover border border-[#2b3d57] shadow-md">
                                </div>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['nombre_completo'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['fecha_nacimiento'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars((string) ($op['edad'] ?? 'N/A')) ?>        <?= isset($op['edad']) ? ' años' : '' ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-white">
                                        <?= htmlspecialchars(trim(($paisIndicativo ? $paisIndicativo . ' ' : '') . $telefono)) ?>
                                    </span>

                                    <?php if (!empty($linkWhatsapp)): ?>
                                        <a href="<?= htmlspecialchars($linkWhatsapp) ?>" target="_blank"
                                            class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white text-[11px] px-2 py-1 rounded"
                                            title="Abrir WhatsApp">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="w-3 h-3">
                                                <path
                                                    d="M20.52 3.48A11.94 11.94 0 0 0 12.04 0C5.41 0 .03 5.38.03 12c0 2.11.55 4.17 1.6 5.98L0 24l6.19-1.62A11.96 11.96 0 0 0 12.04 24c6.62 0 12-5.38 12-12 0-3.2-1.25-6.2-3.52-8.52ZM12.04 21.86c-1.78 0-3.53-.48-5.05-1.39l-.36-.21-3.67.96.98-3.58-.24-.37A9.83 9.83 0 0 1 2.21 12c0-5.42 4.41-9.83 9.83-9.83 2.62 0 5.08 1.02 6.93 2.88A9.75 9.75 0 0 1 21.87 12c0 5.42-4.41 9.86-9.83 9.86Zm5.39-7.36c-.29-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.66.15-.2.29-.76.96-.93 1.15-.17.2-.34.22-.64.08-.29-.15-1.24-.46-2.36-1.47-.87-.78-1.46-1.75-1.63-2.05-.17-.29-.02-.45.13-.59.13-.13.29-.34.44-.51.15-.17.19-.29.29-.49.1-.2.05-.37-.02-.52-.08-.15-.66-1.6-.91-2.19-.24-.57-.48-.49-.66-.5h-.56c-.2 0-.52.07-.79.37-.27.29-1.03 1-1.03 2.43 0 1.43 1.05 2.82 1.19 3.02.15.2 2.06 3.14 5 4.41.7.3 1.24.49 1.67.63.7.22 1.33.19 1.83.12.56-.08 1.75-.71 2-1.4.24-.69.24-1.28.17-1.4-.08-.12-.27-.2-.56-.34Z" />
                                            </svg>
                                            WhatsApp
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-xs">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1">
                                <div class="flex items-center gap-2 w-max">
                                    <?php if (!empty($paisBandera)): ?>
                                        <img src="<?= BASE_URL . '/assets/img/nacionalidad/' . htmlspecialchars($paisBandera) ?>"
                                            alt="<?= htmlspecialchars($paisNombre) ?>"
                                            class="w-5 h-4 object-cover rounded-sm border border-gray-700 shrink-0">
                                    <?php endif; ?>

                                    <span class="text-white whitespace-nowrap">
                                        <?= htmlspecialchars($paisNombre) ?>
                                    </span>
                                </div>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['rango'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['fecha_ultimo_ascenso'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['alias'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['discord'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($op['steam'] ?? 'N/A') ?>
                            </td>



                            <td class="border border-[#2b3d57] px-2 py-1">
                                <?= htmlspecialchars($op['especialidad_principal'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1">
                                <?= htmlspecialchars($op['unidades'] ?? 'N/A') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <form method="POST" action="<?= BASE_URL ?>/operadores/cambiarEstado" class="m-0">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($op['id'] ?? '')) ?>">

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
                                    <a href="<?= BASE_URL ?>/operadores/ver?id=<?= (int) $op['id'] ?>"
                                        class="inline-block bg-slate-700 hover:bg-slate-800 text-white text-xs px-3 py-1 rounded">
                                        Ver
                                    </a>

                                    <a href="<?= BASE_URL ?>/operadores/editar?id=<?= (int) $op['id'] ?>"
                                        class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-xs px-3 py-1 rounded">
                                        Editar
                                    </a>

                                    <a href="<?= BASE_URL ?>/operadores/asignar?id=<?= (int) $op['id'] ?>"
                                        class="inline-block bg-green-700 hover:bg-green-800 text-white text-xs px-3 py-1 rounded">
                                        Asignar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="15" class="border border-[#2b3d57] px-2 py-3 text-center text-gray-400">
                            No hay operadores registrados
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>