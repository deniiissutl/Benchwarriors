<?php
/* Detalle de una receta: receta.php?id=pollo-arroz-verduras */
require_once __DIR__ . '/../includes/datos.php';

$id = $_GET['id'] ?? '';
$receta = $recetas[$id] ?? null;

$titulo = $receta ? $receta['titulo'] : 'Receta no encontrada';
$estilos = ['receta'];
$scripts = ['receta'];
$paginaActiva = 'recetas';

if (!$receta) {
    http_response_code(404);
}

require __DIR__ . '/../includes/head.php';
?>

    <main class="tarjeta">
        <div class="receta-barra">
            <p class="titulo-pagina">Recetas fit:</p>
            <a href="recetas.php" class="volver">Volver a recetas</a>
            <?php require __DIR__ . '/../includes/boton-inicio.php'; ?>
        </div>

<?php if (!$receta): ?>
        <section class="receta-vacia">
            <h1>Receta no encontrada</h1>
            <p>Puede que se haya borrado o que el enlace no sea correcto.</p>
            <a href="recetas.php" class="boton-oscuro">Ver recetas</a>
        </section>
<?php else: ?>
        <!-- CABECERA: foto, título, descripción y datos rápidos -->
        <section class="receta-cabecera">
            <img src="<?= e($receta['imagen']) ?>" alt="<?= e($receta['titulo']) ?>" class="receta-foto" width="374" height="204">

            <div class="receta-resumen">
                <h1><?= e($receta['titulo']) ?></h1>
                <p class="receta-descripcion"><?= e($receta['descripcion']) ?></p>

                <dl class="receta-datos">
                    <div>
                        <dt>Tiempo total</dt>
                        <dd><?= e($receta['tiempo']) ?></dd>
                    </div>
                    <div>
                        <dt>Raciones</dt>
                        <dd class="dato-raciones"><?= e($receta['raciones']) ?> <?= $receta['raciones'] == 1 ? 'persona' : 'personas' ?></dd>
                    </div>
                    <div>
                        <dt>Dificultad</dt>
                        <dd><?= e($receta['dificultad']) ?></dd>
                    </div>
                </dl>

<?php if (!empty($receta['usuario'])): ?>
                <div class="autor receta-autor">
                    <img src="../assets/img/iconos/avatar_usuario.png" alt="" class="autor-avatar" width="50" height="50">
                    <span class="autor-nombre">@<?= e($receta['usuario']) ?></span>
                </div>
<?php endif; ?>
            </div>
        </section>

        <div class="receta-cuerpo">
            <!-- INGREDIENTES -->
            <section class="receta-ingredientes" data-raciones="<?= e($receta['raciones']) ?>">
                <h2>Ingredientes</h2>
                <p class="receta-sub">Cantidades para <?= e($receta['raciones']) ?> <?= $receta['raciones'] == 1 ? 'persona' : 'personas' ?></p>

                <table>
                    <tbody>
<?php foreach ($receta['ingredientes'] as [$ingrediente, $cantidad]): ?>
                        <tr>
                            <th scope="row"><?= e($ingrediente) ?></th>
                            <td><?= e($cantidad) ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>

<?php if (!empty($receta['nota_ingredientes'])): ?>
                <p class="receta-nota"><?= e($receta['nota_ingredientes']) ?></p>
<?php endif; ?>
            </section>

            <!-- PREPARACIÓN -->
            <section class="receta-preparacion">
                <h2>Preparación</h2>
<?php if (!empty($receta['intro_preparacion'])): ?>
                <p class="receta-sub"><?= e($receta['intro_preparacion']) ?></p>
<?php endif; ?>

                <ol class="receta-pasos">
<?php foreach ($receta['pasos'] as $n => [$tituloPaso, $textoPaso]): ?>
                    <li>
                        <span class="paso-numero"><?= $n + 1 ?></span>
                        <div>
                            <h3><?= e($tituloPaso) ?></h3>
                            <p><?= e($textoPaso) ?></p>
                        </div>
                    </li>
<?php endforeach; ?>
                </ol>
            </section>
        </div>
<?php endif; ?>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
