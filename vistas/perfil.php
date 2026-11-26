<?php
require_once __DIR__ . '/../includes/datos.php';

$titulo = 'Perfil';
$estilos = ['perfil'];
$scripts = ['perfil'];
$paginaActiva = 'perfil';

require __DIR__ . '/../includes/head.php';
?>

    <main class="tarjeta">
        <?php require __DIR__ . '/../includes/boton-inicio.php'; ?>

        <h1 class="visualmente-oculto">Perfil de @<?= e($usuarioActual['usuario']) ?></h1>

        <section class="perfil">
            <div class="perfil-cabecera">
                <div class="perfil-avatar" role="img" aria-label="Foto de perfil"></div>

                <div class="perfil-datos">
                    <ul class="estadisticas">
                        <li><span data-contador="<?= e($usuarioActual['amigos']) ?>"><?= e($usuarioActual['amigos']) ?></span> Amigos</li>
                        <li><span data-contador="<?= e($usuarioActual['entrenamientos']) ?>"><?= e($usuarioActual['entrenamientos']) ?></span> Entrenamientos</li>
                        <li><span data-contador="<?= e($usuarioActual['racha']) ?>"><?= e($usuarioActual['racha']) ?></span> Días de Racha</li>
                    </ul>

                    <button type="button" class="boton-morado boton-editar-perfil">EDITAR PERFIL</button>
                </div>

                <p class="perfil-usuario">@<?= e($usuarioActual['usuario']) ?></p>
            </div>

            <p class="perfil-descripcion"><?= e($usuarioActual['descripcion']) ?></p>
        </section>

        <h2 class="visualmente-oculto">Publicaciones</h2>
        <ul class="perfil-publicaciones">
<?php for ($i = 1; $i <= $usuarioActual['publicaciones']; $i++): ?>
            <li></li>
<?php endfor; ?>
        </ul>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
