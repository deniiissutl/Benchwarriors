/* =========================================================
   FORMULARIOS: login, registro y cambiar contraseña
   - Validación mientras se escribe (el servidor sigue validando)
   - Botón para ver/ocultar la contraseña
   - Medidor de fuerza de la contraseña nueva
   - La tarjeta tiembla si se intenta enviar con errores
   ========================================================= */

(function () {
    'use strict';

    const form = document.querySelector('.login-form');
    if (!form) return;

    const $ = function (id) { return form.querySelector('#' + id); };

    /* Con JS validamos nosotros (mensajes propios); sin JS sigue el "required" del navegador */
    form.noValidate = true;

    /* Qué formulario es */
    const modo = $('rncontrasena') ? 'reset' : ($('email') ? 'registro' : 'login');

    const emailValido = function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim()); };

    /* Reglas por campo: devuelven '' si está bien o el mensaje de error */
    const reglas = {
        login: {
            usuario: function (v) { return v.trim() ? '' : 'Escribe tu usuario'; },
            contrasena: function (v) { return v ? '' : 'Escribe tu contraseña'; }
        },
        registro: {
            usuario: function (v) { return v.trim().length >= 3 ? '' : 'El usuario debe tener al menos 3 caracteres'; },
            email: function (v) { return emailValido(v) ? '' : 'Introduce un correo válido'; },
            contrasena: function (v) { return v.length >= 8 ? '' : 'La contraseña debe tener al menos 8 caracteres'; },
            ncontrasena: function (v) {
                if (!v) return 'Repite la contraseña';
                return v === $('contrasena').value ? '' : 'Las contraseñas no coinciden';
            }
        },
        reset: {
            email: function (v) { return emailValido(v) ? '' : 'Introduce un correo válido'; },
            contrasena: function (v) { return v ? '' : 'Escribe tu contraseña actual'; },
            ncontrasena: function (v) {
                if (v.length < 8) return 'La nueva contraseña debe tener al menos 8 caracteres';
                return v !== $('contrasena').value ? '' : 'La nueva contraseña no puede ser igual a la actual';
            },
            rncontrasena: function (v) {
                if (!v) return 'Repite la nueva contraseña';
                return v === $('ncontrasena').value ? '' : 'Las contraseñas no coinciden';
            }
        }
    }[modo];

    /* Campos que dependen de otro: al cambiar uno, se revalida el otro */
    const dependientes = {
        contrasena: ['ncontrasena'],
        ncontrasena: ['rncontrasena']
    };

    const tocados = new Set();

    /* ---------- Mensaje de error bajo cada campo ---------- */
    Object.keys(reglas).forEach(function (id) {
        const input = $(id);
        if (!input) return;
        const error = document.createElement('p');
        error.className = 'campo-error';
        error.id = 'error-' + id;
        error.setAttribute('aria-live', 'polite');
        input.closest('.input-group').appendChild(error);
        input.setAttribute('aria-describedby', error.id);
    });

    function validar(id) {
        const input = $(id);
        if (!input || !reglas[id]) return true;
        const mensaje = reglas[id](input.value);
        const grupo = input.closest('.input-group');
        const error = grupo.querySelector('.campo-error');

        grupo.classList.toggle('invalido', !!mensaje);
        grupo.classList.toggle('valido', !mensaje && input.value !== '');
        input.setAttribute('aria-invalid', mensaje ? 'true' : 'false');
        if (mensaje) error.textContent = mensaje;
        error.classList.toggle('visible', !!mensaje);
        return !mensaje;
    }

    Object.keys(reglas).forEach(function (id) {
        const input = $(id);
        if (!input) return;

        /* Se valida al salir del campo y, a partir de ahí, mientras se escribe */
        input.addEventListener('blur', function () {
            if (input.value !== '') tocados.add(id);
            if (tocados.has(id)) validar(id);
        });

        input.addEventListener('input', function () {
            if (tocados.has(id)) validar(id);
            (dependientes[id] || []).forEach(function (otro) {
                if (tocados.has(otro)) validar(otro);
            });
        });
    });

    /* ---------- Ver / ocultar contraseña ---------- */
    const ojoAbierto = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>';
    const ojoCerrado = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3l18 18"/><path d="M10.6 5.1A10.4 10.4 0 0 1 12 5c6.5 0 10 7 10 7a17.6 17.6 0 0 1-3.2 4.1M6.6 6.6C3.8 8.4 2 12 2 12s3.5 7 10 7a9.7 9.7 0 0 0 5.4-1.6"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>';

    form.querySelectorAll('input[type="password"]').forEach(function (input) {
        const envoltorio = document.createElement('span');
        envoltorio.className = 'campo-password';
        input.parentNode.insertBefore(envoltorio, input);
        envoltorio.appendChild(input);

        const boton = document.createElement('button');
        boton.type = 'button';
        boton.className = 'ver-password';
        boton.innerHTML = ojoAbierto;
        boton.setAttribute('aria-label', 'Mostrar contraseña');
        envoltorio.appendChild(boton);

        boton.addEventListener('click', function () {
            const oculta = input.type === 'password';
            input.type = oculta ? 'text' : 'password';
            boton.innerHTML = oculta ? ojoCerrado : ojoAbierto;
            boton.setAttribute('aria-label', oculta ? 'Ocultar contraseña' : 'Mostrar contraseña');
            input.focus();
        });
    });

    /* ---------- Medidor de fuerza ---------- */
    const campoFuerza = modo === 'registro' ? $('contrasena') : (modo === 'reset' ? $('ncontrasena') : null);

    if (campoFuerza) {
        const medidor = document.createElement('div');
        medidor.className = 'fuerza';
        medidor.dataset.nivel = '0';
        medidor.innerHTML =
            '<div class="fuerza-barras" aria-hidden="true"><span></span><span></span><span></span><span></span></div>' +
            '<span class="fuerza-texto"></span>';
        campoFuerza.closest('.input-group').insertBefore(medidor, campoFuerza.closest('.input-group').querySelector('.campo-error'));
        const texto = medidor.querySelector('.fuerza-texto');
        const nombres = ['', 'Débil', 'Media', 'Buena', 'Fuerte'];

        campoFuerza.addEventListener('input', function () {
            const v = campoFuerza.value;
            let puntos = 0;
            if (v.length >= 8) puntos++;
            if (v.length >= 12) puntos++;
            if (/[a-z]/.test(v) && /[A-Z]/.test(v)) puntos++;
            if (/\d/.test(v)) puntos++;
            if (/[^A-Za-z0-9]/.test(v)) puntos++;

            let nivel = 0;
            if (v) nivel = v.length < 8 ? 1 : Math.min(4, puntos);
            medidor.dataset.nivel = nivel;
            texto.textContent = nombres[nivel];
        });
    }

    /* ---------- Envío ---------- */
    const tarjeta = form.closest('.login-card');
    const botonEnviar = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
        let primerError = null;
        Object.keys(reglas).forEach(function (id) {
            tocados.add(id);
            if (!validar(id) && !primerError) primerError = $(id);
        });

        if (primerError) {
            e.preventDefault();
            tarjeta.classList.remove('temblar');
            void tarjeta.offsetWidth;          // reinicia la animación
            tarjeta.classList.add('temblar');
            primerError.focus();
            return;
        }

        botonEnviar.classList.add('cargando');
        botonEnviar.setAttribute('aria-busy', 'true');
    });

    if (tarjeta) {
        tarjeta.addEventListener('animationend', function () { tarjeta.classList.remove('temblar'); });
    }
})();
