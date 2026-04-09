<div class="p-6 text-white">

    <h1 class="text-2xl mb-4">📋 Panel de Incorporaciones</h1>

    <table class="w-full text-sm border border-gray-700">
        
        <thead class="bg-gray-800 text-gray-300">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Fecha Nac.</th>
                <th>País</th>
                <th>Teléfono</th>
                <th>Motivo</th>
                <th>Recepción</th>
                <th>Tiempo</th>
                <th>Estado</th>
                <th>Acción</th>
                <th>Obs</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($formularios as $f): ?>

        <?php
            $fecha_registro = new DateTime($f['fecha_registro']);
            $ahora = new DateTime();
            $intervalo = $fecha_registro->diff($ahora);
            $tiempo = $intervalo->d . "d " . $intervalo->h . "h";
        ?>

        <tr class="border-t border-gray-700 hover:bg-gray-900">

            <td><?= $f['id'] ?></td>
            <td><?= $f['nombre_completo'] ?></td>
            <td><?= $f['fecha_nacimiento'] ?></td>
            <td><?= $f['pais'] ?></td>
            <td><?= $f['telefono'] ?></td>

            <!-- 📌 MOTIVO -->
            <td>
                <?php if (!empty($f['motivo'])): ?>
                    <button onclick="verMotivo(`<?= htmlspecialchars($f['motivo']) ?>`)"
                            class="bg-blue-600 hover:bg-blue-700 text-xs px-2 py-1">
                        Ver
                    </button>
                <?php else: ?>
                    <span class="text-gray-500 text-xs">N/A</span>
                <?php endif; ?>
            </td>

            <!-- 📅 Fecha -->
            <td><?= date('Y-m-d H:i', strtotime($f['fecha_registro'])) ?></td>

            <!-- ⏱️ Tiempo -->
            <td class="text-yellow-400"><?= $tiempo ?></td>

            <!-- 🎯 Estado -->
            <td>
                <?php if ($f['estado'] == 'Pendiente'): ?>
                    <span class="text-yellow-400">🟡 Pendiente</span>
                <?php elseif ($f['estado'] == 'En revision'): ?>
                    <span class="text-blue-400">🔵 En revisión</span>
                <?php elseif ($f['estado'] == 'Aprobado'): ?>
                    <span class="text-green-400">🟢 Aprobado</span>
                <?php elseif ($f['estado'] == 'Rechazado'): ?>
                    <span class="text-red-400">🔴 Rechazado</span>
                <?php endif; ?>
            </td>

            <!-- ⚙️ Acción -->
            <td>
                <?php if ($f['estado'] == 'Aprobado' || $f['estado'] == 'Rechazado'): ?>
                    <span class="text-gray-500">Finalizado</span>
                <?php else: ?>
                    <select onchange="abrirModal(<?= $f['id'] ?>, this.value)"
                            class="bg-black border border-gray-600 text-white text-xs p-1">
                        <option value="">Cambiar</option>
                        <option value="2">En revisión</option>
                        <option value="3">Aprobado</option>
                        <option value="4">Rechazado</option>
                    </select>
                <?php endif; ?>
            </td>

            <!-- 📌 OBSERVACIONES -->
            <td>
                <?php if (!empty($f['observaciones'])): ?>
                    <button onclick="verObservaciones(`<?= htmlspecialchars($f['observaciones']) ?>`)"
                            class="bg-purple-600 hover:bg-purple-700 text-xs px-2 py-1">
                        Ver
                    </button>
                <?php else: ?>
                    <span class="text-gray-500 text-xs">N/A</span>
                <?php endif; ?>
            </td>

        </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

<!-- 🧾 MODAL CAMBIO ESTADO -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center">

    <div class="bg-gray-900 p-6 rounded w-96">

        <h2 class="text-lg mb-3">🧾 Observaciones</h2>

        <form method="POST" action="<?= BASE_URL ?>/index.php?url=admin/incorporaciones/actualizarEstado">

            <input type="hidden" name="id" id="modal_id">
            <input type="hidden" name="estado_id" id="modal_estado">
            <input type="hidden" name="evaluado_por" value="<?= $_SESSION['user']['id'] ?>">

            <textarea name="observaciones"
                      class="w-full bg-black border border-gray-600 text-white p-2 mb-3"
                      placeholder="Observaciones..." required></textarea>

            <div class="flex justify-between">
                <button type="button" onclick="cerrarModal()" class="bg-gray-600 px-3 py-1">Cancelar</button>
                <button type="submit" class="bg-green-600 px-3 py-1">Guardar</button>
            </div>

        </form>

    </div>

</div>

<!-- 📌 MODAL VER (Motivo / Observaciones) -->
<div id="modal_ver" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center">

    <div class="bg-gray-900 p-6 rounded w-96">

        <h2 id="titulo_modal" class="text-lg mb-3"></h2>

        <div id="contenido_modal" class="bg-black p-3 border border-gray-700 text-sm text-white mb-3"></div>

        <button onclick="cerrarModalVer()" class="bg-red-600 px-3 py-1 w-full">
            Cerrar
        </button>

    </div>

</div>

<!-- ⚙️ SCRIPT -->
<script>
function abrirModal(id, estado) {
    if (estado === "") return;

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal_id').value = id;
    document.getElementById('modal_estado').value = estado;
}

function cerrarModal() {
    document.getElementById('modal').classList.add('hidden');
}

function verMotivo(texto) {
    document.getElementById('modal_ver').classList.remove('hidden');
    document.getElementById('titulo_modal').innerText = "📌 Motivo";
    document.getElementById('contenido_modal').innerText = texto;
}

function verObservaciones(texto) {
    document.getElementById('modal_ver').classList.remove('hidden');
    document.getElementById('titulo_modal').innerText = "🧾 Observaciones";
    document.getElementById('contenido_modal').innerText = texto;
}

function cerrarModalVer() {
    document.getElementById('modal_ver').classList.add('hidden');
}
</script>