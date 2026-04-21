<?php
include ROOT . '/app/views/layouts/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

/*
|--------------------------------------------------------------------------
| Datos esperados desde el controlador
|--------------------------------------------------------------------------
| $operador   -> viene de $this->model->obtenerPorId($id)
| $historial  -> viene de $this->model->obtenerHistorialActividades($id)
|
| Si por alguna razón no vienen, se evita romper la vista.
*/
$operador = $operador ?? [];
$historial = $historial ?? [];

$foto = !empty($operador['foto_operador'])
    ? BASE_URL . '/assets/img/operadores/' . $operador['foto_operador']
    : BASE_URL . '/assets/img/default-user.png';

$nombre = $operador['nombre_completo'] ?? 'Operador';
$codigo = $operador['codigo'] ?? 'N/A';
$rol = $operador['rol'] ?? 'operador';
$estado = $operador['estado'] ?? 'Activo';
$rango = $operador['rango'] ?? 'Sin rango';
$edad = $operador['edad'] ?? 'N/A';
$fechaNacimiento = $operador['fecha_nacimiento'] ?? '';
$pais = $operador['pais'] ?? '';
$telefono = $operador['telefono'] ?? '';
$especialidadPrincipal = $operador['especialidad_principal'] ?? 'No asignada';
$especialidades = $operador['especialidades'] ?? 'No asignadas';
$unidades = $operador['unidades'] ?? 'No asignadas';
$cursos = $operador['cursos'] ?? 'No asignados';
$fechaUltimoAscenso = !empty($operador['fecha_ultimo_ascenso']) ? $operador['fecha_ultimo_ascenso'] : 'N/A';
$fechaModificacion = !empty($operador['fecha_modificacion']) ? $operador['fecha_modificacion'] : 'N/A';

$qrTexto = urlencode($codigo);

/*
|--------------------------------------------------------------------------
| Colores estrictos solicitados
|--------------------------------------------------------------------------
| Negro: #000000
| Militar: #1f2937
| Dorado: #facc15
|--------------------------------------------------------------------------
*/
?>

