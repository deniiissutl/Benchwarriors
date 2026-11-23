<?php
/* Cabecera común de las vistas de la app.
   Antes de incluirla, cada vista define:
   - $titulo        → texto de la pestaña
   - $estilos       → array con el CSS propio de la vista (sin .css), puede ir vacío
   - $paginaActiva  → 'recetas' | 'rutas' | 'rutinas' | 'perfil' | '' (para el footer)
*/
require_once __DIR__ . '/funciones.php';

$titulo = $titulo ?? 'Inicio';
$estilos = $estilos ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bench Warriors - <?= e($titulo) ?></title>
    <link rel="icon" href="../assets/img/benchie/benchie_saluda.jpeg">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
<?php foreach ($estilos as $css): ?>
    <link rel="stylesheet" href="../assets/css/<?= e($css) ?>.css">
<?php endforeach; ?>
</head>
<body>
