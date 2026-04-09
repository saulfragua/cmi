<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin CMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0a0a0a] text-white">

<div class="flex">

    <!-- ASIDE -->
    <?php require ROOT . '/app/views/admin/layouts/aside.php'; ?>

    <!-- CONTENIDO -->
    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        <?php require ROOT . '/app/views/admin/layouts/navbar.php'; ?>

        <!-- CONTENIDO DINÁMICO -->
        <main class="p-6">
            <?php require $contenido; ?>
        </main>

    </div>

</div>

</body>
</html>