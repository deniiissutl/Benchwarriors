<?php
/* Barra de navegación inferior (footer).
   Marca como activo el icono que coincide con $paginaActiva. */
$paginaActiva = $paginaActiva ?? '';

$enlacesFooter = [
    'recetas' => ['href' => 'recetas.php', 'icono' => 'food', 'texto' => 'Recetas'],
    'rutas'   => ['href' => 'rutas.php', 'icono' => 'shoe', 'texto' => 'Rutas de running'],
    'rutinas' => ['href' => 'rutinas.php', 'icono' => 'dumbbell', 'texto' => 'Rutinas de entrenamiento'],
    'perfil'  => ['href' => 'perfil.php', 'icono' => 'user', 'texto' => 'Perfil'],
];
?>
    <footer>
        <nav class="footer-group" aria-label="Navegación principal">
            <ul>
<?php foreach ($enlacesFooter as $clave => $enlace):
    $activo = ($clave === $paginaActiva);
    $icono = $enlace['icono'] . ($activo ? '_activo' : '') . '.svg';
?>
                <li>
                    <a href="<?= e($enlace['href']) ?>"<?= $activo ? ' class="activo" aria-current="page"' : '' ?> title="<?= e($enlace['texto']) ?>">
                        <img src="../assets/img/iconos/<?= e($icono) ?>" alt="<?= e($enlace['texto']) ?>" width="30" height="30">
                    </a>
                </li>
<?php endforeach; ?>
            </ul>
        </nav>
    </footer>
</body>
</html>
