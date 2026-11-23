<?php
/* DATOS DE EJEMPLO
   Mientras no haya base de datos, todas las vistas leen de aquí.
   Cuando esté MySQL, se sustituye cada array por su consulta
   y las vistas no hace falta tocarlas.
*/

/* ---------- Usuario con sesión iniciada ---------- */
$usuarioActual = [
    'usuario'        => 'deniiiss.utl',
    'descripcion'    => 'Hola, soy Denis y esta es una prueba de descripción :)',
    'amigos'         => 21,
    'entrenamientos' => 76,
    'racha'          => 5,
    'publicaciones'  => 3,
];

/* ---------- Inicio ---------- */
$consejoDiario = '¡No te olvides de beber agua todos los días!';

$ultimasComidas = [
    'Salmón ahumado con fuet',
    'Tostada de aguacate',
];

/* Iconos posibles: mancuerna, pesa_rusa, banco, cardio, tiempo */
$ejerciciosBase = ['mancuerna', 'pesa_rusa', 'banco', 'cardio', 'tiempo'];

$ultimosEntrenamientos = [
    ['dia' => 1, 'ejercicios' => $ejerciciosBase],
    ['dia' => 2, 'ejercicios' => $ejerciciosBase],
];

/* ---------- Recetas ---------- */
$recetaDiaria = [
    'descripcion' => 'Disfruta de una jugosa pechuga de pollo a la parrilla sazonada con finas hierbas, acompañada de una ración de arroz integral y un vibrante salteado de brócoli, pimientos, judías verdes y tomates cherry.',
    'imagen'      => '../assets/img/recetas/receta_diaria.png',
    'enlace'      => '#',
];

$recetasUsuario = [
    [
        'descripcion' => 'Disfruta de una jugosa pechuga de pollo a la parrilla sazonada con finas hierbas, acompañada de una ración de arroz integral y un vibrante salteado de brócoli, pimientos, judías verdes y tomates cherry.',
        'imagen'      => '../assets/img/recetas/receta_usuario.png',
        'enlace'      => '#',
        'usuario'     => 'marcosllorente14',
    ],
];

/* ---------- Rutas de running ---------- */
$rutaDiaria = [
    'descripcion' => 'Ruta llana de 10 km entre Utiel y Requena por caminos rurales. Un trayecto tranquilo rodeado de viñedos, perfecto para desconectar al aire libre.',
    'imagen'      => '../assets/img/rutas/ruta_mapa.png',
    'maps'        => 'https://www.google.com/maps/dir/?api=1&origin=Utiel&destination=Requena&travelmode=walking',
];

$rutasUsuario = [
    [
        'descripcion' => 'Ruta 10/10 para salir a correr el fin de semana. La primera mitad tiene un poco de pendiente, pero luego es todo llano por pista de tierra; súper recomendada si buscas un entrenamiento tranquilo y sin cruzar apenas carreteras.',
        'imagen'      => '../assets/img/rutas/ruta_mapa.png',
        'maps'        => 'https://www.google.com/maps/search/?api=1&query=Requena',
        'usuario'     => 'marc_pubill',
    ],
];

/* ---------- Rutinas ---------- */
$rutinas = [
    ['dia' => 1, 'ejercicios' => $ejerciciosBase],
    ['dia' => 2, 'ejercicios' => $ejerciciosBase],
    ['dia' => 3, 'ejercicios' => $ejerciciosBase],
    ['dia' => 4, 'ejercicios' => $ejerciciosBase],
];

/* Ranking: 'tu' => true marca la fila del usuario actual */
$rankingAmigos = [
    ['usuario' => '@marcosllorente14'],
    ['usuario' => '@marc_pubill'],
    ['usuario' => '@koke6'],
    ['usuario' => 'tú', 'tu' => true],
];

$rankingGeneral = [
    ['usuario' => '@marcosllorente14'],
    ['usuario' => '@marc_pubill'],
    ['usuario' => '@koke6'],
    ['usuario' => 'tú', 'tu' => true],
];
