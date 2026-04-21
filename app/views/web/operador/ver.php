<?php
include ROOT . '/app/views/layouts/header.php';
$estado = $actividad['estado'] ?? 'Borrador';

switch ($estado) {
    case 'Publicada':
        $colorEstado = 'bg-green-700 text-white';
        break;
    case 'Finalizada':
        $colorEstado = 'bg-blue-700 text-white';
        break;
    case 'Cancelada':
        $colorEstado = 'bg-red-700 text-white';
        break;
    default:
        $colorEstado = 'bg-yellow-600 text-black';
        break;
}
?>

<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div class="border-l-4 border-[#c8982e] pl-4">
            <h1 class="text-2xl font-bold tracking-widest text-[#c8982e]">[CMI] DETALLE DE ACTIVIDAD</h1>
            <p class="text-sm text-gray-400">Consulta informativa para operador</p>
        </div>

        <a href="<?= BASE_URL ?>/operador/calendario"
           class="px-4 py-2 rounded-lg bg-[#111827] border border-[#374151] hover:border-[#c8982e] text-white text-sm">
            ← Volver
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-[#0b1220] border border-[#1f2937] rounded-xl p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h2 class="text-2xl font-bold text-[#c8982e]">
                    <?= htmlspecialchars($actividad['nombre'] ?? 'Sin nombre') ?>
                </h2>

                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold <?= $colorEstado ?>">
                    <?= htmlspecialchars($estado) ?>
                </span>
            </div>

            <?php if (!empty($actividad['imagen'])): ?>
                <div class="mb-6">
                    <img src="<?= BASE_URL ?>/uploads/actividades/<?= htmlspecialchars($actividad['imagen']) ?>"
                         alt="<?= htmlspecialchars($actividad['nombre']) ?>"
                         class="w-full max-h-[420px] object-cover rounded-xl border border-[#1f2937]">
                </div>
            <?php endif; ?>

            <div class="grid md:grid-cols-2 gap-4 mb-6 text-sm">
                <div class="bg-[#111827] border border-[#374151] rounded-xl p-4">
                    <span class="block text-gray-400 mb-1">Tipo</span>
                    <span class="font-semibold text-white"><?= htmlspecialchars($actividad['tipo'] ?? 'N/A') ?></span>
                </div>

                <div class="bg-[#111827] border border-[#374151] rounded-xl p-4">
                    <span class="block text-gray-400 mb-1">Fecha</span>
                    <span class="font-semibold text-white"><?= htmlspecialchars($actividad['fecha'] ?? 'N/A') ?></span>
                </div>

                <div class="bg-[#111827] border border-[#374151] rounded-xl p-4">
                    <span class="block text-gray-400 mb-1">Hora de inicio</span>
                    <span class="font-semibold text-white"><?= htmlspecialchars(substr($actividad['hora_inicio'] ?? '', 0, 5)) ?></span>
                </div>

                <div class="bg-[#111827] border border-[#374151] rounded-xl p-4">
                    <span class="block text-gray-400 mb-1">Encargado</span>
                    <span class="font-semibold text-white"><?= htmlspecialchars($actividad['operador_nombre'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="bg-[#111827] border border-[#374151] rounded-xl p-4">
                <h3 class="text-lg font-bold text-[#c8982e] mb-3">Descripción</h3>
                <p class="text-gray-300 whitespace-pre-line">
                    <?= !empty($actividad['descripcion']) ? htmlspecialchars($actividad['descripcion']) : 'Sin descripción registrada.' ?>
                </p>
            </div>
        </div>

        <div class="bg-[#0b1220] border border-[#1f2937] rounded-xl p-6">
            <h3 class="text-xl font-bold text-[#c8982e] mb-4">Resumen</h3>

            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between bg-[#111827] border border-[#374151] rounded-lg px-4 py-3">
                    <span class="text-gray-300">Convocados</span>
                    <span class="font-bold text-white"><?= (int)($actividad['total_operadores'] ?? 0) ?></span>
                </div>

                <div class="flex items-center justify-between bg-[#111827] border border-[#374151] rounded-lg px-4 py-3">
                    <span class="text-gray-300">Asisten</span>
                    <span class="font-bold text-green-400"><?= (int)($actividad['total_asisten'] ?? 0) ?></span>
                </div>

                <div class="flex items-center justify-between bg-[#111827] border border-[#374151] rounded-lg px-4 py-3">
                    <span class="text-gray-300">No asisten</span>
                    <span class="font-bold text-red-400"><?= (int)($actividad['total_no_asisten'] ?? 0) ?></span>
                </div>

                <div class="flex items-center justify-between bg-[#111827] border border-[#374151] rounded-lg px-4 py-3">
                    <span class="text-gray-300">Pendientes</span>
                    <span class="font-bold text-yellow-400"><?= (int)($actividad['total_pendientes'] ?? 0) ?></span>
                </div>
            </div>

            <div class="mt-6">
                <h4 class="text-base font-bold text-[#c8982e] mb-3">Participantes</h4>

                <?php if (!empty($participantes)): ?>
                    <div class="space-y-2 max-h-[450px] overflow-y-auto pr-1">
                        <?php foreach ($participantes as $p): ?>
                            <?php
                            $estadoP = $p['estado_participacion'] ?? 'Pendiente';

                            if ($estadoP === 'Asiste') {
                                $badge = 'bg-green-700 text-white';
                            } elseif ($estadoP === 'No asiste') {
                                $badge = 'bg-red-700 text-white';
                            } else {
                                $badge = 'bg-yellow-600 text-black';
                            }
                            ?>
                            <div class="bg-[#111827] border border-[#374151] rounded-lg p-3">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="font-semibold text-white">
                                            <?= htmlspecialchars($p['nombre_completo'] ?? 'Operador') ?>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            <?= htmlspecialchars($p['codigo_operador'] ?? $p['codigo'] ?? 'Sin código') ?>
                                        </div>
                                    </div>

                                    <span class="text-xs px-2 py-1 rounded <?= $badge ?>">
                                        <?= htmlspecialchars($estadoP) ?>
                                    </span>
                                </div>

                                <?php if (!empty($p['observacion'])): ?>
                                    <div class="mt-2 text-xs text-gray-300">
                                        <span class="text-gray-400">Obs:</span>
                                        <?= htmlspecialchars($p['observacion']) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($p['fecha_respuesta'])): ?>
                                    <div class="mt-1 text-[11px] text-gray-500">
                                        Respuesta: <?= htmlspecialchars($p['fecha_respuesta']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-[#111827] border border-[#374151] rounded-lg p-4 text-sm text-gray-400">
                        No hay participantes registrados para esta actividad.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>