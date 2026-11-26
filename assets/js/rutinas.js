/* =========================================================
   RUTINAS
   - INICIAR: cronómetro, lista de ejercicios para ir marcando,
     barra de progreso y descanso de 60 s
   - EDITAR: elegir los ejercicios de cada día (se guarda en el navegador)
   ========================================================= */

(function () {
    'use strict';

    const DESCANSO_SEGUNDOS = 60;

    function formatoTiempo(segundos) {
        const m = Math.floor(segundos / 60);
        const s = segundos % 60;
        return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }

    function crearCasilla(clave, marcada) {
        const ejercicio = BW.ejercicios[clave];
        const li = BW.crear('li');
        const label = BW.crear('label');
        const input = BW.crear('input');
        input.type = 'checkbox';
        input.value = clave;
        input.checked = !!marcada;
        const img = BW.crear('img');
        img.src = BW.rutaIconos + ejercicio.icono;
        img.alt = '';
        img.width = 26;
        img.height = 26;
        label.append(input, img, BW.crear('span', '', ejercicio.nombre));
        li.appendChild(label);
        return li;
    }

    /* ---------------------------------------------------------
       INICIAR ENTRENAMIENTO
       --------------------------------------------------------- */
    function iniciar(fila) {
        const dia = fila.dataset.dia;
        const ejercicios = BW.ejerciciosDelDia(fila);

        BW.modal('Día ' + dia + ': entrenamiento', function (cuerpo, modal) {
            cuerpo.classList.add('entreno');
            cuerpo.innerHTML =
                '<div class="crono">' +
                    '<span class="crono-tiempo">00:00</span>' +
                    '<span class="crono-etiqueta">Tiempo total</span>' +
                '</div>' +
                '<div class="progreso" role="progressbar" aria-valuemin="0" aria-valuemax="' + ejercicios.length + '" aria-valuenow="0">' +
                    '<div class="progreso-barra"></div>' +
                '</div>' +
                '<p class="progreso-texto"></p>' +
                '<ul class="lista-check"></ul>' +
                '<div class="descanso" hidden>' +
                    '<div class="anillo"><span></span></div>' +
                    '<p>Descansa y respira, la siguiente serie empieza enseguida.</p>' +
                '</div>' +
                '<div class="modal-acciones">' +
                    '<button type="button" class="boton-blanco accion-pausa">PAUSAR</button>' +
                    '<button type="button" class="boton-blanco accion-descanso">DESCANSO ' + DESCANSO_SEGUNDOS + ' s</button>' +
                    '<button type="button" class="boton-morado accion-terminar">TERMINAR</button>' +
                '</div>';

            const crono = cuerpo.querySelector('.crono');
            const tiempo = cuerpo.querySelector('.crono-tiempo');
            const lista = cuerpo.querySelector('.lista-check');
            const progreso = cuerpo.querySelector('.progreso');
            const barra = cuerpo.querySelector('.progreso-barra');
            const textoProgreso = cuerpo.querySelector('.progreso-texto');
            const descanso = cuerpo.querySelector('.descanso');
            const anillo = descanso.querySelector('.anillo');
            const textoAnillo = anillo.querySelector('span');
            const botonPausa = cuerpo.querySelector('.accion-pausa');
            const botonDescanso = cuerpo.querySelector('.accion-descanso');

            ejercicios.forEach(function (clave) { lista.appendChild(crearCasilla(clave, false)); });

            /* --- Cronómetro (cuenta el tiempo real, aunque la pestaña se duerma) --- */
            let acumulado = 0;
            let inicio = Date.now();
            let pausado = false;

            const segundosTotales = function () {
                return Math.floor((acumulado + (pausado ? 0 : Date.now() - inicio)) / 1000);
            };

            const intervalo = setInterval(function () {
                tiempo.textContent = formatoTiempo(segundosTotales());
            }, 250);

            botonPausa.addEventListener('click', function () {
                if (pausado) {
                    inicio = Date.now();
                } else {
                    acumulado += Date.now() - inicio;
                }
                pausado = !pausado;
                crono.classList.toggle('pausado', pausado);
                botonPausa.textContent = pausado ? 'SEGUIR' : 'PAUSAR';
            });

            /* --- Progreso --- */
            function actualizarProgreso() {
                const hechos = lista.querySelectorAll('input:checked').length;
                barra.style.width = (hechos / ejercicios.length * 100) + '%';
                progreso.setAttribute('aria-valuenow', hechos);
                textoProgreso.textContent = hechos + ' de ' + ejercicios.length + ' ejercicios';
                if (hechos === ejercicios.length) {
                    BW.toast('¡Todos los ejercicios hechos! Ya puedes terminar');
                }
            }
            lista.addEventListener('change', actualizarProgreso);
            actualizarProgreso();

            /* --- Descanso con cuenta atrás --- */
            let intervaloDescanso = null;

            function pararDescanso() {
                clearInterval(intervaloDescanso);
                intervaloDescanso = null;
                descanso.hidden = true;
                botonDescanso.textContent = 'DESCANSO ' + DESCANSO_SEGUNDOS + ' s';
            }

            botonDescanso.addEventListener('click', function () {
                if (intervaloDescanso) {
                    pararDescanso();
                    return;
                }
                const fin = Date.now() + DESCANSO_SEGUNDOS * 1000;
                descanso.hidden = false;
                botonDescanso.textContent = 'SALTAR DESCANSO';

                const tic = function () {
                    const quedan = Math.max(0, Math.ceil((fin - Date.now()) / 1000));
                    textoAnillo.textContent = quedan;
                    anillo.style.setProperty('--p', quedan / DESCANSO_SEGUNDOS);
                    if (quedan === 0) {
                        pararDescanso();
                        if (navigator.vibrate) navigator.vibrate(200);
                        BW.toast('¡Descanso terminado, a por la siguiente serie!');
                    }
                };
                tic();
                intervaloDescanso = setInterval(tic, 250);
            });

            /* --- Terminar --- */
            cuerpo.querySelector('.accion-terminar').addEventListener('click', function () {
                const segundos = segundosTotales();
                const hechos = lista.querySelectorAll('input:checked').length;
                BW.guardar('ultimo_entreno', {
                    dia: dia,
                    segundos: segundos,
                    ejercicios: hechos,
                    fecha: new Date().toISOString()
                });
                modal.cerrar();
                BW.toast('Día ' + dia + ' completado en ' + formatoTiempo(segundos) + ' (' + hechos + '/' + ejercicios.length + ' ejercicios)');
            });

            modal.alCerrar(function () {
                clearInterval(intervalo);
                clearInterval(intervaloDescanso);
            });
        });
    }

    /* ---------------------------------------------------------
       EDITAR RUTINA
       --------------------------------------------------------- */
    function editar(fila) {
        const dia = fila.dataset.dia;
        const actuales = BW.ejerciciosDelDia(fila);

        BW.modal('Editar día ' + dia, function (cuerpo, modal) {
            cuerpo.appendChild(BW.crear('p', 'modal-texto', 'Elige los ejercicios que haces este día.'));

            const lista = BW.crear('ul', 'lista-check');
            Object.keys(BW.ejercicios).forEach(function (clave) {
                lista.appendChild(crearCasilla(clave, actuales.indexOf(clave) !== -1));
            });
            cuerpo.appendChild(lista);

            const acciones = BW.crear('div', 'modal-acciones');
            const cancelar = BW.crear('button', 'boton-blanco', 'CANCELAR');
            cancelar.type = 'button';
            const guardar = BW.crear('button', 'boton-morado', 'GUARDAR');
            guardar.type = 'button';
            acciones.append(cancelar, guardar);
            cuerpo.appendChild(acciones);

            cancelar.addEventListener('click', modal.cerrar);

            guardar.addEventListener('click', function () {
                const elegidos = Array.from(lista.querySelectorAll('input:checked')).map(function (i) { return i.value; });
                if (!elegidos.length) {
                    BW.toast('Elige al menos un ejercicio', 'error');
                    return;
                }
                BW.guardar('rutina_' + dia, elegidos);

                const iconos = fila.querySelector('.iconos-ejercicio');
                BW.pintarEjercicios(iconos, elegidos);
                iconos.classList.remove('recien-editada');
                void iconos.offsetWidth;
                iconos.classList.add('recien-editada');

                modal.cerrar();
                BW.toast('Rutina del día ' + dia + ' guardada');
            });
        });
    }

    /* ---------------------------------------------------------
       Eventos (delegados en la lista)
       --------------------------------------------------------- */
    const listaRutinas = document.querySelector('.lista-rutinas');
    if (!listaRutinas) return;

    listaRutinas.addEventListener('click', function (e) {
        const fila = e.target.closest('.rutina');
        if (!fila) return;
        if (e.target.closest('.boton-iniciar')) iniciar(fila);
        if (e.target.closest('.boton-editar')) editar(fila);
    });

    /* Aviso del último entrenamiento guardado */
    const ultimo = BW.leer('ultimo_entreno');
    if (ultimo && ultimo.dia) {
        const fila = listaRutinas.querySelector('.rutina[data-dia="' + ultimo.dia + '"]');
        if (fila) {
            fila.classList.add('ultima');
            fila.title = 'Último entrenamiento: ' + formatoTiempo(ultimo.segundos);
        }
    }
})();
