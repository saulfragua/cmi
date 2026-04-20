<?php
$operador = $operador ?? [];

$foto = !empty($operador['foto_operador'])
    ? BASE_URL . '/assets/img/operadores/' . $operador['foto_operador']
    : null;

$paisNombre = $operador['pais_nombre'] ?? ($operador['pais'] ?? 'N/A');
$paisBandera = $operador['pais_bandera'] ?? '';
$paisIndicativo = $operador['pais_indicativo'] ?? '';
$telefono = $operador['telefono'] ?? '';
$edad = $operador['edad'] ?? null;

function limpiarNumeroVista($numero)
{
    return preg_replace('/[^0-9]/', '', (string)$numero);
}

function construirWhatsappVista($indicativo, $telefono)
{
    $codigo = limpiarNumeroVista($indicativo);
    $numero = limpiarNumeroVista($telefono);

    if (empty($numero)) {
        return '';
    }

    if (!empty($codigo) && strpos($numero, $codigo) === 0) {
        return $numero;
    }

    return !empty($codigo) ? $codigo . $numero : $numero;
}

$whatsappNumero = construirWhatsappVista($paisIndicativo, $telefono);
$mensajeWhatsapp = rawurlencode("Hola, te contactamos desde CMI.");
$linkWhatsapp = !empty($whatsappNumero)
    ? "https://wa.me/{$whatsappNumero}?text={$mensajeWhatsapp}"
    : '';

$estado = $operador['estado'] ?? 'N/A';
$estadoClase = 'text-gray-300';
$estadoBadge = 'bg-gray-700/40 border-gray-600';

if ($estado === 'Activo') {
    $estadoClase = 'text-green-400';
    $estadoBadge = 'bg-green-500/10 border-green-500/30';
} elseif ($estado === 'Reserva') {
    $estadoClase = 'text-yellow-400';
    $estadoBadge = 'bg-yellow-500/10 border-yellow-500/30';
} elseif ($estado === 'Suspendido') {
    $estadoClase = 'text-red-400';
    $estadoBadge = 'bg-red-500/10 border-red-500/30';
} elseif ($estado === 'Retirado') {
    $estadoClase = 'text-gray-400';
    $estadoBadge = 'bg-gray-500/10 border-gray-500/30';
}
?>

