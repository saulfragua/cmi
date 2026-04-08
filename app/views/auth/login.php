<div class="relative bg-gradient-to-b from-[#1a1a1a] to-[#101010]
            border border-[#2a2a2a]
            rounded-lg
            shadow-[0_0_40px_rgba(0,0,0,0.9)]
            p-8">

    <div class="absolute top-0 left-0 w-full h-[2px] bg-[#c8982e]"></div>

    <!-- CERRAR -->
    <button onclick="cerrarLogin()"
            class="absolute top-3 right-4 text-gray-400 hover:text-[#c8982e] text-2xl">
        ×
    </button>

    <!-- LOGO -->
    <div class="flex justify-center mb-4">
        <img src="/cmi/public/assets/img/logos/escudo-Photoroom.png"
             class="h-16 w-auto">
    </div>

    <h2 class="text-2xl font-bold text-white tracking-widest mb-6 text-center">
        ACCESO CMI
    </h2>

    <form action="/cmi/public/index.php?url=login/autenticar"
          method="POST"
          class="space-y-5">

        <input type="text" name="codigo" placeholder="Código"
               class="w-full bg-black border border-[#333] px-4 py-2 text-white">

        <input type="password" name="clave" placeholder="Clave"
               class="w-full bg-black border border-[#333] px-4 py-2 text-white">

        <select name="tipo"
                class="w-full bg-black border border-[#333] px-4 py-2 text-white">
            <option value="">Seleccione</option>
            <option value="operador">Operador</option>
            <option value="mando">Mando</option>
            <option value="admin">Administrador</option>
        </select>

        <button class="w-full bg-[#c8982e] py-3 font-bold">
            INGRESAR
        </button>

    </form>

</div>