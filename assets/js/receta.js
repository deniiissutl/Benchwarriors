/* =========================================================
   RECETA (detalle)
   - Cambiar las raciones recalcula las cantidades
   - Pulsar un ingrediente lo tacha (ya lo tienes)
   - Pulsar el número de un paso lo marca como hecho
   ========================================================= */

(function () {
    'use strict';

    const seccion = document.querySelector('.receta-ingredientes');
    if (!seccion) return;

    const racionesBase = parseInt(seccion.dataset.raciones, 10) || 1;
    let raciones = racionesBase;

    /* ---------- Leer y escribir cantidades ---------- */
    const FRACCIONES = { '½': 0.5, '¼': 0.25, '¾': 0.75 };

    /* "300 g" → {n: 300, unidad: 'g'}  ·  "½ unidad" → {n: 0.5, unidad: 'unidad'}  ·  "Al gusto" → null */
    function leerCantidad(texto) {
        const m = texto.trim().match(/^(\d+(?:[.,]\d+)?)?\s*([½¼¾])?\s*(.*)$/);
        if (!m || (!m[1] && !m[2])) return null;
        let n = m[1] ? parseFloat(m[1].replace(',', '.')) : 0;
        if (m[2]) n += FRACCIONES[m[2]];
        return { n: n, unidad: m[3] };
    }

    function escribirCantidad(n, unidad) {
        /* Gramos y mililitros: redondeo a 5 */
        if (/^(g|ml)$/i.test(unidad)) {
            const redondeado = n >= 10 ? Math.round(n / 5) * 5 : Math.round(n);
            return Math.max(redondeado, 1) + ' ' + unidad;
        }

        /* Lo demás: redondeo a cuartos y uso ½, ¼, ¾ */
        const cuartos = Math.max(Math.round(n * 4) / 4, 0.25);
        const entero = Math.floor(cuartos);
        const resto = cuartos - entero;
        const fraccion = resto === 0.25 ? '¼' : resto === 0.5 ? '½' : resto === 0.75 ? '¾' : '';
        const numero = (entero ? String(entero) : '') + fraccion;

        let u = unidad;
        if (cuartos > 1) {
            u = u.replace(/^unidad$/, 'unidades').replace(/^cda\.$/, 'cdas.').replace(/^cdta\.$/, 'cdtas.');
        } else {
            u = u.replace(/^unidades$/, 'unidad').replace(/^cdas\.$/, 'cda.').replace(/^cdtas\.$/, 'cdta.');
        }
        return numero + ' ' + u;
    }

    /* Guardamos la cantidad original de cada ingrediente */
    const celdas = Array.from(seccion.querySelectorAll('tbody td')).map(function (td) {
        return { td: td, base: leerCantidad(td.textContent) };
    });

    function actualizar() {
        const factor = raciones / racionesBase;
        celdas.forEach(function (celda) {
            if (!celda.base) return;
            const nuevo = escribirCantidad(celda.base.n * factor, celda.base.unidad);
            if (celda.td.textContent !== nuevo) {
                celda.td.textContent = nuevo;
                celda.td.classList.remove('cambio');
                void celda.td.offsetWidth;
                celda.td.classList.add('cambio');
            }
        });

        const personas = raciones === 1 ? 'persona' : 'personas';
        salida.textContent = raciones;
        etiqueta.textContent = ' ' + personas;
        menos.disabled = raciones <= 1;
        mas.disabled = raciones >= 12;

        const dato = document.querySelector('.dato-raciones');
        if (dato) {
            dato.textContent = raciones + ' ' + personas;
            dato.classList.remove('cambio');
            void dato.offsetWidth;
            dato.classList.add('cambio');
        }
    }

    /* ---------- Control de raciones ---------- */
    const subtitulo = seccion.querySelector('.receta-sub');
    subtitulo.textContent = 'Cantidades para ';

    const stepper = BW.crear('span', 'stepper');
    const menos = BW.crear('button', '', '−');
    menos.type = 'button';
    menos.setAttribute('aria-label', 'Quitar una ración');
    const salida = BW.crear('output', '', raciones);
    salida.setAttribute('aria-live', 'polite');
    const mas = BW.crear('button', '', '+');
    mas.type = 'button';
    mas.setAttribute('aria-label', 'Añadir una ración');
    stepper.append(menos, salida, mas);

    const etiqueta = BW.crear('span');
    subtitulo.append(stepper, etiqueta);

    menos.addEventListener('click', function () { if (raciones > 1) { raciones--; actualizar(); } });
    mas.addEventListener('click', function () { if (raciones < 12) { raciones++; actualizar(); } });
    actualizar();

    /* Las animaciones iniciales no deben resaltar nada */
    document.querySelectorAll('.cambio').forEach(function (el) { el.classList.remove('cambio'); });
    seccion.addEventListener('animationend', function (e) { e.target.classList.remove('cambio'); });

    /* ---------- Tachar ingredientes ---------- */
    seccion.querySelectorAll('tbody tr').forEach(function (fila) {
        fila.tabIndex = 0;
        fila.title = 'Marcar como preparado';

        const alternar = function () {
            fila.classList.toggle('tachado');
        };
        fila.addEventListener('click', alternar);
        fila.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                alternar();
            }
        });
    });

    const nota = BW.crear('p', 'receta-ayuda', 'Toca un ingrediente para tacharlo y el número de un paso para marcarlo como hecho.');
    seccion.appendChild(nota);

    /* ---------- Marcar pasos como hechos ---------- */
    const pasos = Array.from(document.querySelectorAll('.receta-pasos li'));

    pasos.forEach(function (paso, i) {
        const numero = paso.querySelector('.paso-numero');
        const boton = BW.crear('button', 'paso-numero', String(i + 1));
        boton.type = 'button';
        boton.setAttribute('aria-pressed', 'false');
        boton.setAttribute('aria-label', 'Marcar el paso ' + (i + 1) + ' como hecho');
        numero.replaceWith(boton);

        boton.addEventListener('click', function () {
            const hecho = paso.classList.toggle('hecho');
            boton.textContent = hecho ? '✓' : String(i + 1);
            boton.setAttribute('aria-pressed', hecho ? 'true' : 'false');

            if (hecho && pasos.every(function (p) { return p.classList.contains('hecho'); })) {
                BW.toast('¡Receta terminada! Que aproveche');
            }
        });
    });
})();
