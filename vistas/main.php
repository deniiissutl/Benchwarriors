<?php
require_once __DIR__ . '/../includes/datos.php';

$titulo = 'Inicio';
$estilos = ['inicio'];
$paginaActiva = '';

require __DIR__ . '/../includes/head.php';
?>

    <main class="panel-inicio">
        <!-- CONSEJO DIARIO -->
        <section class="caja caja-consejo">
            <h1 class="titulo-seccion">Consejo diario de Benchie</h1>

            <div class="consejo">
                <img src="../assets/img/benchie/benchie_consejo.png" alt="Benchie, la mascota de Bench Warriors" width="232" height="228">
                <p><strong>Benchie</strong>: <?= e($consejoDiario) ?></p>
            </div>
        </section>

        <!-- ÚLTIMAS COMIDAS -->
        <section class="caja caja-comidas">
            <h2 class="titulo-seccion">Últimas comidas</h2>

            <ul class="lista-filas lista-comidas">
<?php foreach ($ultimasComidas as $comida): ?>
                <li>
                    <a href="recetas.php" class="fila-gris fila-comida">
                        <span><?= e($comida) ?></span>
                        <img src="../assets/img/iconos/food.svg" alt="" width="30" height="30">
                    </a>
                </li>
<?php endforeach; ?>
            </ul>
        </section>

        <!-- ÚLTIMOS ENTRENAMIENTOS -->
        <section class="caja caja-entrenamientos">
            <h2 class="titulo-seccion">Últimos entrenamientos</h2>

            <ul class="lista-filas lista-entrenamientos">
<?php foreach ($ultimosEntrenamientos as $entreno): ?>
                <li>
                    <a href="rutinas.php" class="fila-gris">
                        <span class="dia">Día <?= e($entreno['dia']) ?>:</span>
                        <?php pintarIconosEjercicio($entreno['ejercicios']); ?>
                    </a>
                </li>
<?php endforeach; ?>
            </ul>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
