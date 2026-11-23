<?php

/* DATOS DE EJEMPLO
   Más adelante vendrán de la base de datos:
   - Receta diaria: la recomendada para hoy.
   - Recetas de usuario: las publicadas por otros usuarios.
*/
$recetaDiaria = [
    "descripcion" => "Disfruta de una jugosa pechuga de pollo a la parrilla sazonada con finas hierbas, acompañada de una ración de arroz integral y un vibrante salteado de brócoli, pimientos, judías verdes y tomates cherry.",
    "imagen"      => "../Imagenes/receta_diaria.jpg",
    "enlace"      => "#"
];

$recetasUsuario = [
    [
        "descripcion" => "Disfruta de una jugosa pechuga de pollo a la parrilla sazonada con finas hierbas, acompañada de una ración de arroz integral y un vibrante salteado de brócoli, pimientos, judías verdes y tomates cherry.",
        "imagen"      => "../Imagenes/receta_usuario.jpg",
        "enlace"      => "#",
        "usuario"     => "marcosllorente14"
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bench Warriors - Recetas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../Main/footer.css"> <!-- Footer (compartido con Main) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <main class="recetas-card">
        <a href="../Main/main.php" class="home-link" aria-label="Inicio">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round" aria-hidden="true">
                <path d="M3 11.5 12 3l9 8.5"/>
                <path d="M5.5 10v10.5h13V10"/>
                <path d="M10 20.5v-6h4v6"/>
            </svg>
        </a>

        <h1 class="pagina-titulo">RECETAS FIT:</h1>

        <!-- RECOMENDACIÓN DIARIA -->
        <section class="seccion">
            <h2 class="seccion-titulo">RECOMENDACIÓN DIARIA</h2>

            <article class="receta">
                <img src="<?= htmlspecialchars($recetaDiaria["imagen"]) ?>" alt="Receta recomendada del día" class="receta-img">

                <div class="receta-info">
                    <p class="receta-texto"><?= htmlspecialchars($recetaDiaria["descripcion"]) ?></p>

                    <div class="receta-acciones">
                        <a href="<?= htmlspecialchars($recetaDiaria["enlace"]) ?>" class="btn-ver-mas">Ver más</a>
                    </div>
                </div>
            </article>
        </section>

        <!-- RECETAS DE USUARIO -->
        <section class="seccion">
            <h2 class="seccion-titulo">RECETAS DE USUARIO:</h2>

            <?php foreach ($recetasUsuario as $receta): ?>
            <article class="receta">
                <img src="<?= htmlspecialchars($receta["imagen"]) ?>" alt="Receta de <?= htmlspecialchars($receta["usuario"]) ?>" class="receta-img">

                <div class="receta-info">
                    <p class="receta-texto"><?= htmlspecialchars($receta["descripcion"]) ?></p>

                    <div class="receta-acciones">
                        <a href="<?= htmlspecialchars($receta["enlace"]) ?>" class="btn-ver-mas">Ver más</a>

                        <div class="receta-autor">
                            <span class="autor-avatar">
                                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4.5 21c.6-4 3.5-6 7.5-6s6.9 2 7.5 6"/>
                                </svg>
                            </span>
                            <span class="autor-nombre">@<?= htmlspecialchars($receta["usuario"]) ?></span>
                        </div>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <nav class="footer-group">
            <ul>
                <li><a href="recetas.php" class="activo">
                        <img src="../Imagenes/food_icon.svg" alt="Recetas">
                    </a></li>
                <li><a href="">
                        <img src="../Imagenes/run_icon.png" alt="Running">
                    </a></li>
                <li><a href="">
                        <img src="../Imagenes/gym_icon.png" alt="Entrenamientos">
                    </a></li>
                <li><a href="">
                        <img src="../Imagenes/user_icon.png" alt="Perfil">
                    </a></li>
            </ul>
        </nav>
    </footer>

</body>
</html>
