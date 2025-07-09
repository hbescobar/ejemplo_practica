// Este archivo contiene las funciones de validación para los formularios de la aplicación web

//Validamos que ninguna campo quede vacio
function validarCamposVacios(form) {
    let camposValidos = true; // Asumimos que todos los campos son válidos
    const inputs = form.querySelectorAll("input, select, textarea"); // Selecciona todos los campos del formulario

    inputs.forEach((input) => {
        const mensajeError = document.getElementById(`error${input.name}`); // Contenedor de error dinámico
        if (input.value.trim() === "" || input.value === null) {
            if (mensajeError) {
                mensajeError.textContent = "Este campo es obligatorio.";
            }
            input.classList.add("is-invalid");
            camposValidos = false; // Si hay un campo vacío, marcamos como inválido
        } else {
            if (mensajeError) {
                mensajeError.textContent = "";
            }
            input.classList.remove("is-invalid");
        }
    });

    return camposValidos; // Devuelve true si todos los campos están diligenciados
}

// Esta función valida el número de documento ingresado por el usuario
function validarNumDocum(input) {
    const regexNumDocum = /^[0-9]{8,10}$/; // permite 8 a 10 dígitos
    const mensajeError = document.getElementById("errorusu_numero_docu"); // Selecciona el contenedor del mensaje

    if (!regexNumDocum.test(input.value)) {
        mensajeError.textContent = "El número de documento no es válido. Debe tener entre 8 a 10 dígitos y debe ser numerico.";
        input.classList.add("is-invalid"); 
        return false; // Retorna false si el número de documento no es válido
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid"); 
        return true; // Retorna true si el número de documento es válido
    }
}

function validarNombre(input) {
    const regexNombre = /^[a-zA-ZÀ-ÿ\s]{1,40}$/; // Permite letras y espacios
    const mensajeError = document.getElementById("errorusu_nombre"); // Selecciona el contenedor del mensaje

    if (!regexNombre.test(input.value)) {
        mensajeError.textContent = "El nombre no es válido. No debe contener caracteres especiales.";
        input.classList.add("is-invalid"); 
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid"); 
        return true; // Retorna true si el nombre es válido
    }
}

function validarApellido(input) {
    const regexApellido = /^[a-zA-ZÀ-ÿ\s]{1,40}$/; // Permite letras y espacios
    const mensajeError = document.getElementById("errorusu_apellido"); // Selecciona el contenedor del mensaje

    if (!regexApellido.test(input.value)) {
        mensajeError.textContent = "El apellido no es válido. No debe contener caracteres especiales.";
        input.classList.add("is-invalid"); 
        return false; // Retorna false si el apellido no es válido
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid"); 
        return true; // Retorna true si el apellido es válido
    }
}

// la primera funcion valida el correo electronico
function validarCorreo(input) {
    const regexCorreo = /^[a-zA-Z0-9_.+-]+@(hotmail|outlook|gmail)\.com$/;
    const mensajeError = document.getElementById("errorusu_email"); // Selecciona el contenedor del mensaje

    if (!regexCorreo.test(input.value)) {
        mensajeError.textContent = "El correo no es válido. Introduce un correo electrónico válido.";
        input.classList.add("is-invalid"); 
        return false; // Retorna false si el correo no es válido
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid"); 
        return true; // Retorna true si el correo es válido
    }
}

function validarTelefono(input) {
    const regexTelefono = /^[0-9]{10}$/; // Permite 10 dígitos
    const mensajeError = document.getElementById("errorusu_telefono"); // Selecciona el contenedor del mensaje

    if (!regexTelefono.test(input.value)) {
        mensajeError.textContent = "El teléfono no es válido. Debe tener 10 dígitos y ser numérico.";
        input.classList.add("is-invalid"); 
        return false; // Retorna false si el teléfono no es válido
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid");
        return true; // Retorna true si el teléfono es válido 
    }
}

function validarDireccion(input) {
    const regexDireccion = /^[a-zA-ZÀ-ÿñÑ0-9\s,.\-#°/()]{1,100}$/; // Permite letras, números y algunos caracteres especiales
    const mensajeError = document.getElementById("errorusu_direccion"); // Selecciona el contenedor del mensaje

    if (!regexDireccion.test(input.value)) {
        mensajeError.textContent = "La dirección no es válida. No debe contener caracteres especiales.";
        input.classList.add("is-invalid"); 
        return false; // Retorna false si la dirección no es válida
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid"); 
        return true; // Retorna true si la dirección es válida
    }
}

function validarClave(input) {
    const regexClave = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Al menos 8 caracteres, al menos una letra y un número
    const mensajeError = document.getElementById("errorusu_clave"); // Selecciona el contenedor del mensaje

    if (!regexClave.test(input.value)) {
        mensajeError.textContent = "La contraseña no es válida. Debe tener al menos 8 caracteres, una letra y un número.sin caracteres especiales.";
        input.classList.add("is-invalid"); 
        return false; // Retorna false si la contraseña no es válida
    } else {
        mensajeError.textContent = ""; 
        input.classList.remove("is-invalid"); 
        return true; // Retorna true si la contraseña es válida
    }
    
}

function validarForm(event) {
    const form = event.target; // Obtiene el formulario actual
    const camposLlenos = validarCamposVacios(form); // Verifica que no haya campos vacíos

    // Obtiene los campos del formulario
    const correoInput = document.querySelector('input[name="usu_email"]');
    const numDocumInput = document.querySelector('input[name="usu_numero_docu"]');
    const nombreInput = document.querySelector('input[name="usu_nombre"]');
    const apellidoInput = document.querySelector('input[name="usu_apellido"]');
    const telefonoInput = document.querySelector('input[name="usu_telefono"]');
    const claveInput = document.querySelector('input[name="usu_clave"]');
    const direccionInput = document.querySelector('input[name="usu_direccion"]'); // Campo de dirección

    // Llama a las funciones de validación para cada campo
    const correoValido = validarCorreo(correoInput);
    const numDocumValido = validarNumDocum(numDocumInput);
    const nombreValido = validarNombre(nombreInput);
    const apellidoValido = validarApellido(apellidoInput);
    const telefonoValido = validarTelefono(telefonoInput);
    const claveValida = validarClave(claveInput);
    const direccionValida = validarDireccion(direccionInput); // Valida la dirección

    // Si alguna validación falla, evita el envío del formulario
    if (!camposLlenos || !correoValido || !numDocumValido || !nombreValido || !apellidoValido || !telefonoValido || !claveValida || !direccionValida) {
        event.preventDefault(); // Detiene el envío del formulario
        alert("Por favor, corrige los errores antes de enviar el formulario.");
        return false;
    }

    return true; // Permite el envío si todo está correcto
}