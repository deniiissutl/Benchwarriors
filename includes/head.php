<?php
/* Cabecera común de las vistas de la app.
   Antes de incluirla, cada vista define:
   - $titulo        → texto de la pestaña
   - $estilos       → array con el CSS propio de la vista (sin .css), puede ir vacío
   - $paginaActiva  → 'recetas' | 'rutas' | 'rutinas' | 'perfil' | '' (para el footer)
   - $scripts       → array con el JS propio de la vista (sin .js), opcional
*/
require_once __DIR__ . '/funciones.php';

$titulo = $titulo ?? 'Inicio';
$estilos = $estilos ?? [];
$scripts = $scripts ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bench Warriors - <?= e($titulo) ?></title>
    <link rel="icon" href="../assets/img/benchie/benchie_saluda.jpeg">
    <!-- Marca que hay JS antes de pintar (para las animaciones de entrada) -->
    <script>document.documentElement.classList.add('js');</script>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
<?php foreach ($estilos as $css): ?>
    <link rel="stylesheet" href="../assets/css/<?= e($css) ?>.css">
<?php endforeach; ?>
    <link rel="stylesheet" href="../assets/css/componentes.css">
    <link rel="stylesheet" href="../assets/css/animaciones.css">
    <script src="../assets/js/app.js" defer></script>
<?php foreach ($scripts as $js): ?>
    <script src="../assets/js/<?= e($js) ?>.js" defer></script>
<?php endforeach; ?>
</head>
<body>
