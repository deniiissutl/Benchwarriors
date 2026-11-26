/* =========================================================
   BENCH WARRIORS - JS común a todas las páginas
   - Transición suave al cambiar de página
   - Aparición escalonada de elementos al hacer scroll
   - Onda al pulsar botones
   - Contadores animados
   - Utilidades: BW.toast(), BW.modal(), BW.guardar(), BW.leer()
   - Ejercicios de las rutinas guardados en el navegador
   ========================================================= */

(function () {
    'use strict';

    const html = document.documentElement;
    const reducirMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Objeto global con las utilidades que usan los demás scripts */
    const BW = (window.BW = {});
    BW.reducirMovimiento = reducirMovimiento;

    /* ---------------------------------------------------------
       ALMACENAMIENTO (localStorage) con prefijo bw_
       Mientras no haya base de datos, los cambios se guardan aquí.
       --------------------------------------------------------- */
    BW.guardar = function (clave, valor) {
        try {
            localStorage.setItem('bw_' + clave, JSON.stringify(valor));
            return true;
        } catch (error) {
            return false;   // modo privado o almacenamiento lleno
        }
    };

    BW.leer = function (clave, porDefecto = null) {
        try {
            const valor = localStorage.getItem('bw_' + clave);
            return valor === null ? porDefecto : JSON.parse(valor);
        } catch (error) {
            return porDefecto;
        }
    };

    /* ---------------------------------------------------------
       TOAST: aviso flotante que desaparece solo
       BW.toast('Rutina guardada')  /  BW.toast('Error', 'error')
       --------------------------------------------------------- */
    BW.toast = function (mensaje, tipo = 'ok') {
        let contenedor = document.querySelector('.toasts');
        if (!contenedor) {
            contenedor = document.createElement('div');
            contenedor.className = 'toasts';
            contenedor.setAttribute('role', 'status');
            contenedor.setAttribute('aria-live', 'polite');
            document.body.appendChild(contenedor);
        }

        const toast = document.createElement('div');
        toast.className = 'toast toast-' + tipo;
        toast.textContent = mensaje;
        contenedor.appendChild(toast);

        setTimeout(function () {
            toast.classList.add('saliendo');
            setTimeout(function () { toast.remove(); }, 350);
        }, 3200);
    };

    /* ---------------------------------------------------------
       MODAL con <dialog>: se cierra con la X, Escape o clic fuera.
       const modal = BW.modal('Título', function (cuerpo, modal) { ... });
       modal.cerrar();  modal.alCerrar(fn);
       --------------------------------------------------------- */
    BW.modal = function (titulo, construir) {
        const dialog = document.createElement('dialog');
        dialog.className = 'modal';
        dialog.innerHTML =
            '<div class="modal-caja">' +
                '<div class="modal-cabecera">' +
                    '<h2></h2>' +
                    '<button type="button" class="modal-cerrar" aria-label="Cerrar">&times;</button>' +
                '</div>' +
                '<div class="modal-cuerpo"></div>' +
            '</div>';
        dialog.querySelector('h2').textContent = titulo;
        dialog.setAttribute('aria-label', titulo);

        const caja = dialog.querySelector('.modal-caja');
        const cuerpo = dialog.querySelector('.modal-cuerpo');
        const enfoquePrevio = document.activeElement;
        let funcionAlCerrar = null;
        let cerrado = false;

        const modal = {
            dialog: dialog,
            cuerpo: cuerpo,
            alCerrar: function (fn) { funcionAlCerrar = fn; },
            cerrar: function () {
                if (cerrado) return;
                cerrado = true;
                if (funcionAlCerrar) funcionAlCerrar();

                const terminar = function () {
                    if (!dialog.isConnected) return;
                    dialog.close();
                    dialog.remove();
                    if (enfoquePrevio && enfoquePrevio.focus) enfoquePrevio.focus();
                };

                if (reducirMovimiento) {
                    terminar();
                    return;
                }
                dialog.classList.add('cerrando');
                caja.addEventListener('animationend', function (e) {
                    if (e.animationName === 'bw-modal-sale') terminar();
                });
                setTimeout(terminar, 400);   // por si no llega animationend
            }
        };

        dialog.querySelector('.modal-cerrar').addEventListener('click', modal.cerrar);

        /* Escape: cerramos con animación en vez de golpe */
        dialog.addEventListener('cancel', function (e) {
            e.preventDefault();
            modal.cerrar();
        });

        /* Clic en el fondo oscuro */
        dialog.addEventListener('click', function (e) {
            if (e.target === dialog) modal.cerrar();
        });

        construir(cuerpo, modal);
        document.body.appendChild(dialog);
        dialog.showModal();
        return modal;
    };

    /* Crea un elemento rápido: BW.crear('button', 'clase', 'texto') */
    BW.crear = function (etiqueta, clase, texto) {
        const el = document.createElement(etiqueta);
        if (clase) el.className = clase;
        if (texto !== undefined) el.textContent = texto;
        return el;
    };

    /* ---------------------------------------------------------
       EJERCICIOS de las rutinas
       Los iconos de cada día pueden editarse en Rutinas y se
       guardan en el navegador (bw_rutina_1, bw_rutina_2…).
       --------------------------------------------------------- */
    BW.ejercicios = {
        mancuerna: { nombre: 'Mancuernas', icono: 'ej_dumbbell.svg' },
        pesa_rusa: { nombre: 'Pesa rusa', icono: 'ej_kettlebell.svg' },
        banco:     { nombre: 'Banco', icono: 'ej_bench.svg' },
        cardio:    { nombre: 'Cardio', icono: 'ej_pulse.svg' },
        tiempo:    { nombre: 'Tiempo', icono: 'ej_timer.svg' }
    };

    BW.rutaIconos = '../assets/img/iconos/';

    /* Ejercicios de un día: los guardados o los que pintó PHP */
    BW.ejerciciosDelDia = function (contenedor) {
        const guardados = BW.leer('rutina_' + contenedor.dataset.dia);
        if (Array.isArray(guardados) && guardados.length) return guardados;
        return Array.from(contenedor.querySelectorAll('.iconos-ejercicio li')).map(function (li) {
            return li.dataset.ejercicio;
        });
    };

    BW.pintarEjercicios = function (lista, claves) {
        lista.innerHTML = '';
        claves.forEach(function (clave, i) {
            const ejercicio = BW.ejercicios[clave];
            if (!ejercicio) return;
            const li = BW.crear('li');
            li.dataset.ejercicio = clave;
            li.style.setProperty('--i', i);
            const img = BW.crear('img');
            img.src = BW.rutaIconos + ejercicio.icono;
            img.alt = ejercicio.nombre;
            img.title = ejercicio.nombre;
            img.width = 26;
            img.height = 26;
            li.appendChild(img);
            lista.appendChild(li);
        });
    };

    /* Aplica las rutinas guardadas en Inicio y en Rutinas */
    document.querySelectorAll('[data-dia]').forEach(function (fila) {
        const guardados = BW.leer('rutina_' + fila.dataset.dia);
        const lista = fila.querySelector('.iconos-ejercicio');
        if (lista && Array.isArray(guardados) && guardados.length) {
            BW.pintarEjercicios(lista, guardados);
        }
    });

    /* ---------------------------------------------------------
       APARICIÓN ESCALONADA al entrar en pantalla
       --------------------------------------------------------- */
    const elementosRevelar = [
        '.titulo-pagina', '.titulo-seccion', '.receta-barra .volver',
        '.publicacion', '.caja', '.fila-gris',
        '.rutina', '.ranking h3', '.ranking li', '.ranking hr',
        '.receta-foto', '.receta-resumen', '.receta-ingredientes', '.receta-preparacion > h2',
        '.receta-preparacion > .receta-sub', '.receta-pasos li', '.receta-vacia',
        '.perfil-avatar', '.perfil-datos', '.perfil-usuario', '.perfil-descripcion', '.perfil-publicaciones li',
        '.logo-container', '.login-title', '.input-group', '.forgot-password', '.button-group'
    ].join(',');

    function prepararRevelado() {
        const elementos = Array.from(document.querySelectorAll(elementosRevelar));

        if (reducirMovimiento || !('IntersectionObserver' in window)) {
            elementos.forEach(function (el) {
                if (el.matches('.ranking li.tu')) el.classList.add('animada');
            });
            return;
        }

        elementos.forEach(function (el) { el.classList.add('revelar'); });

        const observador = new IntersectionObserver(function (entradas) {
            /* Los que entran a la vez aparecen uno detrás de otro */
            const visibles = entradas
                .filter(function (e) { return e.isIntersecting; })
                .sort(function (a, b) { return a.boundingClientRect.top - b.boundingClientRect.top; });

            visibles.forEach(function (entrada, i) {
                const el = entrada.target;
                el.style.setProperty('--retraso', Math.min(i * 60, 600) + 'ms');
                el.classList.add('visible');
                if (el.matches('.ranking li.tu')) el.classList.add('animada');
                observador.unobserve(el);

                /* Al acabar, quitamos las clases para que el elemento
                   recupere sus propias transiciones (hover, etc.) */
                const limpiar = function (e) {
                    if (e.target !== el || e.propertyName !== 'transform') return;
                    el.classList.remove('revelar', 'visible');
                    el.style.removeProperty('--retraso');
                    el.removeEventListener('transitionend', limpiar);
                };
                el.addEventListener('transitionend', limpiar);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -5% 0px' });

        elementos.forEach(function (el) { observador.observe(el); });
    }

    /* ---------------------------------------------------------
       TRANSICIÓN ENTRE PÁGINAS
       Al pulsar un enlace interno, la página se desvanece y luego navega.
       --------------------------------------------------------- */
    document.addEventListener('click', function (e) {
        const enlace = e.target.closest('a[href]');
        if (!enlace || e.defaultPrevented) return;
        if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        if ((enlace.target && enlace.target !== '_self') || enlace.hasAttribute('download')) return;

        const href = enlace.getAttribute('href');
        if (!href || href.charAt(0) === '#') return;

        const url = new URL(enlace.href, location.href);
        if (url.origin !== location.origin) return;
        if (reducirMovimiento) return;

        e.preventDefault();
        html.classList.add('saliendo');
        setTimeout(function () { location.href = url.href; }, 200);
    });

    /* Si se vuelve atrás con el navegador, la página no debe quedar invisible */
    window.addEventListener('pageshow', function () {
        html.classList.remove('saliendo');
    });

    /* ---------------------------------------------------------
       ONDA al pulsar botones
       --------------------------------------------------------- */
    document.addEventListener('pointerdown', function (e) {
        if (reducirMovimiento) return;
        const boton = e.target.closest('.boton-oscuro, .boton-morado, .boton-blanco, .btn, .footer-group li a');
        if (!boton) return;

        const caja = boton.getBoundingClientRect();
        const tamano = Math.max(caja.width, caja.height) * 2;
        const onda = BW.crear('span', 'onda');
        onda.style.width = onda.style.height = tamano + 'px';
        onda.style.left = (e.clientX - caja.left - tamano / 2) + 'px';
        onda.style.top = (e.clientY - caja.top - tamano / 2) + 'px';
        boton.appendChild(onda);
        onda.addEventListener('animationend', function () { onda.remove(); });
    });

    /* ---------------------------------------------------------
       CONTADORES ANIMADOS: <span data-contador="76">76</span>
       --------------------------------------------------------- */
    BW.animarNumero = function (el, fin, duracion = 1100) {
        if (reducirMovimiento) {
            el.textContent = fin;
            return;
        }
        const inicio = performance.now();
        const paso = function (ahora) {
            const t = Math.min((ahora - inicio) / duracion, 1);
            const suavizado = 1 - Math.pow(1 - t, 3);   // ease-out cúbico
            el.textContent = Math.round(fin * suavizado);
            if (t < 1) requestAnimationFrame(paso);
        };
        requestAnimationFrame(paso);
    };

    function prepararContadores() {
        document.querySelectorAll('[data-contador]').forEach(function (el) {
            const fin = parseInt(el.dataset.contador, 10);
            if (isNaN(fin)) return;
            el.textContent = reducirMovimiento ? fin : 0;
            setTimeout(function () { BW.animarNumero(el, fin); }, 250);
        });
    }

    /* ---------------------------------------------------------
       ARRANQUE
       --------------------------------------------------------- */
    prepararRevelado();
    prepararContadores();

    /* Doble requestAnimationFrame: el navegador pinta primero el estado
       oculto y después hace la transición de entrada */
    requestAnimationFrame(function () {
        requestAnimationFrame(function () { html.classList.add('listo'); });
    });
})();
