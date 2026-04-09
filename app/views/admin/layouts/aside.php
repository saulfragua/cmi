<aside class="w-64 bg-[#111] border-r border-[#222] p-6 min-h-screen">

    <h2 class="text-xl font-bold text-[#c8982e] tracking-widest mb-8">
        CMI ADMIN
    </h2>

    <nav class="space-y-4 text-sm">

        <a href="<?= BASE_URL ?>/admin" class="block hover:text-[#c8982e]">
            🏠 Dashboard
        </a>
        
        <a href="<?= BASE_URL ?>/incorporaciones" class="block hover:text-[#c8982e]">
            📋 Incorporaciones
        </a>

        <a href="<?= BASE_URL ?>/operadores" class="block hover:text-[#c8982e]">
            🎯 Operadores
        </a>

        <a href="<?= BASE_URL ?>/configuracion" class="block hover:text-[#c8982e]">
            ⚙️ Configuración
        </a>

        <hr class="border-[#222]">

        <a href="<?= BASE_URL ?>/logout"
           class="block text-red-500 hover:text-red-400">
            🚪 Cerrar sesión
        </a>

    </nav>

</aside>