<div class="min-h-screen bg-black text-white py-8 px-4 md:px-6">
    <div class="max-w-6xl mx-auto">

        <!-- FOLIO -->
        <section class="border border-[#facc15]/30 rounded-2xl overflow-hidden bg-[#1f2937] shadow-2xl shadow-black/50">

            <!-- CABECERA -->
            <div
                class="bg-black border-b border-[#facc15]/20 px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div
                        class="h-14 w-14 rounded-xl border border-[#facc15]/30 bg-[#1f2937] flex items-center justify-center overflow-hidden">
                        <img src="<?= BASE_URL ?>/assets/img/logos/escudo-Photoroom.png" alt="Escudo CMI"
                            class="h-10 w-10 object-contain" onerror="this.style.display='none';">
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-[0.28em] text-[#facc15]">
                            Comando Militar Internacional
                        </p>
                        <h1 class="text-2xl md:text-3xl font-bold">
                            Folio del Operador
                        </h1>
                        <p class="text-sm text-[#facc15]/80 mt-1">
                            Registro operativo institucional
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap">

<a href="<?= BASE_URL ?>/operador/carnet"
   class="px-4 py-2 rounded-lg border border-[#c8982e]/30 text-[#c8982e] bg-black hover:bg-[#1f2937] transition">
    Mi carnet
</a>

                    <a href="<?= BASE_URL ?>/operador/calendario"
                        class="px-4 py-2 rounded-lg border border-[#c8982e]/30 text-[#c8982e] bg-black hover:bg-[#1f2937] transition">
                        Mi calendario
                    </a>
                    <a href="<?= BASE_URL ?>/operador/misObservador"
                        class="px-4 py-2 rounded-lg border border-blue-500/30 text-blue-300 bg-black hover:bg-[#1f2937] transition">
                        Mi observador
                    </a>

                    <a href="<?= BASE_URL ?>/logout"
                        class="px-4 py-2 rounded-lg border border-[#facc15]/30 text-[#facc15] bg-black hover:bg-[#1f2937] transition">
                        Cerrar sesión
                    </a>
                </div>
            </div>

            <!-- CUERPO -->
            <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr]">

                <!-- COLUMNA IZQUIERDA -->
                <aside class="bg-black border-r border-[#facc15]/10 p-6">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-44 h-56 rounded-xl overflow-hidden border border-[#facc15]/30 bg-[#1f2937]">
                            <img src="<?= htmlspecialchars($foto) ?>" alt="Foto del operador"
                                class="w-full h-full object-cover"
                                onerror="this.src='<?= BASE_URL ?>/assets/img/default-user.png'">
                        </div>

                        <h2 class="mt-5 text-xl font-bold">
                            <?= htmlspecialchars($nombre) ?>
                        </h2>

                        <p class="mt-1 text-[#facc15] text-sm uppercase tracking-wider">
                            <?= htmlspecialchars($rango) ?>
                        </p>

                        <p class="mt-3 text-sm text-[#facc15]">
                            <?= strtoupper(htmlspecialchars($rol)) ?>
                        </p>

                        <div class="mt-4 w-full border-t border-[#facc15]/15 pt-4">
                            <p class="text-xs uppercase tracking-widest text-[#facc15] mb-2">Código</p>
                            <p class="text-sm"><?= htmlspecialchars($codigo) ?></p>
                        </div>

                        <div class="mt-4 w-full border-t border-[#facc15]/15 pt-4">
                            <p class="text-xs uppercase tracking-widest text-[#facc15] mb-2">Estado</p>
                            <p class="text-sm"><?= htmlspecialchars($estado) ?></p>
                        </div>

                        <div class="mt-6 w-full border-t border-[#facc15]/15 pt-5">
                            <p class="text-xs uppercase tracking-widest text-[#facc15] mb-3">QR del Operador</p>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?= $qrTexto ?>"
                                alt="QR del operador"
                                class="mx-auto border border-[#facc15]/20 bg-white p-2 rounded-lg">
                        </div>

                        <form action="<?= BASE_URL ?>/operador/actualizarFoto" method="POST"
                            enctype="multipart/form-data" class="mt-6 w-full border-t border-[#facc15]/15 pt-5">
                            <label class="block text-xs uppercase tracking-widest text-[#facc15] mb-3">
                                Cambiar foto
                            </label>

                            <input type="file" name="foto" accept="image/*"
                                class="block w-full text-xs text-white file:mr-3 file:px-3 file:py-2 file:border-0 file:rounded-lg file:bg-[#1f2937] file:text-[#facc15] file:cursor-pointer">

                            <button type="submit"
                                class="mt-3 w-full px-4 py-2 rounded-lg border border-[#facc15]/30 text-[#facc15] bg-[#1f2937] hover:bg-black transition">
                                Actualizar foto
                            </button>
                            <div class="mt-6">
                                <button onclick="togglePasswordForm()"
                                    class="bg-[#c8982e] hover:bg-[#d4a73a] text-black font-semibold px-4 py-2 rounded-lg transition">
                                    🔐 Cambiar clave
                                </button>
                                <div id="formCambiarClave"
                                    class="hidden mt-6 bg-[#111827] border border-[#374151] rounded-xl p-4">
                                    <h2 class="text-lg font-bold text-[#c8982e] mb-4">Actualizar clave</h2>

                                    <form action="<?= BASE_URL ?>/operador/cambiarClave" method="POST"
                                        class="space-y-4">

                                        <div>
                                            <label class="text-sm text-gray-400">Nueva clave</label>
                                            <input type="password" name="nueva_clave" required
                                                class="w-full mt-1 px-3 py-2 bg-[#0f172a] border border-[#374151] rounded text-white">
                                        </div>

                                        <div>
                                            <label class="text-sm text-gray-400">Confirmar clave</label>
                                            <input type="password" name="confirmar_clave" required
                                                class="w-full mt-1 px-3 py-2 bg-[#0f172a] border border-[#374151] rounded text-white">
                                        </div>

                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white font-semibold">
                                            Guardar cambios
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- COLUMNA DERECHA -->
                <main class="p-6 md:p-8 space-y-8">

                    <!-- DATOS PRINCIPALES -->
                    <section>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <h3 class="text-lg font-bold text-[#facc15] uppercase tracking-wider">
                                Información General
                            </h3>

                            <button type="button" id="btnEditarPerfil"
                                class="px-4 py-2 rounded-lg border border-[#facc15]/30 text-[#facc15] bg-black hover:bg-[#1f2937] transition">
                                Editar perfil
                            </button>
                        </div>

                        <?php if (!empty($_SESSION['success_operador'])): ?>
                            <div
                                class="mb-4 px-4 py-3 rounded-lg border border-green-500/30 bg-green-900/20 text-green-300 text-sm">
                                <?= htmlspecialchars($_SESSION['success_operador']) ?>
                            </div>
                            <?php unset($_SESSION['success_operador']); ?>
                        <?php endif; ?>

                        <?php if (!empty($_SESSION['error_operador'])): ?>
                            <div
                                class="mb-4 px-4 py-3 rounded-lg border border-red-500/30 bg-red-900/20 text-red-300 text-sm">
                                <?= htmlspecialchars($_SESSION['error_operador']) ?>
                            </div>
                            <?php unset($_SESSION['error_operador']); ?>
                        <?php endif; ?>

                        <form action="<?= BASE_URL ?>/operador/actualizarPerfil" method="POST" id="formEditarPerfil">
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-y-5 gap-x-8">

                                <div>
                                    <label class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Nombre
                                        completo</label>
                                    <input type="text" name="nombre_completo" value="<?= htmlspecialchars($nombre) ?>"
                                        class="campo-editable w-full px-3 py-2 rounded-lg bg-black border border-[#facc15]/20 text-white disabled:bg-[#111827] disabled:text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Código</label>
                                    <input type="text" value="<?= htmlspecialchars($codigo) ?>"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Rol</label>
                                    <input type="text" value="<?= strtoupper(htmlspecialchars($rol)) ?>"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Estado</label>
                                    <input type="text" value="<?= htmlspecialchars($estado) ?>"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Rango</label>
                                    <input type="text" value="<?= htmlspecialchars($rango) ?>"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Edad</label>
                                    <input type="text" value="<?= htmlspecialchars($edad) ?> años"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Fecha de
                                        nacimiento</label>
                                    <input type="date" name="fecha_nacimiento"
                                        value="<?= htmlspecialchars($fechaNacimiento) ?>"
                                        class="campo-editable w-full px-3 py-2 rounded-lg bg-black border border-[#facc15]/20 text-white disabled:bg-[#111827] disabled:text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">País</label>
                                    <input type="text" name="pais" value="<?= htmlspecialchars($pais) ?>"
                                        class="campo-editable w-full px-3 py-2 rounded-lg bg-black border border-[#facc15]/20 text-white disabled:bg-[#111827] disabled:text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label
                                        class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Teléfono</label>
                                    <input type="text" name="telefono" value="<?= htmlspecialchars($telefono) ?>"
                                        class="campo-editable w-full px-3 py-2 rounded-lg bg-black border border-[#facc15]/20 text-white disabled:bg-[#111827] disabled:text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Último
                                        ascenso</label>
                                    <input type="text" value="<?= htmlspecialchars($fechaUltimoAscenso) ?>"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>

                                <div>
                                    <label class="text-xs uppercase tracking-widest text-[#facc15] mb-1 block">Última
                                        modificación</label>
                                    <input type="text" value="<?= htmlspecialchars($fechaModificacion) ?>"
                                        class="w-full px-3 py-2 rounded-lg bg-[#111827] border border-[#facc15]/10 text-gray-300"
                                        disabled>
                                </div>
                            </div>

                            <div id="accionesEditarPerfil" class="mt-5 hidden flex-wrap gap-3">
                                <button type="submit"
                                    class="px-5 py-2 rounded-lg border border-green-500/30 text-green-300 bg-green-900/20 hover:bg-green-900/30 transition">
                                    Guardar cambios
                                </button>

                                <button type="button" id="btnCancelarEdicion"
                                    class="px-5 py-2 rounded-lg border border-red-500/30 text-red-300 bg-red-900/20 hover:bg-red-900/30 transition">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- PERFIL OPERATIVO -->
                    <section class="border-t border-[#facc15]/15 pt-6">
                        <h3 class="text-lg font-bold text-[#facc15] mb-4 uppercase tracking-wider">
                            Perfil Operativo
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
                            <div>
                                <p class="text-xs uppercase tracking-widest text-[#facc15] mb-1">Especialidad principal
                                </p>
                                <p><?= htmlspecialchars($especialidadPrincipal) ?></p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-widest text-[#facc15] mb-1">Especialidades</p>
                                <p><?= htmlspecialchars($especialidades) ?></p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-widest text-[#facc15] mb-1">Unidad</p>
                                <p><?= htmlspecialchars($unidades) ?></p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-widest text-[#facc15] mb-1">Cursos</p>
                                <p><?= htmlspecialchars($cursos) ?></p>
                            </div>
                        </div>
                    </section>

                    <!-- HISTORIAL -->
                    <section class="border-t border-[#facc15]/15 pt-6">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <h3 class="text-lg font-bold text-[#facc15] uppercase tracking-wider">
                                Últimas 5 Actividades Asistidas
                            </h3>
                        </div>

                        <?php if (!empty($historial)): ?>
                            <div class="overflow-x-auto border border-[#facc15]/10 rounded-xl">
                                <table class="w-full text-sm">
                                    <thead class="bg-black">
                                        <tr class="text-left">
                                            <th class="px-4 py-3 text-[#facc15] font-semibold">Actividad</th>
                                            <th class="px-4 py-3 text-[#facc15] font-semibold">Tipo</th>
                                            <th class="px-4 py-3 text-[#facc15] font-semibold">Fecha</th>
                                            <th class="px-4 py-3 text-[#facc15] font-semibold">Participación</th>
                                            <th class="px-4 py-3 text-[#facc15] font-semibold">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($historial as $item): ?>
                                            <tr class="border-t border-[#facc15]/10 hover:bg-black/40 transition">
                                                <td class="px-4 py-3"><?= htmlspecialchars($item['nombre'] ?? 'N/A') ?></td>
                                                <td class="px-4 py-3"><?= htmlspecialchars($item['tipo'] ?? 'N/A') ?></td>
                                                <td class="px-4 py-3"><?= htmlspecialchars($item['fecha'] ?? 'N/A') ?></td>
                                                <td class="px-4 py-3">
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full border border-green-500/20 text-green-300 bg-green-900/20 text-xs font-semibold">
                                                        <?= htmlspecialchars($item['estado_participacion'] ?? 'N/A') ?>
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <?= htmlspecialchars($item['estado_actividad'] ?? 'N/A') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="border border-[#facc15]/10 rounded-xl px-4 py-5 bg-black">
                                <p class="text-sm text-gray-300">No hay actividades asistidas registradas para este
                                    operador.</p>
                            </div>
                        <?php endif; ?>
                    </section>

                </main>
            </div>

            <!-- PIE -->
            <div
                class="bg-black border-t border-[#facc15]/20 px-6 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-[#facc15]/80">
                <span>CMI • Sistema Operativo</span>
                <span>Registro institucional del operador</span>
            </div>
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEditar = document.getElementById('btnEditarPerfil');
        const btnCancelar = document.getElementById('btnCancelarEdicion');
        const camposEditables = document.querySelectorAll('.campo-editable');
        const acciones = document.getElementById('accionesEditarPerfil');

        if (btnEditar) {
            btnEditar.addEventListener('click', function () {
                camposEditables.forEach(campo => {
                    campo.removeAttribute('disabled');
                });

                acciones.classList.remove('hidden');
                acciones.classList.add('flex');
                btnEditar.classList.add('hidden');
            });
        }

        if (btnCancelar) {
            btnCancelar.addEventListener('click', function () {
                window.location.href = "<?= BASE_URL ?>/operador";
            });
        }
    });
    function togglePasswordForm() {
        const form = document.getElementById('formCambiarClave');
        form.classList.toggle('hidden');
    }
</script>