<div class="p-4 text-white bg-black min-h-screen">

    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">🧩 Asignar recursos al operador</h1>

    <div class="bg-[#111827] border border-[#2b3d57] p-4 rounded mb-6">
        <p><strong>Nombre:</strong> <?= htmlspecialchars($operador['nombre_completo']) ?></p>
        <p><strong>Código:</strong> <?= htmlspecialchars($operador['codigo']) ?></p>
        <p><strong>Rango:</strong> <?= htmlspecialchars($operador['rango'] ?? 'N/A') ?></p>
    </div>

    <form action="<?= BASE_URL ?>/operadores/guardarAsignaciones"
          method="POST"
          class="bg-[#111827] border border-[#2b3d57] p-6 rounded grid md:grid-cols-3 gap-6">

        <input type="hidden" name="operador_id" value="<?= $operador['id'] ?>">

        <!-- ESPECIALIDADES -->
        <div>
            <label class="block mb-2 font-semibold text-blue-400">Especialidades</label>

            <div class="flex gap-2 mb-3">
                <select id="select_especialidades"
                        class="w-full bg-black border border-gray-700 text-white px-3 py-2 rounded">
                    <option value="">Seleccione una especialidad</option>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id'] ?>" data-nombre="<?= htmlspecialchars($e['nombre']) ?>">
                            <?= htmlspecialchars($e['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="button"
                        onclick="agregarItem('especialidades')"
                        class="bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded">
                    Agregar
                </button>
            </div>

            <div id="lista_especialidades"
                 class="bg-black border border-gray-700 rounded p-3 min-h-[120px] space-y-2">
                <?php foreach ($especialidades as $e): ?>
                    <?php if (in_array($e['id'], $especialidadesAsignadas)): ?>
                        <div class="flex items-center justify-between bg-[#0b1220] border border-gray-700 px-3 py-2 rounded item-especialidades"
                             data-id="<?= $e['id'] ?>">
                            <span><?= htmlspecialchars($e['nombre']) ?></span>
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="especialidades[]" value="<?= $e['id'] ?>">
                                <button type="button"
                                        onclick="eliminarItem(this)"
                                        class="bg-red-700 hover:bg-red-800 text-xs px-2 py-1 rounded">
                                    Quitar
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CURSOS -->
        <div>
            <label class="block mb-2 font-semibold text-green-400">Cursos</label>

            <div class="flex gap-2 mb-3">
                <select id="select_cursos"
                        class="w-full bg-black border border-gray-700 text-white px-3 py-2 rounded">
                    <option value="">Seleccione un curso</option>
                    <?php foreach ($cursos as $c): ?>
                        <option value="<?= $c['id'] ?>" data-nombre="<?= htmlspecialchars($c['nombre']) ?>">
                            <?= htmlspecialchars($c['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="button"
                        onclick="agregarItem('cursos')"
                        class="bg-green-700 hover:bg-green-800 px-3 py-2 rounded">
                    Agregar
                </button>
            </div>

            <div id="lista_cursos"
                 class="bg-black border border-gray-700 rounded p-3 min-h-[120px] space-y-2">
                <?php foreach ($cursos as $c): ?>
                    <?php if (in_array($c['id'], $cursosAsignados)): ?>
                        <div class="flex items-center justify-between bg-[#0b1220] border border-gray-700 px-3 py-2 rounded item-cursos"
                             data-id="<?= $c['id'] ?>">
                            <span><?= htmlspecialchars($c['nombre']) ?></span>
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="cursos[]" value="<?= $c['id'] ?>">
                                <button type="button"
                                        onclick="eliminarItem(this)"
                                        class="bg-red-700 hover:bg-red-800 text-xs px-2 py-1 rounded">
                                    Quitar
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- UNIDADES -->
        <div>
            <label class="block mb-2 font-semibold text-yellow-400">Unidades</label>

            <div class="flex gap-2 mb-3">
                <select id="select_unidades"
                        class="w-full bg-black border border-gray-700 text-white px-3 py-2 rounded">
                    <option value="">Seleccione una unidad</option>
                    <?php foreach ($unidades as $u): ?>
                        <option value="<?= $u['id'] ?>" data-nombre="<?= htmlspecialchars($u['nombre']) ?>">
                            <?= htmlspecialchars($u['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="button"
                        onclick="agregarItem('unidades')"
                        class="bg-yellow-700 hover:bg-yellow-800 px-3 py-2 rounded">
                    Agregar
                </button>
            </div>

            <div id="lista_unidades"
                 class="bg-black border border-gray-700 rounded p-3 min-h-[120px] space-y-2">
                <?php foreach ($unidades as $u): ?>
                    <?php if (in_array($u['id'], $unidadesAsignadas)): ?>
                        <div class="flex items-center justify-between bg-[#0b1220] border border-gray-700 px-3 py-2 rounded item-unidades"
                             data-id="<?= $u['id'] ?>">
                            <span><?= htmlspecialchars($u['nombre']) ?></span>
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="unidades[]" value="<?= $u['id'] ?>">
                                <button type="button"
                                        onclick="eliminarItem(this)"
                                        class="bg-red-700 hover:bg-red-800 text-xs px-2 py-1 rounded">
                                    Quitar
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="md:col-span-3 flex gap-3 mt-4">
            <button type="submit"
                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded">
                Guardar asignaciones
            </button>

            <a href="<?= BASE_URL ?>/operadores"
               class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function agregarItem(tipo) {
    const select = document.getElementById('select_' + tipo);
    const lista = document.getElementById('lista_' + tipo);

    const id = select.value;
    const nombre = select.options[select.selectedIndex]?.dataset.nombre;

    if (!id || !nombre) return;

    if (lista.querySelector('[data-id="' + id + '"]')) {
        alert('Ese elemento ya está asignado.');
        return;
    }

    const div = document.createElement('div');
    div.className = 'flex items-center justify-between bg-[#0b1220] border border-gray-700 px-3 py-2 rounded item-' + tipo;
    div.setAttribute('data-id', id);

    div.innerHTML = `
        <span>${nombre}</span>
        <div class="flex items-center gap-2">
            <input type="hidden" name="${tipo}[]" value="${id}">
            <button type="button"
                    onclick="eliminarItem(this)"
                    class="bg-red-700 hover:bg-red-800 text-xs px-2 py-1 rounded">
                Quitar
            </button>
        </div>
    `;

    lista.appendChild(div);
    select.value = '';
}

function eliminarItem(boton) {
    const item = boton.closest('div[data-id]');
    if (item) {
        item.remove();
    }
}
</script>