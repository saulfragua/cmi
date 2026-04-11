<div class="p-4 text-white bg-black min-h-screen">

    <h1 class="text-2xl font-bold text-[#c8982e] mb-6">✏️ Editar Operador</h1>

    <form action="<?= BASE_URL ?>/operadores/actualizar"
          method="POST"
          enctype="multipart/form-data"
          class="max-w-4xl bg-[#111827] border border-[#2b3d57] p-6 rounded grid md:grid-cols-2 gap-4">

        <input type="hidden" name="id" value="<?= $operador['id'] ?>">

        <div>
            <label class="block mb-1">Código</label>
            <input type="text"
                   value="<?= htmlspecialchars($operador['codigo']) ?>"
                   class="w-full bg-[#0b1220] border border-gray-700 px-3 py-2 rounded"
                   disabled>
        </div>

        <div>
            <label class="block mb-1">Foto operador</label>
            <input type="file" name="foto_operador"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
            <?php if (!empty($operador['foto_operador'])): ?>
                <img src="<?= BASE_URL ?>/public/assets/img/operadores/<?= htmlspecialchars($operador['foto_operador']) ?>"
                     class="w-16 h-16 mt-2 border border-gray-600 rounded object-cover">
            <?php endif; ?>
        </div>

        <div>
            <label class="block mb-1">Nombre completo</label>
            <input type="text"
                   name="nombre_completo"
                   value="<?= htmlspecialchars($operador['nombre_completo']) ?>"
                   required
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Fecha nacimiento</label>
            <input type="date"
                   name="fecha_nacimiento"
                   value="<?= htmlspecialchars($operador['fecha_nacimiento']) ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Rango</label>
            <select name="rango_id"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="">Seleccione</option>
                <?php foreach ($rangos as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= ($operador['rango_id'] == $r['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-1">Fecha último ascenso</label>
            <input type="date"
                   name="fecha_ultimo_ascenso"
                   value="<?= htmlspecialchars($operador['fecha_ultimo_ascenso'] ?? '') ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">País</label>
            <input type="text"
                   name="pais"
                   value="<?= htmlspecialchars($operador['pais']) ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Teléfono</label>
            <input type="text"
                   name="telefono"
                   value="<?= htmlspecialchars($operador['telefono']) ?>"
                   class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
        </div>

        <div>
            <label class="block mb-1">Rol</label>
            <select name="rol"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="operador" <?= $operador['rol'] == 'operador' ? 'selected' : '' ?>>Operador</option>
                <option value="mando" <?= $operador['rol'] == 'mando' ? 'selected' : '' ?>>Mando</option>
                <option value="admin" <?= $operador['rol'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Estado</label>
            <select name="estado"
                    class="w-full bg-black border border-gray-600 px-3 py-2 rounded">
                <option value="Activo" <?= $operador['estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Reserva" <?= $operador['estado'] == 'Reserva' ? 'selected' : '' ?>>Reserva</option>
                <option value="Suspendido" <?= $operador['estado'] == 'Suspendido' ? 'selected' : '' ?>>Suspendido</option>
                <option value="Retirado" <?= $operador['estado'] == 'Retirado' ? 'selected' : '' ?>>Retirado</option>
            </select>
        </div>

        <div class="md:col-span-2 flex gap-3 mt-4">
            <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">
                Actualizar
            </button>

            <a href="<?= BASE_URL ?>/operadores"
               class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
                Cancelar
            </a>
        </div>

    </form>
</div>