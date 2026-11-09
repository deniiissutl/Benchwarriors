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
            <h1 class="login-title">BIENVENID@ A BENCH<br>WARRIORS</h1>
            
            <form action="" method="POST" class="login-form">
                <div class="input-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>

                <div class="input-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>

                <a href="#" class="forgot-password">¿Has olvidado tu contraseña?</a>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                    <button type="button" class="btn btn-secondary">Registro</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>