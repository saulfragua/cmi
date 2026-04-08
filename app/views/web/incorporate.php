


    <section id="incorporacion" class="relative w-full py-16 md:py-24">

        <!-- TARJETA -->
        <div class="relative bg-gradient-to-b from-[#1a1a1a] to-[#101010]
                    border border-[#2a2a2a]
                    rounded-lg
                    shadow-[0_0_30px_rgba(0,0,0,0.9)]
                    p-8 md:p-12">

            <!-- Línea superior -->
            <div class="absolute top-0 left-0 w-full h-[2px] bg-[#c8982e]"></div>

            <!-- TÍTULO -->
            <h2 class="text-3xl font-extrabold tracking-widest text-white mb-6
                       drop-shadow-[0_0_10px_rgba(200,152,46,0.7)]">
                INCORPORACIÓN CMI
            </h2>

            <p class="text-gray-400 mb-8 text-sm tracking-widest">
                COMPLETE EL FORMULARIO PARA INICIAR PROCESO DE RECLUTAMIENTO
            </p>

            <!-- FORMULARIO -->
            <form action="/cmi/public/index.php?url=incorporate/guardar" method="POST"
                  class="grid md:grid-cols-2 gap-6">

                <!-- NOMBRE -->
                <div class="md:col-span-2">
                    <label class="text-gray-400 text-sm">Nombre completo</label>
                    <input type="text" name="nombre" required
                           class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white focus:border-[#c8982e] focus:outline-none">
                </div>

                <!-- EDAD -->
                <div>
                    <label class="text-gray-400 text-sm">Edad</label>
                    <input type="number" name="edad" required
                           class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                </div>

                <!-- FECHA NACIMIENTO -->
                <div>
                    <label class="text-gray-400 text-sm">Fecha nacimiento</label>
                    <input type="date" name="fecha_nacimiento" required
                           class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                </div>

                <!-- PAÍS -->
                <div>
                    <label class="text-gray-400 text-sm">País</label>
                    <select name="pais" required
                            class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                        <option>Colombia</option>
                        <option>México</option>
                        <option>Argentina</option>
                        <option>Chile</option>
                        <option>España</option>
                    </select>
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="text-gray-400 text-sm">Teléfono</label>
                    <input type="tel" name="telefono" required
                           class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                </div>

                <!-- EXPERIENCIA -->
                <div>
                    <label class="text-gray-400 text-sm">Experiencia</label>
                    <select name="experiencia" required
                            class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                        <option>Principiante</option>
                        <option>Intermedio</option>
                        <option>Avanzado</option>
                    </select>
                </div>

                <!-- DISCORD -->
                <div>
                    <label class="text-gray-400 text-sm">Discord</label>
                    <input type="text" name="discord" required
                           class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                </div>

                <!-- STEAM -->
                <div class="md:col-span-2">
                    <label class="text-gray-400 text-sm">Perfil Steam</label>
                    <input type="text" name="steam" required
                           class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white">
                </div>

                <!-- MOTIVO -->
                <div class="md:col-span-2">
                    <label class="text-gray-400 text-sm">Motivo de ingreso</label>
                    <textarea name="motivo" rows="4" required
                              class="w-full bg-black border border-[#333] rounded-md px-4 py-2 text-white"></textarea>
                </div>

                <!-- CHECKS -->
                <div class="md:col-span-2 space-y-3">

                    <label class="flex items-center gap-3 text-gray-400 text-sm">
                        <input type="checkbox" name="normas" required class="accent-[#c8982e]">
                        Acepto las normas del CMI
                    </label>

                    <label class="flex items-center gap-3 text-gray-400 text-sm">
                        <input type="checkbox" name="datos" required class="accent-[#c8982e]">
                        Acepto el tratamiento de datos personales
                    </label>

                </div>

                <!-- BOTÓN -->
                <div class="md:col-span-2">
                    <button type="submit"
                            class="w-full bg-[#c8982e] text-black font-bold py-3 rounded-md
                                   tracking-widest transition
                                   hover:bg-yellow-500 hover:shadow-[0_0_15px_rgba(200,152,46,0.6)]">
                        ENVIAR SOLICITUD
                    </button>
                </div>

            </form>

        </div>

    </div>

