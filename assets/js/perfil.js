/* =========================================================
   PERFIL: editar foto y descripción
   La foto se reduce a 320 px antes de guardarla en el navegador.
   ========================================================= */

(function () {
    'use strict';

    const MAX_DESCRIPCION = 160;

    const avatar = document.querySelector('.perfil-avatar');
    const descripcion = document.querySelector('.perfil-descripcion');
    const boton = document.querySelector('.boton-editar-perfil');
    if (!avatar || !descripcion || !boton) return;

    /* ---------- Aplicar lo guardado ---------- */
    function aplicar(perfil) {
        if (perfil.avatar) avatar.style.backgroundImage = 'url("' + perfil.avatar + '")';
        if (typeof perfil.descripcion === 'string' && perfil.descripcion.trim()) {
            descripcion.textContent = perfil.descripcion;
        }
    }
    aplicar(BW.leer('perfil', {}));

    /* ---------- Reducir la imagen con un canvas ---------- */
    function reducirImagen(archivo) {
        return new Promise(function (resolver, rechazar) {
            const lector = new FileReader();
            lector.onerror = rechazar;
            lector.onload = function () {
                const img = new Image();
                img.onerror = rechazar;
                img.onload = function () {
                    const lado = 320;
                    const canvas = document.createElement('canvas');
                    canvas.width = canvas.height = lado;
                    /* Recorte cuadrado centrado */
                    const corte = Math.min(img.width, img.height);
                    const x = (img.width - corte) / 2;
                    const y = (img.height - corte) / 2;
                    canvas.getContext('2d').drawImage(img, x, y, corte, corte, 0, 0, lado, lado);
                    resolver(canvas.toDataURL('image/jpeg', 0.85));
                };
                img.src = lector.result;
            };
            lector.readAsDataURL(archivo);
        });
    }

    /* ---------- Modal de edición ---------- */
    boton.addEventListener('click', function () {
        const guardado = BW.leer('perfil', {});
        let nuevaFoto = guardado.avatar || null;

        BW.modal('Editar perfil', function (cuerpo, modal) {
            cuerpo.innerHTML =
                '<div class="editar-avatar">' +
                    '<div class="editar-avatar-preview" role="img" aria-label="Vista previa de la foto"></div>' +
                    '<div>' +
                        '<input type="file" id="foto-perfil" class="visualmente-oculto" accept="image/*">' +
                        '<label class="boton-blanco" for="foto-perfil">CAMBIAR FOTO</label>' +
                    '</div>' +
                '</div>' +
                '<div class="campo-texto">' +
                    '<label for="descripcion-perfil">Descripción</label>' +
                    '<textarea id="descripcion-perfil" maxlength="' + MAX_DESCRIPCION + '"></textarea>' +
                    '<p class="contador-caracteres"></p>' +
                '</div>' +
                '<div class="modal-acciones">' +
                    '<button type="button" class="boton-blanco accion-cancelar">CANCELAR</button>' +
                    '<button type="button" class="boton-morado accion-guardar">GUARDAR</button>' +
                '</div>';

            const preview = cuerpo.querySelector('.editar-avatar-preview');
            const inputFoto = cuerpo.querySelector('#foto-perfil');
            const textarea = cuerpo.querySelector('#descripcion-perfil');
            const contador = cuerpo.querySelector('.contador-caracteres');

            if (nuevaFoto) preview.style.backgroundImage = 'url("' + nuevaFoto + '")';
            textarea.value = descripcion.textContent.trim();

            const contar = function () {
                contador.textContent = textarea.value.length + ' / ' + MAX_DESCRIPCION;
            };
            textarea.addEventListener('input', contar);
            contar();

            inputFoto.addEventListener('change', function () {
                const archivo = inputFoto.files[0];
                if (!archivo) return;
                if (!archivo.type.startsWith('image/')) {
                    BW.toast('El archivo tiene que ser una imagen', 'error');
                    return;
                }
                if (archivo.size > 10 * 1024 * 1024) {
                    BW.toast('La imagen pesa demasiado (máx. 10 MB)', 'error');
                    return;
                }
                reducirImagen(archivo).then(function (dataUrl) {
                    nuevaFoto = dataUrl;
                    preview.style.backgroundImage = 'url("' + dataUrl + '")';
                    preview.classList.remove('nueva');
                    void preview.offsetWidth;
                    preview.classList.add('nueva');
                }).catch(function () {
                    BW.toast('No se ha podido leer la imagen', 'error');
                });
            });

            cuerpo.querySelector('.accion-cancelar').addEventListener('click', modal.cerrar);

            cuerpo.querySelector('.accion-guardar').addEventListener('click', function () {
                const perfil = {
                    avatar: nuevaFoto,
                    descripcion: textarea.value.trim()
                };
                if (!BW.guardar('perfil', perfil)) {
                    BW.toast('No se ha podido guardar (¿navegación privada?)', 'error');
                    return;
                }
                aplicar(perfil);
                modal.cerrar();
                BW.toast('Perfil actualizado');
            });

            setTimeout(function () { textarea.focus(); }, 50);
        });
    });
})();
