<?php $ruta = $_GET['url'] ?? 'admin'; ?>

<aside class="w-64 min-w-[250px] max-w-[250px] bg-[#111] border-r border-[#222] p-6 min-h-screen flex flex-col">

    <!-- LOGO -->
    <h2 class="text-xl font-bold text-[#c8982e] tracking-widest mb-8 leading-tight">
        CMI<br>ADMIN
    </h2>

    <!-- MENU -->
    <nav class="space-y-3 text-sm flex-1">

        <a href="<?= BASE_URL ?>/admin"
           class="block px-2 py-1 rounded transition
           <?= $ruta == 'admin' ? 'text-[#c8982e] bg-[#1a1a1a]' : 'hover:text-[#c8982e]' ?>">
            🏠 Dashboard
        </a>
        
        <a href="<?= BASE_URL ?>/incorporaciones"
           class="block px-2 py-1 rounded transition
           <?= $ruta == 'incorporaciones' ? 'text-[#c8982e] bg-[#1a1a1a]' : 'hover:text-[#c8982e]' ?>">
            📋 Incorporaciones
        </a>

        <a href="<?= BASE_URL ?>/operadores"
           class="block px-2 py-1 rounded transition
           <?= $ruta == 'operadores' ? 'text-[#c8982e] bg-[#1a1a1a]' : 'hover:text-[#c8982e]' ?>">
            🎯 Operadores
        </a>

                <a href="<?= BASE_URL ?>/rangos"
           class="block px-2 py-1 rounded transition
           <?= $ruta == 'rangos' ? 'text-[#c8982e] bg-[#1a1a1a]' : 'hover:text-[#c8982e]' ?>">
            🎖 Rangos
        </a>

<a href="<?= BASE_URL ?>/especialidades"
   class="block px-2 py-1 rounded hover:text-[#c8982e]">
    🛠 Especialidades
</a>

                <a href="<?= BASE_URL ?>/unidades"
           class="block px-2 py-1 rounded transition
           <?= $ruta == 'unidades' ? 'text-[#c8982e] bg-[#1a1a1a]' : 'hover:text-[#c8982e]' ?>">
            🏢 Unidades 
        </a>

        <a href="<?= BASE_URL ?>/cursos"
   class="block px-2 py-1 rounded hover:text-[#c8982e]">
    🎓 Cursos
</a>

        <a href="<?= BASE_URL ?>/configuracion"
           class="block px-2 py-1 rounded transition
           <?= $ruta == 'configuracion' ? 'text-[#c8982e] bg-[#1a1a1a]' : 'hover:text-[#c8982e]' ?>">
            ⚙️ Configuración
        </a>

    </nav>

    <!-- FOOTER -->
    <div class="pt-4 border-t border-[#222]">
        <a href="<?= BASE_URL ?>/logout"
           class="block px-2 py-1 text-red-500 hover:text-red-400 transition">
            🚪 Cerrar sesión
        </a>
    </div>

</aside>