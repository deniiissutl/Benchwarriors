<?php
require_once __DIR__ . '/../includes/datos.php';

$titulo = 'Rutinas';
$estilos = ['rutinas'];
$paginaActiva = 'rutinas';

/* Pinta una lista de ranking (amigos o general) */
function pintarRanking(array $ranking)
{
    echo '<ol>';
    foreach ($ranking as $i => $fila) {
        $esTu = !empty($fila['tu']);
        echo '<li' . ($esTu ? ' class="tu"' : '') . '>';
        echo '<span class="posicion">' . ($i + 1) . '</span>';
        echo '<span class="avatar" aria-hidden="true"></span>';
        echo '<span class="nombre">' . e($fila['usuario']) . '</span>';
        echo '</li>';
    }
    echo '</ol>';
}

require __DIR__ . '/../includes/head.php';
?>

    <main class="tarjeta">
        <?php require __DIR__ . '/../includes/boton-inicio.php'; ?>

        <h1 class="titulo-pagina">Rutinas diarias:</h1>

        <div class="rutinas-layout">
            <!-- TUS RUTINAS -->
            <section class="col-rutinas">
                <h2 class="titulo-seccion">Tus rutinas</h2>

                <ul class="lista-rutinas">
<?php foreach ($rutinas as $rutina): ?>
                    <li class="rutina">
                        <span class="dia">DÍA <?= e($rutina['dia']) ?>:</span>
                        <?php pintarIconosEjercicio($rutina['ejercicios']); ?>
                        <a href="#" class="boton-morado">INICIAR</a>
                        <a href="#" class="boton-blanco">EDITAR</a>
                    </li>
<?php endforeach; ?>
                </ul>
            </section>

            <!-- RANKING -->
            <section class="col-ranking">
                <h2 class="titulo-seccion">Ranking:</h2>

                <div class="ranking">
                    <h3>ENTRE AMIGOS</h3>
                    <?php pintarRanking($rankingAmigos); ?>

                    <hr>

                    <h3>GENERAL</h3>
                    <?php pintarRanking($rankingGeneral); ?>
                </div>
            </section>
        </div>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
