<div>
    <h2 class="text-xl text-[#c8982e] mb-6">
        Bienvenido al sistema CMI
    </h2>

    <!-- TARJETAS PRINCIPALES -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#111] p-5 border border-[#222] rounded">
            <p class="text-gray-400 text-sm">Total de Operadores</p>
            <h3 class="text-[#c8982e] text-2xl font-bold">
                <?= htmlspecialchars($totalOperadores ?? 0) ?>
            </h3>
        </div>

        <div class="bg-[#111] p-5 border border-[#222] rounded">
            <p class="text-gray-400 text-sm">Total de Formularios</p>
            <h3 class="text-[#c8982e] text-2xl font-bold">
                <?= htmlspecialchars($totalFormularios ?? 0) ?>
            </h3>
        </div>
    </div>

    <!-- BLOQUES -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">

        <!-- OPERADORES POR ESTADO -->
        <div class="bg-[#111] p-5 border border-[#222] rounded">
            <h3 class="text-lg text-[#c8982e] font-semibold mb-4">
                Operadores por estado
            </h3>

            <?php if (!empty($operadoresPorEstado)): ?>
                <div class="space-y-3">
                    <?php foreach ($operadoresPorEstado as $item): ?>
                        <?php
                            $estado = $item['estado'] ?? 'Sin estado';
                            $total = $item['total'] ?? 0;

                            $colorEstado = 'bg-gray-600';
                            if ($estado === 'Activo') $colorEstado = 'bg-green-600';
                            if ($estado === 'Reserva') $colorEstado = 'bg-yellow-500';
                            if ($estado === 'Suspendido') $colorEstado = 'bg-red-600';
                            if ($estado === 'Retirado') $colorEstado = 'bg-gray-800';
                        ?>
                        <div class="flex items-center justify-between bg-[#0d0d0d] border border-[#222] rounded px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full <?= $colorEstado ?>"></span>
                                <span class="text-white"><?= htmlspecialchars($estado) ?></span>
                            </div>
                            <span class="text-[#c8982e] font-bold"><?= htmlspecialchars($total) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400">No hay datos.</p>
            <?php endif; ?>
        </div>

        <!-- OPERADORES POR ROL -->
        <div class="bg-[#111] p-5 border border-[#222] rounded">
            <h3 class="text-lg text-[#c8982e] font-semibold mb-4">
                Operadores por rol
            </h3>

            <?php if (!empty($operadoresPorRol)): ?>
                <div class="space-y-3">
                    <?php foreach ($operadoresPorRol as $item): ?>
                        <?php
                            $rol = $item['rol'] ?? 'Sin rol';
                            $total = $item['total'] ?? 0;
                        ?>
                        <div class="flex items-center justify-between bg-[#0d0d0d] border border-[#222] rounded px-4 py-3">
                            <span class="text-white capitalize"><?= htmlspecialchars($rol) ?></span>
                            <span class="text-[#c8982e] font-bold"><?= htmlspecialchars($total) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400">No hay datos.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">

        <!-- OPERADORES POR RANGO -->
        <div class="bg-[#111] p-5 border border-[#222] rounded">
            <h3 class="text-lg text-[#c8982e] font-semibold mb-4">
                Operadores por rango
            </h3>

            <?php if (!empty($operadoresPorRango)): ?>
                <div class="space-y-3">
                    <?php foreach ($operadoresPorRango as $item): ?>
                        <?php
                            $rango = $item['rango'] ?? 'Sin rango';
                            $total = $item['total'] ?? 0;
                        ?>
                        <div class="flex items-center justify-between bg-[#0d0d0d] border border-[#222] rounded px-4 py-3">
                            <span class="text-white"><?= htmlspecialchars($rango) ?></span>
                            <span class="text-[#c8982e] font-bold"><?= htmlspecialchars($total) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400">No hay datos.</p>
            <?php endif; ?>
        </div>

        <!-- FORMULARIOS POR ESTADO -->
        <div class="bg-[#111] p-5 border border-[#222] rounded">
            <h3 class="text-lg text-[#c8982e] font-semibold mb-4">
                Formularios por estado
            </h3>

            <?php if (!empty($formulariosPorEstado)): ?>
                <div class="space-y-3">
                    <?php foreach ($formulariosPorEstado as $item): ?>
                        <?php
                            $estado = $item['estado'] ?? 'Sin estado';
                            $total = $item['total'] ?? 0;

                            $colorEstado = 'bg-gray-600';
                            if ($estado === 'Pendiente') $colorEstado = 'bg-yellow-500';
                            if ($estado === 'En revision' || $estado === 'En revisión') $colorEstado = 'bg-blue-600';
                            if ($estado === 'Aprobado') $colorEstado = 'bg-green-600';
                            if ($estado === 'Rechazado') $colorEstado = 'bg-red-600';
                        ?>
                        <div class="flex items-center justify-between bg-[#0d0d0d] border border-[#222] rounded px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full <?= $colorEstado ?>"></span>
                                <span class="text-white"><?= htmlspecialchars($estado) ?></span>
                            </div>
                            <span class="text-[#c8982e] font-bold"><?= htmlspecialchars($total) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400">No hay datos.</p>
            <?php endif; ?>
        </div>

    </div>
</div>