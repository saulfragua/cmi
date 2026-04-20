<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clave = $_POST['clave'];
    $hash = password_hash($clave, PASSWORD_DEFAULT);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Hash</title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>🔐 Generador de Claves Hash</h2>

    <form method="POST">
        <input type="text" name="clave" placeholder="Escribe la clave" required style="padding: 10px; width: 300px;">
        <button type="submit" style="padding: 10px;">Generar</button>
    </form>

    <?php if (!empty($hash)): ?>
        <h3>Hash generado:</h3>
        <textarea rows="4" cols="80"><?= $hash ?></textarea>
    <?php endif; ?>

</body>
</html>