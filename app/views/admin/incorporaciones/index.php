<div class="p-3 md:p-4 text-white bg-black min-h-screen">

    <?php
    function limpiarNumero($numero) {
        return preg_replace('/[^0-9]/', '', (string)$numero);
    }

    function construirWhatsapp($indicativo, $telefono) {
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

    <!-- TÍTULO -->
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">📋</span>
        <h1 class="text-[20px] font-semibold text-white">Panel de Incorporaciones</h1>
    </div>

    <!-- TABLA -->
    <div class="border border-[#2b3d57] bg-black overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-[#22324a] text-white">
                <tr>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">#</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Nombre</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Fecha Nac.</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Edad.</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">País</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Teléfono</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Discord</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Motivo</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Recepción</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Tiempo</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Estado</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Acción</th>
                    <th class="border border-[#2b3d57] px-2 py-1 text-left">Obs</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($formularios)): ?>
                    <?php foreach ($formularios as $f): ?>

                        <?php
                            $fechaRegistroRaw = $f['fecha_registro'] ?? null;
                            $fecha_registro = !empty($fechaRegistroRaw) ? new DateTime($fechaRegistroRaw) : new DateTime();
                            $ahora = new DateTime();
                            $intervalo = $fecha_registro->diff($ahora);
                            $tiempo = $intervalo->d . "d " . $intervalo->h . "h";

                            $estadoId = (int)($f['estado_id'] ?? 1);
                            $estadoTexto = 'Pendiente';
                            $estadoColor = 'text-yellow-400';
                            $estadoPunto = '🟡';

                            if ($estadoId === 2) {
                                $estadoTexto = 'En revisión';
                                $estadoColor = 'text-blue-400';
                                $estadoPunto = '🔵';
                            } elseif ($estadoId === 3) {
                                $estadoTexto = 'Aprobado';
                                $estadoColor = 'text-green-400';
                                $estadoPunto = '🟢';
                            } elseif ($estadoId === 4) {
                                $estadoTexto = 'Rechazado';
                                $estadoColor = 'text-red-400';
                                $estadoPunto = '🔴';
                            }

                            $paisNombre = $f['pais_nombre'] ?? '';
                            $paisBandera = $f['pais_bandera'] ?? '';
                            $paisIndicativo = $f['pais_indicativo'] ?? '';
                            $telefonoMostrar = $f['telefono'] ?? '';
                            $discord = $f['discord'] ?? '';

                            $whatsappNumero = construirWhatsapp($paisIndicativo, $telefonoMostrar);
                            $mensajeWhatsapp = rawurlencode("Hola, te contactamos desde CMI respecto a tu solicitud.");
                            $linkWhatsapp = !empty($whatsappNumero)
                                ? "https://wa.me/{$whatsappNumero}?text={$mensajeWhatsapp}"
                                : '';

                                $edad = 'N/A';

if (!empty($f['fecha_nacimiento'])) {
    $fechaNacimiento = new DateTime($f['fecha_nacimiento']);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;
}
                        ?>

                        <tr class="hover:bg-[#0b1220]">
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars((string)($f['id'] ?? '')) ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($f['nombre_completo'] ?? '') ?>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= htmlspecialchars($f['fecha_nacimiento'] ?? '') ?>
                            </td>
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
    <?= htmlspecialchars($edad) ?>
</td>

<td class="border border-[#2b3d57] px-3 py-1">
    <div class="flex items-center gap-2 w-max">
        <?php if (!empty($paisBandera)): ?>
            <img src="<?= BASE_URL . '/assets/img/nacionalidad/' . htmlspecialchars($paisBandera) ?>"
                 class="w-5 h-4 object-cover rounded-sm border border-gray-700 shrink-0">
        <?php endif; ?>

        <span class="text-white whitespace-nowrap">
            <?= htmlspecialchars($paisNombre) ?>
        </span>
    </div>
