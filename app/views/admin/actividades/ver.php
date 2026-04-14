<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <div class="mb-6 border-l-4 border-blue-500 pl-4">
        <h1 class="text-2xl font-bold tracking-widest text-blue-400">[CMI] DETALLE DE ACTIVIDAD</h1>
        <p class="text-sm text-gray-400">Control de participación por operador</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-[#0b1220] border border-[#1f2937] rounded-xl p-6">
            <h2 class="text-xl font-bold text-[#c8982e] mb-4"><?= htmlspecialchars($actividad['nombre']) ?></h2>

            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-400">Tipo:</span>
                    <span class="text-white font-semibold"><?= htmlspecialchars($actividad['tipo']) ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Estado:</span>
                    <span class="text-white font-semibold"><?= htmlspecialchars($actividad['estado']) ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Fecha:</span>
                    <span class="text-white font-semibold"><?= htmlspecialchars($actividad['fecha']) ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Hora inicio:</span>
                    <span class="text-white font-semibold"><?= htmlspecialchars(substr($actividad['hora_inicio'], 0, 5)) ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Operador responsable:</span>
                    <span class="text-white font-semibold"><?= htmlspecialchars($actividad['operador_nombre']) ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Registrado por:</span>
                    <span class="text-white font-semibold"><?= htmlspecialchars($actividad['usuario_registra'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="mt-4">
                <span class="text-gray-400 text-sm">Descripción:</span>
                <div class="mt-2 text-gray-200 leading-relaxed">
                    <?= nl2br(htmlspecialchars($actividad['descripcion'])) ?>
                </div>
            </div>
        </div>

        <div class="bg-[#0b1220] border border-[#1f2937] rounded-xl p-6">
            <h3 class="text-lg font-bold text-[#c8982e] mb-4">Imagen</h3>

            <?php if (!empty($actividad['imagen'])): ?>
                <img src="<?= BASE_URL . '/' . $actividad['imagen'] ?>"
                     alt="Imagen actividad"
                     class="w-full h-56 object-cover rounded-lg border border-[#374151]">
            <?php else: ?>
                <div class="w-full h-56 flex items-center justify-center rounded-lg border border-dashed border-[#374151] text-gray-500">
                    Sin imagen
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-[#0b1220] border border-[#1f2937] rounded-xl shadow-lg overflow-x-auto">
        <div class="px-6 py-4 border-b border-[#1f2937]">
            <h3 class="text-lg font-bold text-[#c8982e]">Listado de operadores</h3>
            <p class="text-sm text-gray-400">Solo se cargan operadores en estado Activo y Reserva</p>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-[#111827] text-[#c8982e] uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Código</th>
                    <th class="px-4 py-3">Operador</th>
                    <th class="px-4 py-3">Teléfono</th>
                    <th class="px-4 py-3">Estado operador</th>
                    <th class="px-4 py-3">Estado actividad</th>
                    <th class="px-4 py-3">Fecha respuesta</th>
                    <th class="px-4 py-3">Observación</th>
                    <th class="px-4 py-3 text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($participantes)): ?>
                    <?php foreach ($participantes as $p): ?>
                        <tr class="border-t border-[#1f2937] hover:bg-[#0f172a] transition">
                            <td class="px-4 py-3"><?= htmlspecialchars($p['codigo']) ?></td>
                            <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($p['nombre_completo']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($p['telefono']) ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    <?= $p['estado_operador'] === 'Activo' ? 'bg-green-900 text-green-300' : 'bg-blue-900 text-blue-300' ?>">
                                    <?= htmlspecialchars($p['estado_operador']) ?>
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    <?php
                                        switch ($p['estado_participacion']) {
                                            case 'Asiste': echo 'bg-green-900 text-green-300'; break;
                                            case 'No asiste': echo 'bg-red-900 text-red-300'; break;
                                            default: echo 'bg-yellow-900 text-yellow-300'; break;
                                        }
                                    ?>">
                                    <?= htmlspecialchars($p['estado_participacion']) ?>
                                </span>
                            </td>

                            <td class="px-4 py-3 text-xs text-gray-300">
                                <?= !empty($p['fecha_respuesta']) ? htmlspecialchars($p['fecha_respuesta']) : 'Sin respuesta' ?>
                            </td>

                            <td class="px-4 py-3 text-xs text-gray-300">
                                <?= !empty($p['observacion']) ? htmlspecialchars($p['observacion']) : '---' ?>
                            </td>

                            <td class="px-4 py-3">
<form action="<?= BASE_URL ?>/actividades/cambiar-estado-participacion"
      method="POST"
      class="flex flex-col gap-2 min-w-[180px]">
    <input type="hidden" name="actividad_id" value="<?= $actividad['id'] ?>">
    <input type="hidden" name="operador_id" value="<?= $p['operador_id'] ?>">

    <select name="estado"
            class="bg-[#111827] border border-[#374151] rounded px-2 py-2 text-white text-xs">
        <option value="Pendiente" <?= $p['estado_participacion'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
        <option value="Asiste" <?= $p['estado_participacion'] === 'Asiste' ? 'selected' : '' ?>>Asiste</option>
        <option value="No asiste" <?= $p['estado_participacion'] === 'No asiste' ? 'selected' : '' ?>>No asiste</option>
    </select>

    <input type="text"
           name="observacion"
           value="<?= htmlspecialchars($p['observacion'] ?? '') ?>"
           placeholder="Observación"
           class="bg-[#111827] border border-[#374151] rounded px-2 py-2 text-white text-xs">

    <button type="submit"
            class="px-3 py-2 rounded bg-[#c8982e] text-black text-xs font-bold hover:opacity-90">
        Guardar
    </button>
</form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                            No hay operadores relacionados para esta actividad.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="<?= BASE_URL ?>/actividades"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-700 text-white font-bold hover:bg-gray-600">
            ← Volver
        </a>
    </div>
</div>