<div class="p-4 text-white bg-black min-h-screen">

    <!-- TÍTULO -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-[#c8982e]">📁 Folio de Vida del Operador</h1>

        <div class="flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/operadores/editar?id=<?= (int)($operador['id'] ?? 0) ?>"
               class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded text-sm">
                Editar
            </a>

            <a href="<?= BASE_URL ?>/operadores/asignar?id=<?= (int)($operador['id'] ?? 0) ?>"
               class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded text-sm">
                Asignar
            </a>

            <a href="<?= BASE_URL ?>/operadores"
               class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm">
                Volver
            </a>
        </div>
    </div>

    <!-- CABECERA -->
    <div class="grid md:grid-cols-[260px_1fr] gap-6 mb-6">
        <div class="bg-[#111827] border border-[#2b3d57] rounded p-5 flex flex-col items-center">
            <?php if ($foto): ?>
                <img src="<?= htmlspecialchars($foto) ?>"
                     alt="Foto operador"
                     class="w-44 h-44 object-cover rounded border border-gray-700 mb-4">
            <?php else: ?>
                <div class="w-44 h-44 flex items-center justify-center rounded border border-gray-700 bg-[#0b1220] text-gray-500 mb-4">
                    Sin foto
                </div>
            <?php endif; ?>

            <div class="text-center w-full">
                <p class="text-yellow-300 font-bold text-xl"><?= htmlspecialchars($operador['codigo'] ?? 'N/A') ?></p>
                <p class="text-white text-base mt-1"><?= htmlspecialchars($operador['nombre_completo'] ?? 'N/A') ?></p>

                <?php if (!empty($operador['alias'])): ?>
                    <p class="text-sm text-blue-300 mt-1">Alias: <?= htmlspecialchars($operador['alias']) ?></p>
                <?php endif; ?>

                <div class="mt-4 inline-flex items-center justify-center px-3 py-1 rounded border <?= $estadoBadge ?> <?= $estadoClase ?> text-sm font-semibold">
                    <?= htmlspecialchars($estado) ?>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] border border-[#2b3d57] rounded p-5">
            <h2 class="text-lg font-semibold text-[#c8982e] mb-4">Datos Generales</h2>

            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Nombre completo</p>
                    <p><?= htmlspecialchars($operador['nombre_completo'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Código</p>
                    <p><?= htmlspecialchars($operador['codigo'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Alias</p>
                    <p><?= htmlspecialchars($operador['alias'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Rol</p>
                    <p><?= htmlspecialchars($operador['rol'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Fecha de nacimiento</p>
                    <p><?= htmlspecialchars($operador['fecha_nacimiento'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Edad</p>
                    <p><?= $edad !== null && $edad !== '' ? htmlspecialchars((string)$edad) . ' años' : 'N/A' ?></p>
                </div>

                <div>
                    <p class="text-gray-400">País</p>
                    <div class="flex items-center gap-2">
                        <?php if (!empty($paisBandera)): ?>
                            <img src="<?= BASE_URL . '/assets/img/nacionalidad/' . htmlspecialchars($paisBandera) ?>"
                                 alt="<?= htmlspecialchars($paisNombre) ?>"
                                 class="w-5 h-4 object-cover rounded-sm border border-gray-700 shrink-0">
                        <?php endif; ?>
                        <span><?= htmlspecialchars($paisNombre) ?></span>
                    </div>
                </div>

                <div>
                    <p class="text-gray-400">Indicativo</p>
                    <p><?= htmlspecialchars($paisIndicativo ?: 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Teléfono</p>
                    <div class="flex flex-wrap items-center gap-2">
                        <span><?= htmlspecialchars(trim(($paisIndicativo ? $paisIndicativo . ' ' : '') . $telefono)) ?: 'N/A' ?></span>

                        <?php if (!empty($linkWhatsapp)): ?>
                            <a href="<?= htmlspecialchars($linkWhatsapp) ?>"
                               target="_blank"
                               class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white text-[11px] px-2 py-1 rounded">
                                WhatsApp
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <p class="text-gray-400">Discord</p>
                    <p><?= htmlspecialchars($operador['discord'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Steam</p>
                    <p><?= htmlspecialchars($operador['steam'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Rango actual</p>
                    <p><?= htmlspecialchars($operador['rango'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Fecha último ascenso</p>
                    <p><?= htmlspecialchars($operador['fecha_ultimo_ascenso'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Última modificación</p>
                    <p><?= htmlspecialchars($operador['fecha_modificacion'] ?? 'N/A') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- RESUMEN OPERATIVO -->
    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
            <h3 class="text-base font-semibold text-blue-400 mb-3">Especialidad principal</h3>
            <p class="text-sm"><?= htmlspecialchars($operador['especialidad_principal'] ?? 'N/A') ?></p>
        </div>

        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
            <h3 class="text-base font-semibold text-yellow-400 mb-3">Unidades asignadas</h3>
            <p class="text-sm whitespace-pre-line"><?= htmlspecialchars($operador['unidades'] ?? 'N/A') ?></p>
        </div>

        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
            <h3 class="text-base font-semibold text-green-400 mb-3">Cursos asignados</h3>
            <p class="text-sm whitespace-pre-line"><?= htmlspecialchars($operador['cursos'] ?? 'N/A') ?></p>
        </div>
    </div>

    <!-- HOJA DE VIDA / FOLIO -->
    <div class="bg-[#111827] border border-[#2b3d57] rounded p-5">
        <h2 class="text-lg font-semibold text-[#c8982e] mb-4">Resumen Hoja de Vida</h2>

        <div class="grid md:grid-cols-2 gap-6 text-sm">
            <div class="bg-[#0b1220] border border-[#2b3d57] rounded p-4">
                <h3 class="text-sm font-semibold text-[#c8982e] mb-3">Identificación</h3>

                <div class="space-y-2">
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Código</span>
                        <span class="text-right"><?= htmlspecialchars($operador['codigo'] ?? 'N/A') ?></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Nombre</span>
                        <span class="text-right"><?= htmlspecialchars($operador['nombre_completo'] ?? 'N/A') ?></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Alias</span>
                        <span class="text-right"><?= htmlspecialchars($operador['alias'] ?? 'N/A') ?></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Estado</span>
                        <span class="text-right <?= $estadoClase ?>"><?= htmlspecialchars($estado) ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-[#0b1220] border border-[#2b3d57] rounded p-4">
                <h3 class="text-sm font-semibold text-[#c8982e] mb-3">Perfil táctico</h3>

                <div class="space-y-2">
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Rango</span>
                        <span class="text-right"><?= htmlspecialchars($operador['rango'] ?? 'N/A') ?></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Especialidad principal</span>
                        <span class="text-right"><?= htmlspecialchars($operador['especialidad_principal'] ?? 'N/A') ?></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Cursos</span>
                        <span class="text-right"><?= htmlspecialchars($operador['cursos'] ?? 'N/A') ?></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Unidades</span>
                        <span class="text-right"><?= htmlspecialchars($operador['unidades'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>