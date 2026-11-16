<?php

$email = "";
$errores = [];
$exito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";
    $ncontrasena = $_POST["ncontrasena"] ?? "";
    $rncontrasena = $_POST["rncontrasena"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Correo no válido";
    }
    if ($contrasena === $ncontrasena) {
        $errores[] = "La nueva contraseña no puede coincidir con la actual";
    }
    if ($ncontrasena !== $rncontrasena) {
        $errores[] = "Las contraseñas no coinciden";
    }
    if (strlen($ncontrasena) < 8) {
        $errores[] = "La nueva contraseña debe tener al menos 8 caracteres";
    }

    if (empty($errores)) {
        // 1. Conectar a la BD y buscar al usuario por $email
        // 2. Verificar que $contrasena coincida con el hash guardado usando password_verify($contrasena, $hash_bd)
        // 3. Si es correcta, encriptar la nueva con password_hash($ncontrasena, PASSWORD_DEFAULT) y hacer el UPDATE
        $exito = "Contraseña actualizada correctamente.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bench Warriors - Cambiar Contraseña</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<body>

    <div class="login-wrapper">
        <div class="logo-container">
            <img src="../Imagénes/Benchie_Saluda.jpeg" alt="Bench Warriors Logo" class="logo-img">
        </div>

        <div class="login-card">
            <h1 class="login-title">CAMBIAR CONTRASEÑA</h1>

            <form action="" method="POST" class="login-form">
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="input-group">
                    <label for="contrasena">Contraseña antigua:</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>

                <div class="input-group">
                    <label for="ncontrasena">Nueva contraseña:</label>
                    <input type="password" id="ncontrasena" name="ncontrasena" required>
                </div>
                
                <div class="input-group">
                    <label for="rncontrasena">Repetir nueva contraseña:</label>
                    <input type="password" id="rncontrasena" name="rncontrasena" required>
                </div>

                <?php if (!empty($errores)): ?>
                    <div class="errores-group">
                        <p><?= htmlspecialchars($errores[0]) ?></p>
                    </div>
        
                <?php endif; ?>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
