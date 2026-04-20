<?php
include ROOT . '/app/views/layouts/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$novedades = $novedades ?? [];
$operador = $operador ?? [];

$nombre = $operador['nombre_completo'] ?? 'Operador';
$codigo = $operador['codigo'] ?? 'N/A';
?>

<div class="min-h-screen bg-black text-white py-8 px-4 md:px-6">
    <div class="max-w-6xl mx-auto">
        <section class="border border-[#facc15]/30 rounded-2xl overflow-hidden bg-[#1f2937] shadow-2xl shadow-black/50">
            
            <div class="bg-black border-b border-[#facc15]/20 px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.28em] text-[#facc15]">
                        Comando Militar Internacional
                    </p>
                    <h1 class="text-2xl md:text-3xl font-bold">
                        Mis observador
                    </h1>
                    <p class="text-sm text-[#facc15]/80 mt-1">
                        Novedades registradas del operador <?= htmlspecialchars($nombre) ?> - <?= htmlspecialchars($codigo) ?>
                    </p>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <a href="<?= BASE_URL ?>/operador"
                       class="px-4 py-2 rounded-lg border border-[#facc15]/30 text-[#facc15] bg-black hover:bg-[#111827] transition">
                        Volver al perfil
                    </a>

                    <a href="<?= BASE_URL ?>/logout"
                       class="px-4 py-2 rounded-lg border border-red-500/30 text-red-300 bg-black hover:bg-red-950/30 transition">
                        Cerrar sesión
                    </a>
                </div>
            </div>

            <div class="p-6">
                <?php if (!empty($novedades)): ?>
                    <div class="overflow-x-auto border border-[#facc15]/10 rounded-xl">
                        <table class="w-full text-sm">
                            <thead class="bg-black">
                                <tr class="text-left">
                                    <th class="px-4 py-3 text-[#facc15] font-semibold">#</th>
                                    <th class="px-4 py-3 text-[#facc15] font-semibold">Tipo</th>
                                    <th class="px-4 py-3 text-[#facc15] font-semibold">Descripción</th>
                                    <th class="px-4 py-3 text-[#facc15] font-semibold">Estado</th>
                                    <th class="px-4 py-3 text-[#facc15] font-semibold">Fecha</th>
                                    <th class="px-4 py-3 text-[#facc15] font-semibold">Registrado por</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($novedades as $item): ?>
                                    <tr class="border-t border-[#facc15]/10 hover:bg-black/40 transition align-top">
                                        <td class="px-4 py-3"><?= (int)($item['id'] ?? 0) ?></td>
                                        <td class="px-4 py-3">
                                            <?php
                                                $tipo = $item['tipo'] ?? 'N/A';
                                                $claseTipo = 'border-gray-500/20 text-gray-300 bg-gray-900/20';

                                                if ($tipo === 'Felicitación') {
                                                    $claseTipo = 'border-green-500/20 text-green-300 bg-green-900/20';
                                                } elseif ($tipo === 'Llamado de atención') {
                                                    $claseTipo = 'border-red-500/20 text-red-300 bg-red-900/20';
                                                }
                                            ?>
                                            <span class="inline-flex px-3 py-1 rounded-full border text-xs font-semibold <?= $claseTipo ?>">
                                                <?= htmlspecialchars($tipo) ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3"><?= nl2br(htmlspecialchars($item['descripcion'] ?? 'N/A')) ?></td>
                                        <td class="px-4 py-3">
                                            <?php
                                                $estado = $item['estado'] ?? 'N/A';
                                                $claseEstado = 'border-gray-500/20 text-gray-300 bg-gray-900/20';

                                                if ($estado === 'Activa') {
                                                    $claseEstado = 'border-blue-500/20 text-blue-300 bg-blue-900/20';
                                                } elseif ($estado === 'Anulada') {
                                                    $claseEstado = 'border-red-500/20 text-red-300 bg-red-900/20';
                                                }
                                            ?>
                                            <span class="inline-flex px-3 py-1 rounded-full border text-xs font-semibold <?= $claseEstado ?>">
                                                <?= htmlspecialchars($estado) ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?= !empty($item['fecha_registro']) ? date('d/m/Y H:i', strtotime($item['fecha_registro'])) : 'N/A' ?>
                                        </td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($item['registrado_por_nombre'] ?? 'N/A') ?></td>
                                    </tr>

                                    <?php if (!empty($item['motivo_anulacion'])): ?>
                                        <tr class="border-t border-[#facc15]/5 bg-black/30">
                                            <td></td>
                                            <td colspan="5" class="px-4 py-3 text-sm text-red-300">
                                                <strong>Motivo de anulación:</strong>
                                                <?= nl2br(htmlspecialchars($item['motivo_anulacion'])) ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="border border-[#facc15]/10 rounded-xl px-4 py-5 bg-black">
                        <p class="text-sm text-gray-300">
                            Este operador no tiene novedades registradas.
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-black border-t border-[#facc15]/20 px-6 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-[#facc15]/80">
                <span>CMI • Sistema Operativo</span>
                <span>Historial de novedades del operador</span>
            </div>
        </section>
    </div>
</div>