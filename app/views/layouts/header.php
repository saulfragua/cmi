<?php
/**
 * ============================================
 * HEADER GLOBAL - TAILWIND
 * ============================================
 */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMI - Comando Militar Internacional</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/cmi/public/assets/css/styles.css"><link rel="stylesheet" href="/cmi/public/assets/css/login.css">
    <!-- Configuración personalizada -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        militar: '#1f2937',   // gris oscuro
                        dorado: '#facc15'
                    }
                }
            }
        }
    </script>
</head>
