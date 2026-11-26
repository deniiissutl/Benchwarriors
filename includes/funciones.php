<?php

/* Escapa texto antes de pintarlo en el HTML (evita XSS). */
function e($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/* Pinta los iconos de ejercicios de una rutina.
   $ejercicios es una lista de claves del array $iconos de abajo. */
function pintarIconosEjercicio(array $ejercicios)
{
    $iconos = [
        'mancuerna' => ['ej_dumbbell.svg', 'Mancuernas'],
        'pesa_rusa' => ['ej_kettlebell.svg', 'Pesa rusa'],
        'banco'     => ['ej_bench.svg', 'Banco'],
        'cardio'    => ['ej_pulse.svg', 'Cardio'],
        'tiempo'    => ['ej_timer.svg', 'Tiempo'],
    ];

    echo '<ul class="iconos-ejercicio">';
    foreach ($ejercicios as $ejercicio) {
        if (!isset($iconos[$ejercicio])) {
            continue;
        }
        [$archivo, $nombre] = $iconos[$ejercicio];
        echo '<li data-ejercicio="' . e($ejercicio) . '"><img src="../assets/img/iconos/' . e($archivo) . '" alt="' . e($nombre) . '" title="' . e($nombre) . '" width="26" height="26"></li>';
    }
    echo '</ul>';
}
