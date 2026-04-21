<?php
$esFinalizada = $actividad['estado'] === 'Finalizada';
?>

<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <div class="mb-6 border-l-4 border-blue-500 pl-4">
        <h1 class="text-2xl font-bold tracking-widest text-blue-400">[CMI] DETALLE Y EDICIÓN DE ACTIVIDAD</h1>
        <p class="text-sm text-gray-400">
            <?= $esFinalizada ? 'Consulta de histórico de actividad finalizada' : 'Consulta y actualización de actividad operativa' ?>
        </p>
    </div>

    <?php if ($esFinalizada): ?>
        <div class="mb-6 border border-blue-800 bg-blue-950/40 text-blue-300 rounded-xl px-4 py-4">
            <div class="font-bold text-sm tracking-wide">ACTIVIDAD FINALIZADA</div>
            <div class="text-sm text-blue-200 mt-1">
                Esta actividad ya fue cerrada. Los datos quedaron guardados en histórico y no pueden ser editados.
            </div>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/actividades/actualizar" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $actividad['id'] ?>">

        <div class="grid lg:grid-cols-3 gap-6 mb-6">

            <div class="lg:col-span-2 bg-[#0b1220] border border-[#1f2937] rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-[#c8982e]">Datos de la actividad</h2>

                    <?php if (!$esFinalizada): ?>
                        <a href="<?= BASE_URL ?>/actividades/editar?id=<?= $actividad['id'] ?>"
                           class="px-4 py-2 rounded-lg bg-yellow-600 hover:bg-yellow-500 text-black text-sm font-bold">
                            Editar clásica
                        </a>
                    <?php else: ?>
                        <span class="px-4 py-2 rounded-lg bg-gray-800 text-gray-400 text-sm font-bold cursor-not-allowed">
                            Edición bloqueada
                        </span>
                    <?php endif; ?>
                </div>

                <div class="grid md:grid-cols-2 gap-4 text-sm">

                    <div>
                        <label class="block mb-2 text-gray-400">Nombre</label>
                        <input type="text"
                               name="nombre"
                               value="<?= htmlspecialchars($actividad['nombre']) ?>"
                               required
                               <?= $esFinalizada ? 'disabled' : '' ?>
                               class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-400">Tipo</label>
                        <select name="tipo"
                                required
                                <?= $esFinalizada ? 'disabled' : '' ?>
                                class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                            <option value="curso" <?= $actividad['tipo'] === 'curso' ? 'selected' : '' ?>>Curso</option>
                            <option value="entrenamiento" <?= $actividad['tipo'] === 'entrenamiento' ? 'selected' : '' ?>>Entrenamiento</option>
                            <option value="mision" <?= $actividad['tipo'] === 'mision' ? 'selected' : '' ?>>Misión</option>
                            <option value="operacion" <?= $actividad['tipo'] === 'operacion' ? 'selected' : '' ?>>Operación</option>
                            <option value="ejercicio" <?= $actividad['tipo'] === 'ejercicio' ? 'selected' : '' ?>>Ejercicio</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-400">Estado</label>
                        <select name="estado"
                                required
                                <?= $esFinalizada ? 'disabled' : '' ?>
                                class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                            <option value="Borrador" <?= $actividad['estado'] === 'Borrador' ? 'selected' : '' ?>>Borrador</option>
                            <option value="Publicada" <?= $actividad['estado'] === 'Publicada' ? 'selected' : '' ?>>Publicada</option>
                            <option value="Finalizada" <?= $actividad['estado'] === 'Finalizada' ? 'selected' : '' ?>>Finalizada</option>
                            <option value="Cancelada" <?= $actividad['estado'] === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-400">Fecha</label>
                        <input type="date"
                               name="fecha"
                               value="<?= htmlspecialchars($actividad['fecha']) ?>"
                               required
                               <?= $esFinalizada ? 'disabled' : '' ?>
                               class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-400">Hora inicio</label>
                        <input type="time"
                               name="hora_inicio"
                               value="<?= htmlspecialchars(substr($actividad['hora_inicio'], 0, 5)) ?>"
                               required
                               <?= $esFinalizada ? 'disabled' : '' ?>
                               class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-400">Operador responsable</label>
                        <select name="operador_id"
                                required
                                <?= $esFinalizada ? 'disabled' : '' ?>
                                class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                            <?php foreach ($operadores as $o): ?>
                                <option value="<?= $o['id'] ?>" <?= (int)$actividad['operador_id'] === (int)$o['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($o['nombre_completo']) ?> - <?= htmlspecialchars($o['estado']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-gray-400">Descripción</label>
                        <textarea name="descripcion"
                                  rows="5"
                                  <?= $esFinalizada ? 'disabled' : '' ?>
                                  class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>"><?= htmlspecialchars($actividad['descripcion']) ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-gray-400">Cambiar imagen</label>
                        <input type="file"
                               name="imagen"
                               accept="image/*"
                               <?= $esFinalizada ? 'disabled' : '' ?>
                               class="w-full bg-[#111827] border border-[#374151] rounded-lg px-4 py-3 text-white <?= $esFinalizada ? 'opacity-60 cursor-not-allowed' : '' ?>">
                        <p class="text-xs text-gray-500 mt-2">
                            <?= $esFinalizada ? 'La actividad está finalizada, no se puede cambiar la imagen.' : 'Si no seleccionas una imagen nueva, se conserva la actual.' ?>
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <?php if (!$esFinalizada): ?>
                        <button type="submit"
                                class="px-6 py-3 rounded-lg bg-[#c8982e] text-black font-bold hover:opacity-90">
                            Guardar cambios
                        </button>
                    <?php else: ?>
                        <div class="px-6 py-3 rounded-lg bg-gray-800 text-gray-400 font-bold cursor-not-allowed">
                            Actividad finalizada
                        </div>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>/actividades"
                       class="px-6 py-3 rounded-lg bg-gray-700 text-white font-bold hover:bg-gray-600">
                        Volver
                    </a>
                </div>
            </div>

            <div class="bg-[#0b1220] border border-[#1f2937] rounded-xl p-6">
                <h3 class="text-lg font-bold text-[#c8982e] mb-4">Imagen actual</h3>

                <?php if (!empty($actividad['imagen'])): ?>
                    <img src="<?= BASE_URL . '/' . $actividad['imagen'] ?>"
                         alt="Imagen actividad"
                         class="w-full h-56 object-cover rounded-lg border border-[#374151] mb-4">
                <?php else: ?>
                    <div class="w-full h-56 flex items-center justify-center rounded-lg border border-dashed border-[#374151] text-gray-500 mb-4">
                        Sin imagen
                    </div>
                <?php endif; ?>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-400">Registrado por:</span>
                        <span class="text-white font-semibold"><?= htmlspecialchars($actividad['usuario_registra'] ?? 'N/A') ?></span>
                    </div>

                    <div>
                        <span class="text-gray-400">Actividad ID:</span>
                        <span class="text-white font-semibold">#<?= htmlspecialchars($actividad['id']) ?></span>
                    </div>

                    <?php if ($esFinalizada): ?>
                        <div>
                            <span class="text-gray-400">Fecha cierre:</span>
                            <span class="text-white font-semibold">
                                <?= !empty($actividad['fecha_cierre']) ? htmlspecialchars($actividad['fecha_cierre']) : 'N/A' ?>
                            </span>
                        </div>

                        <div>
                            <span class="text-gray-400">Convocados:</span>
                            <span class="text-white font-semibold"><?= (int)($actividad['total_convocados'] ?? 0) ?></span>
                        </div>

                        <div>
                            <span class="text-gray-400">Asistieron:</span>
                            <span class="text-green-400 font-semibold"><?= (int)($actividad['total_asistieron'] ?? 0) ?></span>
                        </div>

                        <div>
                            <span class="text-gray-400">No asistieron:</span>
                            <span class="text-red-400 font-semibold"><?= (int)($actividad['total_no_asistieron'] ?? 0) ?></span>
                        </div>

                        <div>
                            <span class="text-gray-400">Pendientes al cierre:</span>
                            <span class="text-yellow-400 font-semibold"><?= (int)($actividad['total_pendientes_cierre'] ?? 0) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>

    <div class="bg-[#0b1220] border border-[#1f2937] rounded-xl shadow-lg overflow-x-auto">
        <div class="px-6 py-4 border-b border-[#1f2937]">
            <h3 class="text-lg font-bold text-[#c8982e]">
                <?= $esFinalizada ? 'Histórico de operadores participantes' : 'Listado de operadores' ?>
            </h3>
            <p class="text-sm text-gray-400">
                <?= $esFinalizada
                    ? 'Registro histórico congelado al momento del cierre de la actividad'
                    : 'Solo se cargan operadores en estado Activo y Reserva' ?>
            </p>
        </div>

<form action="<?= BASE_URL ?>/actividades/guardar-participaciones-masivas" method="POST">
    <input type="hidden" name="actividad_id" value="<?= $actividad['id'] ?>">

    <table class="w-full text-sm">
        <thead class="bg-[#111827] text-[#c8982e] uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Código</th>
                <th class="px-4 py-3">Operador</th>
                <th class="px-4 py-3">Teléfono</th>
                <th class="px-4 py-3">Estado operador</th>
                <th class="px-4 py-3">Estado actividad</th>
                <th class="px-4 py-3">Fecha respuesta</th>
                <th class="px-4 py-3 text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($participantes)): ?>
                <?php foreach ($participantes as $p): ?>
                    <?php
                    $codigoMostrar = $p['codigo'] ?? $p['codigo_operador'] ?? '---';
                    $nombreMostrar = $p['nombre_completo'] ?? '---';
                    $telefonoMostrar = $p['telefono'] ?? '---';
                    $estadoOperadorMostrar = $p['estado_operador'] ?? '---';
                    $estadoParticipacionMostrar = $p['estado_participacion'] ?? $p['estado'] ?? 'Pendiente';
                    $fechaRespuestaMostrar = $p['fecha_respuesta'] ?? null;
                    ?>
                    <tr class="border-t border-[#1f2937] hover:bg-[#0f172a] transition">
                        <td class="px-4 py-3"><?= htmlspecialchars($codigoMostrar) ?></td>
                        <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($nombreMostrar) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($telefonoMostrar) ?></td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                <?= $estadoOperadorMostrar === 'Activo' ? 'bg-green-900 text-green-300' : 'bg-blue-900 text-blue-300' ?>">
                                <?= htmlspecialchars($estadoOperadorMostrar) ?>
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                <?php
                                    switch ($estadoParticipacionMostrar) {
                                        case 'Asiste': echo 'bg-green-900 text-green-300'; break;
                                        case 'No asiste': echo 'bg-red-900 text-red-300'; break;
                                        default: echo 'bg-yellow-900 text-yellow-300'; break;
                                    }
                                ?>">
                                <?= htmlspecialchars($estadoParticipacionMostrar) ?>
                            </span>
                        </td>

                        <td class="px-4 py-3 text-xs text-gray-300">
                            <?= !empty($fechaRespuestaMostrar) ? htmlspecialchars($fechaRespuestaMostrar) : 'Sin respuesta' ?>
                        </td>

                        <td class="px-4 py-3">
                            <?php if (!$esFinalizada): ?>
                                <div class="flex flex-col gap-2 min-w-[180px]">
                                    <label class="flex items-center gap-2 text-xs text-green-400 font-semibold cursor-pointer">
                                        <input type="radio"
                                               name="participacion[<?= (int)$p['operador_id'] ?>]"
                                               value="Asiste"
                                               class="accent-green-500"
                                               <?= $estadoParticipacionMostrar === 'Asiste' ? 'checked' : '' ?>>
                                        Asiste
                                    </label>

                                    <label class="flex items-center gap-2 text-xs text-red-400 font-semibold cursor-pointer">
                                        <input type="radio"
                                               name="participacion[<?= (int)$p['operador_id'] ?>]"
                                               value="No asiste"
                                               class="accent-red-500"
                                               <?= $estadoParticipacionMostrar === 'No asiste' ? 'checked' : '' ?>>
                                        No asiste
                                    </label>
                                </div>
                            <?php else: ?>
                                <div class="min-w-[180px] text-center px-3 py-3 rounded bg-gray-800 text-gray-400 text-xs font-bold cursor-not-allowed">
                                    Actividad finalizada
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                        No hay participantes registrados para esta actividad.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!$esFinalizada && !empty($participantes)): ?>
        <div class="flex justify-end mt-6 px-4 pb-4">
            <button type="submit"
                    class="px-4 py-2 rounded bg-[#c8982e] text-black text-sm font-bold hover:opacity-90">
                Guardar
            </button>
        </div>
    <?php endif; ?>
</form>
    </div>
</div>