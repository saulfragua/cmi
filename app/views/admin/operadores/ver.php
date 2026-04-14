<div class="p-4 text-white bg-black min-h-screen">

    <!-- TÍTULO -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-[#c8982e]">📁 Folio de Vida del Operador</h1>

        <div class="flex gap-2">
            <a href="<?= BASE_URL ?>/operadores/editar?id=<?= $operador['id'] ?>"
               class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded text-sm">
                Editar
            </a>

            <a href="<?= BASE_URL ?>/operadores/asignar?id=<?= $operador['id'] ?>"
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
    <div class="grid md:grid-cols-[220px_1fr] gap-6 mb-6">
        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4 flex flex-col items-center">
            <?php if (!empty($operador['foto_operador'])): ?>
                <img src="<?= BASE_URL ?>/assets/img/operadores/<?= htmlspecialchars($operador['foto_operador']) ?>"
                     alt="Foto operador"
                     class="w-40 h-40 object-cover rounded border border-gray-700 mb-4">
            <?php else: ?>
                <div class="w-40 h-40 flex items-center justify-center rounded border border-gray-700 bg-[#0b1220] text-gray-500 mb-4">
                    Sin foto
                </div>
            <?php endif; ?>

            <div class="text-center">
                <p class="text-yellow-300 font-bold text-lg"><?= htmlspecialchars($operador['codigo'] ?? 'N/A') ?></p>
                <p class="text-white text-sm"><?= htmlspecialchars($operador['nombre_completo'] ?? 'N/A') ?></p>
            </div>
        </div>

        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
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
                    <p class="text-gray-400">Fecha de nacimiento</p>
                    <p><?= htmlspecialchars($operador['fecha_nacimiento'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Edad</p>
                    <p><?= htmlspecialchars($operador['edad'] ?? 'N/A') ?> años</p>
                </div>

                <div>
                    <p class="text-gray-400">País</p>
                    <p><?= htmlspecialchars($operador['pais'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Teléfono</p>
                    <p><?= htmlspecialchars($operador['telefono'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Rol</p>
                    <p><?= htmlspecialchars($operador['rol'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Estado</p>
                    <p><?= htmlspecialchars($operador['estado'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Fecha último ascenso</p>
                    <p><?= htmlspecialchars($operador['fecha_ultimo_ascenso'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Rango actual</p>
                    <p><?= htmlspecialchars($operador['rango'] ?? 'N/A') ?></p>
                </div>

                <div>
                    <p class="text-gray-400">Última modificación</p>
                    <p><?= htmlspecialchars($operador['fecha_modificacion'] ?? 'N/A') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ASIGNACIONES -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
            <h3 class="text-base font-semibold text-blue-400 mb-3">Especialidad principal</h3>
            <p class="text-sm"><?= htmlspecialchars($operador['especialidad_principal'] ?? 'N/A') ?></p>
        </div>

        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
            <h3 class="text-base font-semibold text-yellow-400 mb-3">Unidades asignadas</h3>
            <p class="text-sm"><?= htmlspecialchars($operador['unidades'] ?? 'N/A') ?></p>
        </div>

        <div class="bg-[#111827] border border-[#2b3d57] rounded p-4">
            <h3 class="text-base font-semibold text-green-400 mb-3">Cursos asignados</h3>
            <p class="text-sm"><?= htmlspecialchars($operador['cursos'] ?? 'N/A') ?></p>
        </div>
    </div>

</div>