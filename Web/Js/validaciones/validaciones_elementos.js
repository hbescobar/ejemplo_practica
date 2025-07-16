//============================================
// VALIDACIONES PARA ELEMENTOS DEVOLUTIVOS
//============================================

/* ──────────────────────────────────────────────
Valida que los inputs/ selects requeridos NO estén
vacíos, pero **ignora** los que pertenezcan a un
bloque (#grupoDevolutivo o #grupoNoDevolutivo)
que está oculto con la clase d-none.
────────────────────────────────────────────── */
function validarCamposVacios(form) {
    let valido = true;

    /* toma todos los campos con atributo required */
    const inputs = form.querySelectorAll('[required]');

    inputs.forEach(input => {

        /* 1. Si está deshabilitado => ignóralo.             */
        if (input.disabled) return;

        /* 2. Si su bloque padre está oculto (d‑none) => ignóralo. */
        const grupoDev = input.closest('#grupoDevolutivo');
        const grupoNo  = input.closest('#grupoNoDevolutivo');

        if ( (grupoDev && grupoDev.classList.contains('d-none')) ||
            (grupoNo  && grupoNo.classList.contains('d-none')) ) {
            return;
        }

        /* 3. Validar realmente el campo */
        const errorBox = document.getElementById('error' + input.name);
        const vacio    = input.value.trim() === '' || input.value === '0';

        if (vacio) {
            errorBox && (errorBox.textContent = 'Este campo es obligatorio.');
            input.classList.add('is-invalid');
            valido = false;
        } else {
            errorBox && (errorBox.textContent = '');
            input.classList.remove('is-invalid');
        }
    });

    return valido;          // true si todo está OK
}

//validacion placa de elemento
function validarPlaca(input) {
    if (input.disabled) return true;
    const regexPlaca = /^[a-zA-Z0-9\- ]+$/; // Permite letras, números, guiones y espacios pero no permite caracteres especiales
    const mensajeError = document.getElementById("errorelem_placa"); // Selecciona el contenedor del mensaje

    if (!regexPlaca.test(input.value)) {
        mensajeError.textContent = "La placa no es valida. debe tener numeros y letras";
        input.classList.add("is-invalid");
        return false; // Retorna false si la dirección no es válida
    } else {
        mensajeError.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si la dirección es válida
    }
}

//Validacion serie del elemento 
function validarSerieElemento(input) {
    if (input.disabled) return true;
    const regexValidarElem = /^[a-zA-Z0-9\- ]+$/; // Permite letras, números, guiones y espacios pero no permite caracteres especiales
    const mensajeErro = document.getElementById("errorelem_serie");// Selecciona el contenedor del mensaje

    if (!regexValidarElem.test(input.value)) {
        mensajeErro.textContent = "El codigo del elemento no es valido";
        input.classList.add("is-invalid");
        return false; // Retorna false si la dirección no es válida
    } else {
        mensajeErro.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si la dirección es válida
    }
}

//validacion codigo elementos
function validarCodElem(input) {
    const regexValidarElem = /^[a-zA-Z0-9\- ]+$/; // Permite letras, números y algunos caracteres especiales
    const mensajeErro = document.getElementById("errorelem_codigo");// Selecciona el contenedor del mensaje

    if (!regexValidarElem.test(input.value)) {
        mensajeErro.textContent = "El codigo del elemento no es valido";
        input.classList.add("is-invalid");
        return false; // Retorna false si la dirección no es válida
    } else {
        mensajeErro.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si la dirección es válida
    }
}

//validacion Nombre del elemento
function validarNombreElem(input) {
    const regexNombre = /^[a-zA-ZÀ-ÿ\s]{1,40}$/; // Permite de 1 a 40 letras y espacios
    const mensajeError = document.getElementById("errorelem_nombre"); // Selecciona el contenedor del mensaje.

    if (!regexNombre.test(input.value)) {
        mensajeError.textContent = "El nombre no es válido. No debe contener caracteres especiales.";
        input.classList.add("is-invalid");
        return false;
    } else {
        mensajeError.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si el nombre es válido
    }
}


// ──────────────────────────────────────────────
//  Modelo  (campo OPCIONAL)
// ──────────────────────────────────────────────
function validarModeloElem(input) {

    /*Si el input NO está activo, ya es válido */
    if (input.disabled) return true;

    const valor = input.value.trim();
    const msg   = document.getElementById('errorelem_modelo');

    /*Si está vacío → válido (es opcional) */
    if (valor === '') {
        msg.textContent = '';
        input.classList.remove('is-invalid');
        return true;
    }

    /*Solo si trae algo lo validamos               *
     *    letras, números, espacios, guión, máx. 40    */
    const regex = /^[a-zA-ZÀ-ÿ0-9\s-]{1,40}$/;

    if (!regex.test(valor)) {
        msg.textContent =
        'El modelo no es válido. Solo letras, números y espacios (máx. 40).';
        input.classList.add('is-invalid');
        return false;
    }

    /* 4. Valor correcto*/
    msg.textContent = '';
    input.classList.remove('is-invalid');
    return true;
}
//============================================
// VALIDACIONES PARA ELEMENTOS NO DEVOLUTIVOS
//============================================

