/* =========================================================
   INICIO: pedir otro consejo a Benchie
   ========================================================= */

(function () {
    'use strict';

    const consejo = document.querySelector('.consejo');
    if (!consejo) return;

    let consejos;
    try {
        consejos = JSON.parse(consejo.dataset.consejos);
    } catch (error) {
        return;
    }
    if (!Array.isArray(consejos) || consejos.length < 2) return;

    let indice = parseInt(consejo.dataset.indice, 10) || 0;
    const texto = consejo.querySelector('.consejo-texto');
    const benchie = consejo.querySelector('img');

    const boton = BW.crear('button', 'otro-consejo');
    boton.type = 'button';
    boton.innerHTML =
        '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' +
        '<path d="M21 12a9 9 0 1 1-2.6-6.4"/><path d="M21 3v6h-6"/></svg>' +
        '<span>Otro consejo</span>';
    texto.closest('p').after(boton);

    function siguienteConsejo() {
        indice = (indice + 1) % consejos.length;

        boton.classList.remove('girando');
        void boton.offsetWidth;
        boton.classList.add('girando');

        benchie.classList.remove('saltar');
        void benchie.offsetWidth;
        benchie.classList.add('saltar');

        texto.classList.add('cambiando');
        setTimeout(function () {
            texto.textContent = consejos[indice];
            texto.classList.remove('cambiando');
        }, BW.reducirMovimiento ? 0 : 250);
    }

    boton.addEventListener('click', siguienteConsejo);

    /* Pulsar a Benchie también cambia el consejo */
    benchie.style.cursor = 'pointer';
    benchie.addEventListener('click', siguienteConsejo);
    benchie.addEventListener('animationend', function (e) {
        if (e.animationName === 'bw-saltar') benchie.classList.remove('saltar');
    });
    boton.addEventListener('transitionend', function () { boton.classList.remove('girando'); });
})();
