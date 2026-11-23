<?php
require_once __DIR__ . '/../includes/datos.php';

$titulo = 'Rutas';
$estilos = [];
$paginaActiva = 'rutas';

require __DIR__ . '/../includes/head.php';
?>

    <main class="tarjeta">
        <?php require __DIR__ . '/../includes/boton-inicio.php'; ?>

        <h1 class="titulo-pagina">Rutas por tu zona:</h1>

        <!-- RECOMENDACIÓN DIARIA -->
        <section class="seccion">
            <h2 class="titulo-seccion">Recomendación diaria</h2>

            <article class="publicacion">
                <img src="<?= e($rutaDiaria['imagen']) ?>" alt="Mapa de la ruta recomendada del día" class="publicacion-img" width="374" height="206">

                <div class="publicacion-info">
                    <p class="publicacion-texto"><?= e($rutaDiaria['descripcion']) ?></p>

                    <div class="publicacion-acciones">
                        <a href="<?= e($rutaDiaria['maps']) ?>" class="boton-oscuro" target="_blank" rel="noopener noreferrer">Google Maps</a>
                        <img src="../assets/img/iconos/google_maps.png" alt="" class="icono-maps" width="41" height="41">
                    </div>
                </div>
            </article>
        </section>

        <!-- RUTAS DE USUARIO -->
        <section class="seccion">
            <h2 class="titulo-seccion">Rutas de usuario:</h2>

<?php foreach ($rutasUsuario as $ruta): ?>
            <article class="publicacion">
                <img src="<?= e($ruta['imagen']) ?>" alt="Mapa de la ruta de @<?= e($ruta['usuario']) ?>" class="publicacion-img" width="374" height="206">

                <div class="publicacion-info">
                    <p class="publicacion-texto"><?= e($ruta['descripcion']) ?></p>

                    <div class="publicacion-acciones">
                        <a href="<?= e($ruta['maps']) ?>" class="boton-oscuro" target="_blank" rel="noopener noreferrer">Google Maps</a>
                        <img src="../assets/img/iconos/google_maps.png" alt="" class="icono-maps" width="41" height="41">

                        <div class="autor">
                            <img src="../assets/img/iconos/avatar_usuario.png" alt="" class="autor-avatar" width="50" height="50">
                            <span class="autor-nombre">@<?= e($ruta['usuario']) ?></span>
                        </div>
                    </div>
                </div>
            </article>
<?php endforeach; ?>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
