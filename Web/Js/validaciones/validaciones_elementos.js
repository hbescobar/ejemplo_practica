//============================================
// VALIDACIONES PARA ELEMENTOS DEVOLUTIVOS
//============================================

//La funcion validarCamposVacios se encargar de validar los campos vacios del formulario
function validarCamposVacios(form) {
    let camposValidos = true;
    const inputs = form.querySelectorAll("input[required], select[required], textarea[required]");

    inputs.forEach((input) => {
        if (input.disabled) return;

        const mensajeError = document.getElementById(`error${input.name}`);
        if (input.value.trim() === "" || input.value === null) {
            if (mensajeError) {
                mensajeError.textContent = "Este campo es obligatorio.";
            }
            input.classList.add("is-invalid");
            camposValidos = false;
        } else {
            if (mensajeError) {
                mensajeError.textContent = "";
            }
            input.classList.remove("is-invalid");
        }
    });
    return camposValidos;
}

//validacion placa de elemento
function validarPlaca(input) {
    if (input.disabled) return true; // <--- Agrega esto
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

//Validacion modelo del elemento
function validarModeloElem(input) {
    if (input.disabled) return true;
    const regexModelo = /^[a-zA-ZÀ-ÿ0-9\s]{1,40}$/; // Permite de 1 a 40 letras, números y espacios
    const mensajeError = document.getElementById("errorelem_modelo"); // Selecciona el contenedor del mensaje

    if (!regexModelo.test(input.value)) {
        mensajeError.textContent = "El modelo no es válido. No debe contener caracteres especiales.";
        input.classList.add("is-invalid");
    } else {
        mensajeError.textContent = "";
        input.classList.remove("is-invalid");
        return true; // Retorna true si el modelo es válido
    }
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

/* function validarElementos(event) {
    const form = event.target; // Obtiene el formulario actual
    const camposLlenos = validarCamposVacios(form); // Verifica que no haya campos vacíos

    //obtiene los inputs del formulario
    const placaInput = document.querySelector('input[name="elem_placa"]');
    const serieInput = document.querySelector('input[name="elem_serie"]');
    const codElemInput = document.querySelector('input[name="elem_codigo"]');
    const nombreElemInput = document.querySelector('input[name="elem_nombre"]');
    const modeloInput = document.querySelector('input[name="elem_modelo"]');
    const cantidadInput = document.querySelector('input[name="elem_cantidad"]');
    const unidadMedidaSelect = document.querySelector('select[name="elem_unidad_id"]');

    // Llama a las funciones de validación para cada campo
    const placaValido = validarPlaca(placaInput);
    const serieValido = validarElemento(serieInput);
    const codElemValido = validarCodElem(codElemInput);
    const nombreElemValido = validarNombreElem(nombreElemInput);
    const modeloValido = validarModeloElem(modeloInput);
    const cantidadValido = validarCant(cantidadInput);
    const unidadMedidaValido = validarUnidadMedida(unidadMedidaSelect);

    // Si alguna validación falla, evita el envío del formulario
    if (!camposLlenos || !placaValido || !serieValido || !codElemValido || !nombreElemValido || !modeloValido || !cantidadValido || !unidadMedidaValido) {
        event.preventDefault(); // Detiene el envío del formulario
        alert("Por favor, corrige los errores antes de enviar el formulario.");
        return false;
    }
    return true; // Permite el envío si todo está correcto
} */

function validarElementos(event) {
    const form = event.target;                // formulario que dispara el submit
    const camposLlenos = validarCamposVacios(form);   // verifica requeridos

    /* Captura de inputs */
    const placaInput      = form.querySelector('[name="elem_placa"]');
    const serieInput      = form.querySelector('[name="elem_serie"]');
    const codElemInput    = form.querySelector('[name="elem_codigo"]');
    const nombreElemInput = form.querySelector('[name="elem_nombre"]');
    const modeloInput     = form.querySelector('[name="elem_modelo"]');
    const cantidadInput   = form.querySelector('[name="elem_cantidad"]');

    /* Llamadas a las funciones de validación (nombres exactos) */
    const placaValida     = validarPlaca(placaInput);
    const serieValida     = validarSerieElemento(serieInput);     // ← nombre corregido
    const codigoValido    = validarCodElem(codElemInput);
    const nombreValido    = validarNombreElem(nombreElemInput);
    const modeloValido    = validarModeloElem(modeloInput);
    const cantidadValida  = validarCant(cantidadInput);

    /* Si algo falla, bloquea el envío */
    if (!(camposLlenos && placaValida && serieValida && codigoValido &&
          nombreValido && modeloValido && cantidadValida)) {
        event.preventDefault();                     // detiene submit
        alert("Por favor, corrige los errores antes de enviar el formulario.");
        return false;
    }
    return true;                                    // todo OK, permite submit
}
