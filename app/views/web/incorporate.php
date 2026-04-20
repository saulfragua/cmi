<?php
include ROOT . '/app/views/layouts/header.php';
include ROOT . '/app/views/layouts/whatsapp.php';
?>

<section id="incorporacion"
    class="relative w-full pt-36 md:pt-40 pb-10 md:pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto relative bg-gradient-to-b from-[#1a1a1a] to-[#101010]
                border border-[#2a2a2a]
                rounded-lg
                shadow-[0_0_30px_rgba(0,0,0,0.9)]
                p-5 sm:p-6 md:p-8 lg:p-12">

        <div class="absolute top-0 left-0 w-full h-[2px] bg-[#c8982e]"></div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-widest text-white drop-shadow-[0_0_10px_rgba(200,152,46,0.7)]">
                    INCORPORACIÓN CMI
                </h2>
                <p class="text-gray-400 mt-2 text-xs sm:text-sm tracking-widest">
                    COMPLETE EL FORMULARIO PARA INICIAR PROCESO DE RECLUTAMIENTO
                </p>
            </div>

            <a href="<?= BASE_URL ?>/"
               class="inline-flex items-center justify-center px-4 py-2 rounded-md border border-[#c8982e] text-[#c8982e] text-sm font-semibold hover:bg-[#c8982e] hover:text-black transition-all duration-300">
                ← Volver al inicio
            </a>
        </div>

        <form id="formIncorporacion"
              action="<?= BASE_URL ?>/index.php?url=incorporate/guardar"
              method="POST"
              onsubmit="return validarFormulario()"
              class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

            <div class="md:col-span-2">
                <label class="text-gray-400 text-sm">Nombre completo</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required
                    class="w-full bg-black border border-[#333] rounded-md px-4 py-2.5 text-sm sm:text-base text-white focus:outline-none focus:border-[#c8982e]">
            </div>

            <div>
                <label class="text-gray-400 text-sm">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required
                    class="w-full bg-black border border-[#333] rounded-md px-4 py-2.5 text-sm sm:text-base text-white focus:outline-none focus:border-[#c8982e]">
            </div>

            <div>
                <label class="text-gray-400 text-sm">País</label>
                <select id="pais" name="pais_id" required
                    class="w-full bg-black border border-[#333] rounded-md px-4 py-2.5 text-sm sm:text-base text-white focus:outline-none focus:border-[#c8982e]">
                    <option value="">Seleccione un país</option>

                    <?php foreach ($paises as $pais): ?>
                        <option value="<?= $pais['id'] ?>"
                            data-bandera="<?= BASE_URL ?>/assets/img/nacionalidad/<?= trim($pais['bandera']) ?>"
                            data-indicativo="<?= trim($pais['indicativo']) ?>">
                            <?= htmlspecialchars($pais['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="text-gray-400 text-sm">Teléfono</label>

                <div class="flex items-center w-full bg-black border border-[#333] rounded-md overflow-hidden">
                    <div class="flex items-center gap-2 px-2 sm:px-3 py-2 border-r border-[#333] bg-[#111] min-w-[90px] sm:min-w-[110px]">
                        <img id="banderaTelefono"
                            src="<?= BASE_URL ?>/assets/img/nacionalidad/default.png"
                            class="w-5 h-5 object-cover rounded-sm"
                            alt="Bandera">
                        <span id="indicativoTelefono" class="text-xs sm:text-sm text-gray-300">+00</span>
                    </div>

                    <input
                        type="tel"
                        id="telefono"
                        name="telefono"
                        required
                        class="w-full bg-black px-3 sm:px-4 py-2.5 text-sm sm:text-base text-white focus:outline-none"
                        placeholder="Selecione un país para mostrar el indicativo">
                </div>

                <input type="hidden" id="indicativo" name="indicativo">
            </div>

            <div>
                <label class="text-gray-400 text-sm">Nombre de Discord</label>
                <input type="text" id="discord" name="discord"
                    class="w-full bg-black border border-[#333] rounded-md px-4 py-2.5 text-sm sm:text-base text-white focus:outline-none focus:border-[#c8982e]"
                    placeholder="Ej: Usuario#1234 o Usuario">
            </div>

            <div class="md:col-span-2">
                <label class="text-gray-400 text-sm">Motivo</label>
                <textarea id="motivo" name="motivo" rows="4"
                    class="w-full bg-black border border-[#333] rounded-md px-4 py-2.5 text-sm sm:text-base text-white focus:outline-none focus:border-[#c8982e]"></textarea>
            </div>

            <div class="md:col-span-2 space-y-3">
                <label class="flex items-center gap-3 text-gray-400 text-sm">
                    <input type="checkbox" id="normas" name="normas" required class="accent-[#c8982e]">
                    Acepto las normas del CMI
                </label>

                <label class="flex items-center gap-3 text-gray-400 text-sm">
                    <input type="checkbox" id="datos" name="datos" required class="accent-[#c8982e]">
                    Acepto el tratamiento de datos personales
                </label>
            </div>

            <div style="display:none;">
                <input type="text" name="website">
            </div>

            <div class="md:col-span-2">
                <button type="button" onclick="return confirmarEnvio()"
                    class="w-full bg-[#c8982e] text-black font-bold py-3 rounded-md">
                    ENVIAR SOLICITUD
                </button>
            </div>
        </form>
    </div>
</section>


<?php include_once ROOT . '/app/views/layouts/footer.php'; ?>