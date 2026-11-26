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

/* ---------- Recetas ----------
   Cada receta tiene un id (se usa en receta.php?id=...).
   'diaria' => true es la recomendación del día; las demás son de usuario.
*/
$recetas = [
    'pollo-arroz-verduras' => [
        'diaria'      => true,
        'titulo'      => 'Pollo a la parrilla con arroz integral y verduras',
        'descripcion' => 'Disfruta de una jugosa pechuga de pollo a la parrilla sazonada con finas hierbas, acompañada de una ración de arroz integral y un vibrante salteado de brócoli, pimientos, judías verdes y tomates cherry.',
        'imagen'      => '../assets/img/recetas/receta_diaria.png',
        'tiempo'      => '30 min',
        'raciones'    => 2,
        'dificultad'  => 'Fácil',
        'ingredientes' => [
            ['Pechuga de pollo', '300 g'],
            ['Arroz integral (en seco)', '120 g'],
            ['Brócoli', '150 g'],
            ['Pimiento rojo', '½ unidad'],
            ['Judías verdes', '100 g'],
            ['Tomates cherry', '100 g'],
            ['Aceite de oliva', '1 cda.'],
            ['Limón', '½ unidad'],
            ['Hierbas, sal y pimienta', 'Al gusto'],
        ],
        'nota_ingredientes' => 'Fresco, sencillo y equilibrado.',
        'intro_preparacion' => 'La base de un plato completo, paso a paso.',
        'pasos' => [
            ['Cuece el arroz integral', 'Enjuaga el arroz y cuécelo en agua con una pizca de sal durante 25–30 minutos, o según el envase. Escurre y reserva.'],
            ['Prepara las verduras', 'Lava y corta el brócoli, el pimiento y las judías. Saltéalos con la mitad del aceite durante 8–10 minutos. Añade los cherry al final.'],
            ['Cocina el pollo', 'Sazona con hierbas, sal, pimienta y unas gotas de limón. Cocina a la parrilla con el resto del aceite, 6–7 minutos por lado, hasta que esté bien hecho.'],
            ['Monta el plato y sirve', 'Reparte el arroz como base, añade las verduras y coloca la pechuga cortada encima. Termina con limón y sirve caliente.'],
        ],
    ],
    'poke-atun-aguacate' => [
        'usuario'     => 'marcosllorente14',
        'titulo'      => 'Poke bowl de atún, aguacate y edamame',
        'descripcion' => 'Un bol fresco y cargado de proteína: dados de atún marinado con soja y sésamo sobre arroz, con aguacate, edamame, zanahoria, cebolla morada y un toque de lima.',
        'imagen'      => '../assets/img/recetas/receta_usuario.png',
        'tiempo'      => '25 min',
        'raciones'    => 2,
        'dificultad'  => 'Fácil',
        'ingredientes' => [
            ['Atún fresco (apto para crudo)', '250 g'],
            ['Arroz para sushi (en seco)', '150 g'],
            ['Aguacate', '1 unidad'],
            ['Edamame pelado', '100 g'],
            ['Zanahoria', '1 unidad'],
            ['Cebolla morada', '¼ unidad'],
            ['Salsa de soja', '2 cdas.'],
            ['Sésamo', '1 cdta.'],
            ['Lima', '½ unidad'],
        ],
        'nota_ingredientes' => 'Usa atún previamente congelado si lo vas a comer crudo.',
        'intro_preparacion' => 'Listo en menos de media hora y sin apenas fuego.',
        'pasos' => [
            ['Cuece el arroz', 'Lava el arroz hasta que el agua salga clara y cuécelo según el envase. Déjalo templar.'],
            ['Marina el atún', 'Corta el atún en dados y mézclalo con la soja y el sésamo. Déjalo en la nevera mientras preparas el resto.'],
            ['Corta los acompañamientos', 'Corta el aguacate en dados, la zanahoria en tiras finas y la cebolla en juliana. Calienta el edamame un par de minutos.'],
            ['Monta el bol', 'Pon el arroz como base y reparte encima el atún y las verduras por secciones. Termina con unas gotas de lima.'],
        ],
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
