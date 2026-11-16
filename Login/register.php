<?php

$usuario = "";
$email = "";
$errores = [];
$exito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";
    $ncontrasena = $_POST["ncontrasena"] ??"";
    
    /* VALIDACIONES CON BASES DE DATOS 
        1. Si el usuario ya se está usando.
        2. Si el email ya se está usando.
    */   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Correo no válido";
    } 
    if($contrasena !== $ncontrasena){
        $errores[] = "Las contraseñas no coinciden";
    }  

    if (empty($errores)) {
        
        session_start();
        $exito = "Usuario logeado correctamente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bench Warriors - Register</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-wrapper">
        <div class="logo-container">
            <img src="../Imagénes/Benchie_Saluda.jpeg" alt="Bench Warriors Logo" class="logo-img">
        </div>

        <div class="login-card">
            <h1 class="login-title">BIENVENID@ A BENCH WARRIORS</h1>
            
            <form action="" method="POST" class="login-form">
                <div class="input-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario) ?>" required>
                </div>

                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="input-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" value="<?= htmlspecialchars($contrasena) ?>" required>
                </div>

                <div class="input-group">
                    <label for="ncontrasena">Repetir contraseña:</label>
                    <input type="password" id="ncontrasena" name="ncontrasena" value="<?= htmlspecialchars($ncontrasena) ?>" required>
                </div>

                <?php if (!empty($errores)): ?>
                    <div class="errores-group">
                        <p><?= htmlspecialchars($errores[0]) ?></p>
                    </div>
        
                <?php endif; ?>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                    <a href="login.php" class="btn btn-secondary">Login</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>