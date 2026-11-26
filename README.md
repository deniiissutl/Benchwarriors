# Benchwarriors
El Proyecto Intermodular de dos estudiantes de Desarrollo de Aplicaciones Web.

App web de gimnasio: recetas fit, rutas de running, rutinas de entrenamiento con ranking entre amigos y perfil de usuario. Hecha en PHP + HTML + CSS a partir del diseño de Figma.

## Cómo arrancarla

Con PHP instalado, desde la raíz del proyecto:

```bash
php -S localhost:8000
```

y abre <http://localhost:8000> (redirige al login). También funciona dentro de `htdocs` de XAMPP.

## Estructura

```
Benchwarriors/
├── index.php              → redirige a vistas/login.php
├── vistas/                → una página por pantalla
│   ├── login.php
│   ├── register.php
│   ├── resetpass.php
│   ├── main.php           → inicio (consejo de Benchie, últimas comidas y entrenamientos)
│   ├── recetas.php
│   ├── receta.php         → detalle de una receta (receta.php?id=...), al pulsar "Ver más"
│   ├── rutas.php
│   ├── rutinas.php        → rutinas por día + ranking
│   └── perfil.php
├── includes/              → piezas compartidas
│   ├── head.php           → <head> común (recibe $titulo, $estilos, $paginaActiva)
│   ├── footer.php         → barra de navegación inferior (marca el icono activo)
│   ├── boton-inicio.php   → icono de la casa arriba a la derecha
│   ├── funciones.php      → e() para escapar HTML, iconos de ejercicios
│   └── datos.php          → datos de ejemplo hasta tener la base de datos
└── assets/
    ├── css/
    │   ├── base.css       → fuente, colores del Figma y reseteo (todas las páginas)
    │   ├── app.css        → tarjeta, títulos, botones, publicaciones (vistas con footer)
    │   ├── footer.css
    │   ├── login.css      → login, registro y recuperar contraseña
    │   ├── inicio.css
│   ├── receta.css
    │   ├── rutinas.css
    │   └── perfil.css
    ├── fonts/             → Instrument Sans (la fuente del diseño)
    └── img/
        ├── benchie/
        ├── iconos/
        ├── recetas/
        └── rutas/
```

## Cómo añadir una vista nueva

```php
<?php
require_once __DIR__ . '/../includes/datos.php';

$titulo = 'Mi vista';
$estilos = ['mi-vista'];      // assets/css/mi-vista.css (o [] si no hace falta)
$paginaActiva = 'recetas';    // icono del footer marcado: recetas | rutas | rutinas | perfil | ''

require __DIR__ . '/../includes/head.php';
?>
    <main class="tarjeta">
        <?php require __DIR__ . '/../includes/boton-inicio.php'; ?>
        <h1 class="titulo-pagina">Título:</h1>
        ...
    </main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
```

## Pendiente

- Conectar `includes/datos.php` y los formularios de login/registro con MySQL.
- Páginas de los botones "Iniciar", "Editar" y "Editar perfil".