</td>

                            <!-- TELÉFONO + WHATSAPP -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-white">
                                        <?= htmlspecialchars(trim(($paisIndicativo ? $paisIndicativo . ' ' : '') . $telefonoMostrar)) ?>
                                    </span>

                                    <?php if (!empty($linkWhatsapp)): ?>
                                        <a href="<?= htmlspecialchars($linkWhatsapp) ?>"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white text-[11px] px-2 py-1 rounded"
                                           title="Abrir WhatsApp">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 24 24"
                                                 fill="currentColor"
                                                 class="w-3 h-3">
                                                <path d="M20.52 3.48A11.94 11.94 0 0 0 12.04 0C5.41 0 .03 5.38.03 12c0 2.11.55 4.17 1.6 5.98L0 24l6.19-1.62A11.96 11.96 0 0 0 12.04 24c6.62 0 12-5.38 12-12 0-3.2-1.25-6.2-3.52-8.52ZM12.04 21.86c-1.78 0-3.53-.48-5.05-1.39l-.36-.21-3.67.96.98-3.58-.24-.37A9.83 9.83 0 0 1 2.21 12c0-5.42 4.41-9.83 9.83-9.83 2.62 0 5.08 1.02 6.93 2.88A9.75 9.75 0 0 1 21.87 12c0 5.42-4.41 9.86-9.83 9.86Zm5.39-7.36c-.29-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.66.15-.2.29-.76.96-.93 1.15-.17.2-.34.22-.64.08-.29-.15-1.24-.46-2.36-1.47-.87-.78-1.46-1.75-1.63-2.05-.17-.29-.02-.45.13-.59.13-.13.29-.34.44-.51.15-.17.19-.29.29-.49.1-.2.05-.37-.02-.52-.08-.15-.66-1.6-.91-2.19-.24-.57-.48-.49-.66-.5h-.56c-.2 0-.52.07-.79.37-.27.29-1.03 1-1.03 2.43 0 1.43 1.05 2.82 1.19 3.02.15.2 2.06 3.14 5 4.41.7.3 1.24.49 1.67.63.7.22 1.33.19 1.83.12.56-.08 1.75-.71 2-1.4.24-.69.24-1.28.17-1.4-.08-.12-.27-.2-.56-.34Z"/>
                                            </svg>
                                            WhatsApp
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-xs">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= !empty($discord) ? htmlspecialchars($discord) : '<span class="text-gray-500 text-xs">N/A</span>' ?>
                            </td>

                            <!-- MOTIVO -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?php if (!empty($f['motivo'])): ?>
                                    <button onclick="verMotivo(`<?= htmlspecialchars($f['motivo'] ?? '', ENT_QUOTES) ?>`)"
                                            class="bg-blue-700 hover:bg-blue-800 text-white text-xs px-3 py-1">
                                        Ver
                                    </button>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">N/A</span>
                                <?php endif; ?>
                            </td>

                            <!-- RECEPCIÓN -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?= !empty($fechaRegistroRaw) ? date('Y-m-d H:i', strtotime($fechaRegistroRaw)) : 'N/A' ?>
                            </td>

                            <!-- TIEMPO -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap text-yellow-400">
                                <?= htmlspecialchars($tiempo) ?>
                            </td>

                            <!-- ESTADO -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <span class="<?= $estadoColor ?>">
                                    <?= $estadoPunto ?> <?= $estadoTexto ?>
                                </span>
                            </td>

                            <!-- ACCIÓN -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?php if ($estadoTexto === 'Aprobado' || $estadoTexto === 'Rechazado'): ?>
                                    <span class="text-gray-500">Finalizado</span>
                                <?php else: ?>
                                    <select onchange="abrirModal(<?= (int)($f['id'] ?? 0) ?>, this.value)"
                                            class="bg-black border border-gray-500 text-white text-xs px-2 py-[2px] outline-none">
                                        <option value="">Cambiar</option>
                                        <option value="2">En revisión</option>
                                        <option value="3">Aprobado</option>
                                        <option value="4">Rechazado</option>
                                    </select>
                                <?php endif; ?>
                            </td>

                            <!-- OBSERVACIONES -->
                            <td class="border border-[#2b3d57] px-2 py-1 whitespace-nowrap">
                                <?php if (!empty($f['observaciones'])): ?>
                                    <button onclick="verObservaciones(`<?= htmlspecialchars($f['observaciones'] ?? '', ENT_QUOTES) ?>`)"
                                            class="bg-purple-700 hover:bg-purple-800 text-white text-xs px-3 py-1">
                                        Ver
                                    </button>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">N/A</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="border border-[#2b3d57] px-2 py-3 text-center text-gray-400">
                            No hay incorporaciones registradas
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL CAMBIO ESTADO -->
<div id="modal" class="hidden fixed inset-0 bg-black/70 items-center justify-center z-50">
    <div class="bg-[#111827] border border-[#2b3d57] p-5 w-full max-w-md shadow-xl">

        <h2 class="text-lg mb-3 text-white font-semibold">🧾 Observaciones</h2>

        <form method="POST" action="<?= BASE_URL ?>/index.php?url=admin/incorporaciones/actualizarEstado">
            <input type="hidden" name="id" id="modal_id">
            <input type="hidden" name="estado_id" id="modal_estado">
            <input type="hidden" name="evaluado_por" value="<?= $_SESSION['user']['id'] ?>">

            <textarea name="observaciones"
                      class="w-full bg-black border border-gray-600 text-white p-2 mb-3 outline-none"
                      placeholder="Observaciones..." required></textarea>

            <div class="flex justify-between gap-2">
                <button type="button"
                        onclick="cerrarModal()"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 text-sm w-full">
                    Cancelar
                </button>

                <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-3 py-1 text-sm w-full">
                    Guardar
                </button>
            </div>
        </form>

    </div>
</div>

<!-- MODAL VER -->
<div id="modal_ver" class="hidden fixed inset-0 bg-black/70 items-center justify-center z-50">
    <div class="bg-[#111827] border border-[#2b3d57] p-5 w-full max-w-md shadow-xl">

        <h2 id="titulo_modal" class="text-lg mb-3 text-white font-semibold"></h2>

        <div id="contenido_modal" class="bg-black p-3 border border-gray-700 text-sm text-white mb-3 min-h-[80px]"></div>

        <button onclick="cerrarModalVer()"
                class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 w-full text-sm">
            Cerrar
        </button>
    </div>
</div>

<style>
    table th,
    table td {
        font-size: 12px;
        line-height: 1.1;
        vertical-align: middle;
    }
</style>

<script>
function abrirModal(id, estado) {
    if (estado === "") return;

    const modal = document.getElementById('modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('modal_id').value = id;
    document.getElementById('modal_estado').value = estado;
}

function cerrarModal() {
    const modal = document.getElementById('modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function verMotivo(texto) {
    const modal = document.getElementById('modal_ver');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('titulo_modal').innerText = "📌 Motivo";
    document.getElementById('contenido_modal').innerText = texto || 'Sin información';
}

function verObservaciones(texto) {
    const modal = document.getElementById('modal_ver');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('titulo_modal').innerText = "🧾 Observaciones";
    document.getElementById('contenido_modal').innerText = texto || 'Sin observaciones';
}

function cerrarModalVer() {
    const modal = document.getElementById('modal_ver');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>