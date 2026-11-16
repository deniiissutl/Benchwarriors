<?php

$usuario = "";
$contrasena = "";
$errores = [];
$exito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";
    
    /* VALIDACIONES CON BASES DE DATOS 
        1. Si el usuario existe.
        2. Si la contraseña del usuario coincide.
    */    

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
    <title>Bench Warriors - Login</title>
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
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" value="<?= htmlspecialchars($contrasena) ?>" required>
                </div>

                <a href="resetpass.php" class="forgot-password">¿Has olvidado tu contraseña?</a>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                    <a href="register.php" class="btn btn-secondary">Registro</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>