//validacion codigo elementos NO DEVOLUTIVO
function validarCodElemNoDevo(input) {
    const regexValidarElem = /^[a-zA-Z0-9\- ]+$/; // Permite letras, números y algunos caracteres especiales
    const mensajeErro = document.getElementById("errorelem_codigoNoDevo");// Selecciona el contenedor del mensaje

    if (!regexValidarElem.test(input.value)) {
        mensajeErro.textContent = "El codigo del elemento no es valido";
        input.classList.add("is-invalid");
        return false; // Retorna false si la dirección no es válida
    } else {
        mensajeErro.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si la dirección es válida
    }
}

//validacion Nombre del elemento
function validarNombreElemNoDevo(input) {
    const regexNombre = /^[a-zA-ZÀ-ÿ\s]{1,40}$/; // Permite de 1 a 40 letras y espacios
    const mensajeError = document.getElementById("errorelem_nombre_NoDevo"); // Selecciona el contenedor del mensaje.

    if (!regexNombre.test(input.value)) {
        mensajeError.textContent = "El nombre no es válido. No debe contener caracteres especiales.";
        input.classList.add("is-invalid");
        return false;
    } else {
        mensajeError.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si el nombre es válido
    }
}

//validacion cantidad
function validarCant(input) {
    if (input.disabled) return true;

    const mensajeError = document.getElementById("errorelem_cantidad");
    const valor = parseInt(input.value);

    if (isNaN(valor) || valor <= 0) {
        mensajeError.textContent = "Ingrese un número válido mayor a 0.";
        input.classList.add("is-invalid");
    } else {
        mensajeError.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

// Validación para el textarea de recomendaciones
// Permite letras, números, espacios y los signos de puntuación . , ; : ( ) ! ?
function validarRecomendaciones(textarea) {
    const tipoElemento = document.getElementById("tipoElementos")?.value;
    const errorId = (tipoElemento === "1") ? "errorRecomDev" : "errorRecomNo";
    const error = document.getElementById(errorId);

    const valor = textarea.value.trim();

    if (valor === '') {
        textarea.classList.remove("is-invalid");
        if (error) error.textContent = '';
        return true; // es opcional, no obligatorio
    }

    const regex = /^[a-zA-Z0-9À-ÿ\s.,;:()¡!¿?"'-]{1,250}$/;

    if (!regex.test(valor)) {
        textarea.classList.add("is-invalid");
        if (error) error.textContent = "Solo se permiten letras, números y signos de puntuación válidos.";
        return false;
    }

    textarea.classList.remove("is-invalid");
    if (error) error.textContent = '';
    return true;
}

function validarElementos(event) {
    const form = event.target;
    const tipo = document.getElementById('tipoElementos').value;   
    let   todoOK = validarCamposVacios(form);                      

    // ── toma los bloques de elementos ───────────────────────────
    const bloqueDev = document.getElementById('grupoDevolutivo');
    const bloqueNo  = document.getElementById('grupoNoDevolutivo');

    // ── validar según el tipo de elemento ───────────────────
    if (tipo === '1') {  // ── DEVOLUTIVO ──
        const placa   = bloqueDev.querySelector('input[name="elem_placa"]');
        const serie   = bloqueDev.querySelector('input[name="elem_serie"]');
        const codigo  = bloqueDev.querySelector('input[name="elem_codigo"]');
        const nombre  = bloqueDev.querySelector('input[name="elem_nombre"]');
        const modelo  = bloqueDev.querySelector('input[name="elem_modelo"]');

        todoOK = todoOK && validarPlaca(placa);
        todoOK = todoOK && validarSerieElemento(serie);
        todoOK = todoOK && validarCodElem(codigo);
        todoOK = todoOK && validarNombreElem(nombre);
        todoOK = todoOK && validarModeloElem(modelo);

    } else if (tipo === '2') {  // ── NO DEVOLUTIVO ──
        const codigo   = bloqueNo.querySelector('input[name="elem_codigo"]');
        const nombre   = bloqueNo.querySelector('input[name="elem_nombre"]');
        /* const cantidad = bloqueNo.querySelector('input[name="elem_cantidad"]'); */

        todoOK = todoOK && validarCodElemNoDevo(codigo);
        todoOK = todoOK && validarNombreElemNoDevo(nombre);
        /* todoOK = todoOK && validarCant(cantidad); */
        // la unidad de medida ya la revisa validarCamposVacios()
    }

    /* validar el textarea de recomendaciones que esté visible */
    const recom = form.querySelector('textarea[name="recomendaciones"]:not([disabled])');
    if (recom) {
        const resultado = validarRecomendaciones(recom);
        todoOK = resultado && todoOK;  // Asegura que se acumule correctamente
    }

    /* ── detener envío si hay errores ───────────────────────── */
    if (!todoOK) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos o inválidos',
            text: 'Por favor, corrige los campos marcados en rojo.',
            confirmButtonColor: '#3085d6',
        });
        return false;
    } 
    return true;
}