<?php
require_once __DIR__ . '/../includes/datos.php';

$titulo = 'Recetas';
$estilos = [];
$paginaActiva = 'recetas';

/* Separamos la recomendación diaria de las recetas de usuario */
$recetaDiaria = null;
$recetasUsuario = [];
foreach ($recetas as $id => $receta) {
    if (!empty($receta['diaria'])) {
        $recetaDiaria = $receta + ['id' => $id];
    } else {
        $recetasUsuario[] = $receta + ['id' => $id];
    }
}

require __DIR__ . '/../includes/head.php';
?>

    <main class="tarjeta">
        <?php require __DIR__ . '/../includes/boton-inicio.php'; ?>

        <h1 class="titulo-pagina">Recetas fit:</h1>

<?php if ($recetaDiaria): ?>
        <!-- RECOMENDACIÓN DIARIA -->
        <section class="seccion">
            <h2 class="titulo-seccion">Recomendación diaria</h2>

            <article class="publicacion">
                <img src="<?= e($recetaDiaria['imagen']) ?>" alt="<?= e($recetaDiaria['titulo']) ?>" class="publicacion-img" width="374" height="204">

                <div class="publicacion-info">
                    <p class="publicacion-texto"><?= e($recetaDiaria['descripcion']) ?></p>

                    <div class="publicacion-acciones">
                        <a href="receta.php?id=<?= urlencode($recetaDiaria['id']) ?>" class="boton-oscuro">Ver más</a>
                    </div>
                </div>
            </article>
        </section>
<?php endif; ?>

        <!-- RECETAS DE USUARIO -->
        <section class="seccion">
            <h2 class="titulo-seccion">Recetas de usuario:</h2>

<?php foreach ($recetasUsuario as $receta): ?>
            <article class="publicacion">
                <img src="<?= e($receta['imagen']) ?>" alt="<?= e($receta['titulo']) ?>" class="publicacion-img" width="374" height="204">

                <div class="publicacion-info">
                    <p class="publicacion-texto"><?= e($receta['descripcion']) ?></p>

                    <div class="publicacion-acciones">
                        <a href="receta.php?id=<?= urlencode($receta['id']) ?>" class="boton-oscuro">Ver más</a>

                        <div class="autor">
                            <img src="../assets/img/iconos/avatar_usuario.png" alt="" class="autor-avatar" width="50" height="50">
                            <span class="autor-nombre">@<?= e($receta['usuario']) ?></span>
                        </div>
                    </div>
                </div>
            </article>
<?php endforeach; ?>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
