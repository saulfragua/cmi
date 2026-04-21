<div class="p-6 text-white bg-[#05070d] min-h-screen">

    <?php
    include ROOT . '/app/views/layouts/header.php';
    $mesActual  = date('n');
    $anioActual = date('Y');

    $mes = isset($_GET['mes']) ? (int) $_GET['mes'] : $mesActual;
    $anio = isset($_GET['anio']) ? (int) $_GET['anio'] : $anioActual;

    if ($mes < 1 || $mes > 12) {
        $mes = $mesActual;
    }

    if ($anio < 2026) {
        $anio = 2026;
    }

    $primerDia = date('N', strtotime("$anio-$mes-01"));
    $diasMes   = date('t', strtotime("$anio-$mes-01"));

    $nombresMeses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    $calendario = [];

    if (!empty($actividades)) {
        foreach ($actividades as $a) {
            $dia = (int) date('j', strtotime($a['fecha']));
            $calendario[$dia][] = $a;
        }
    }
    ?>

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="border-l-4 border-[#c8982e] pl-4">
            <h1 class="text-2xl font-bold tracking-widest text-[#c8982e]">
                [CMI] CALENDARIO DE ACTIVIDADES
            </h1>
            <p class="text-sm text-gray-400">
                Consulta de actividades programadas
            </p>
        </div>

        <form method="GET" action="<?= BASE_URL ?>/operador/calendario" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs text-gray-400 mb-1">Año</label>
                <select name="anio" onchange="this.form.submit()"
                    class="bg-[#0b1220] border border-[#1f2937] rounded-lg px-3 py-2 text-white">
                    <?php for ($i = 2026; $i <= 2035; $i++): ?>
                        <option value="<?= $i ?>" <?= $anio == $i ? 'selected' : '' ?>>
                            <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Mes</label>
                <select name="mes" onchange="this.form.submit()"
                    class="bg-[#0b1220] border border-[#1f2937] rounded-lg px-3 py-2 text-white">
                    <?php foreach ($nombresMeses as $numeroMes => $nombreMes): ?>
                        <option value="<?= $numeroMes ?>" <?= $mes == $numeroMes ? 'selected' : '' ?>>
                            <?= $nombreMes ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <div class="text-lg font-bold text-white">
            <?= $nombresMeses[$mes] ?> <?= $anio ?>
        </div>

        <div class="text-sm text-gray-400">
            Actividades del mes: <?= count($actividades) ?>
        </div>
    </div>

    <div class="grid grid-cols-7 gap-2 text-center text-xs mb-2 text-gray-400 uppercase">
        <div class="bg-[#111827] py-2 rounded-lg">Lun</div>
        <div class="bg-[#111827] py-2 rounded-lg">Mar</div>
        <div class="bg-[#111827] py-2 rounded-lg">Mié</div>
        <div class="bg-[#111827] py-2 rounded-lg">Jue</div>
        <div class="bg-[#111827] py-2 rounded-lg">Vie</div>
        <div class="bg-[#111827] py-2 rounded-lg">Sáb</div>
        <div class="bg-[#111827] py-2 rounded-lg">Dom</div>
    </div>

    <div class="grid grid-cols-7 gap-2">
        <?php for ($i = 1; $i < $primerDia; $i++): ?>
            <div class="bg-transparent min-h-[130px]"></div>
        <?php endfor; ?>

        <?php for ($d = 1; $d <= $diasMes; $d++): ?>
            <?php
            $tieneActividades = isset($calendario[$d]) && !empty($calendario[$d]);
            ?>

            <div class="bg-[#0b1220] border border-[#1f2937] rounded-xl p-2 min-h-[130px]">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-[#c8982e]"><?= $d ?></span>
                </div>

                <div class="space-y-1">
                    <?php if ($tieneActividades): ?>
                        <?php foreach ($calendario[$d] as $a): ?>
                            <?php
                            switch ($a['estado']) {
                                case 'Publicada':
                                    $color = 'bg-green-700 hover:bg-green-600 text-white';
                                    break;
                                case 'Finalizada':
                                    $color = 'bg-blue-700 hover:bg-blue-600 text-white';
                                    break;
                                case 'Cancelada':
                                    $color = 'bg-red-700 hover:bg-red-600 text-white';
                                    break;
                                default:
                                    $color = 'bg-yellow-600 hover:bg-yellow-500 text-black';
                                    break;
                            }
                            ?>

                            <a href="<?= BASE_URL ?>/operador/ver?id=<?= $a['id'] ?>"
                                class="block text-xs p-2 rounded <?= $color ?> transition">
                                <div class="font-bold">
                                    <?= htmlspecialchars(substr($a['hora_inicio'], 0, 5)) ?>
                                </div>
                                <div class="truncate">
                                    <?= htmlspecialchars($a['nombre']) ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>