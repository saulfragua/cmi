<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Operador CMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0a0a0a] text-white">

<div class="min-h-screen flex flex-col">

    <!-- ================= HEADER ================= -->
    <header class="bg-[#111] border-b border-[#222] p-4 flex justify-between items-center">

        <h1 class="text-lg font-bold tracking-widest text-[#c8982e]">
            PANEL OPERADOR CMI
        </h1>

        <div class="text-sm text-gray-400">
            <?= $_SESSION['user']['nombre'] ?? 'Operador' ?>
        </div>

        <a href="<?= BASE_URL ?>/logout"
           class="text-red-500 text-sm hover:text-red-400">
            Cerrar sesión
        </a>

    </header>


    <!-- ================= CONTENIDO ================= -->
    <main class="flex-1 p-6">

        <!-- BIENVENIDA -->
        <div class="mb-8">
            <h2 class="text-xl text-[#c8982e] font-bold">
                Bienvenido, Operador
            </h2>
            <p class="text-gray-400 text-sm">
                Sistema activo. Prepárate para operaciones.
            </p>
        </div>


        <!-- ================= TARJETAS ================= -->
        <div class="grid md:grid-cols-3 gap-6 mb-10">

            <div class="bg-[#111] border border-[#222] p-5 rounded hover:border-[#c8982e]">
                <p class="text-gray-400 text-sm">Estado</p>
                <h3 class="text-green-400 font-bold text-lg">ACTIVO</h3>
            </div>

            <div class="bg-[#111] border border-[#222] p-5 rounded hover:border-[#c8982e]">
                <p class="text-gray-400 text-sm">Rol</p>
                <h3 class="text-[#c8982e] font-bold text-lg">OPERADOR</h3>
            </div>

            <div class="bg-[#111] border border-[#222] p-5 rounded hover:border-[#c8982e]">
                <p class="text-gray-400 text-sm">Unidad</p>
                <h3 class="text-[#c8982e] font-bold text-lg">CMI</h3>
            </div>

        </div>


        <!-- ================= OPERACIONES ================= -->
        <div class="bg-[#111] border border-[#222] rounded-lg p-6 mb-8">

            <h3 class="text-[#c8982e] text-lg mb-4">
                Próximas Operaciones
            </h3>

            <ul class="space-y-3 text-sm text-gray-300">

                <li class="border-b border-[#222] pb-2">
                    🕒 Entrenamiento táctico — 19:30
                </li>

                <li class="border-b border-[#222] pb-2">
                    🎯 Simulación urbana — 20:00
                </li>

                <li>
                    📡 Operación especial — 21:00
                </li>

            </ul>

        </div>


        <!-- ================= ACCIONES ================= -->
        <div class="grid md:grid-cols-2 gap-6">

            <a href="#"
               class="block text-center bg-[#c8982e] text-black py-3 font-bold rounded hover:bg-yellow-500 transition">
                UNIRSE A OPERACIÓN
            </a>

            <a href="#"
               class="block text-center border border-[#c8982e] text-[#c8982e] py-3 font-bold rounded hover:bg-[#c8982e] hover:text-black transition">
                VER INSTRUCCIONES
            </a>

        </div>

    </main>

</div>

</body>
</html>