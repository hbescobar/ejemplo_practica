// =======================================
//FUNCIONES DE VALIDACIÓN PARA MARCAS
// =======================================
function validarNombreMarca(input) {
    const errorDiv = document.getElementById('error_marca_nombre');
    const valor = input.value.trim();

    // Limpiar errores anteriores
    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    // Solo letras, números y espacios (sin símbolos raros)
    const regex = /^[a-zA-ZÀ-ÿ0-9\s+()-.,]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre de la marca no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras y números. No uses símbolos como #, ?, %, etc.";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarDescripcionMarca(textarea) {
    const errorDiv = document.getElementById('error_marca_descripcion');
    const valor = textarea.value.trim();

    // Limpiar errores anteriores
    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    // Si está vacío, no validar nada (porque es opcional)
    if (valor === "") return true;

    // Solo letras (mayús/minús con tildes) y espacios
    const regex = /^[a-zA-ZÀ-ÿ0-9\s,.()+-]+$/;

    if (!regex.test(valor)) {
        errorDiv.textContent = "La descripción solo puede contener letras y espacios. No se permiten símbolos.";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarMarca(event) {
    const nombreInput = document.getElementById('marca_nombre');
    const descripcionInput = document.getElementById('marca_descripcion');

    const nombreValido = validarNombreMarca(nombreInput);
    const descripcionValida = validarDescripcionMarca(descripcionInput);

    if (!nombreValido || !descripcionValida ||
        nombreInput.classList.contains("is-invalid") ||
        descripcionInput.classList.contains("is-invalid")) {
        
        event.preventDefault(); // Evita que se envíe
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de guardar la marca.'
        });
        return false;
    }

    return true; // Si todo está bien, permite el envío
}

// =======================================
//FUNCIONES DE VALIDACIÓN PARA EDITAR MARCAS
// =======================================
function validarNombreMarcaEditar(input) {
    const errorDiv = document.getElementById('error_marca_nombre');
    const valor = input.value.trim();

    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s+()-.,]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre de la marca no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras y números. No uses símbolos como #, ?, %, etc.";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarDescripcionMarcaEditar(textarea) {
    const errorDiv = document.getElementById('error_marca_descripcion');
    const valor = textarea.value.trim();

    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    if (valor === "") return true;

    const regex = /^[a-zA-ZÀ-ÿ0-9\s,.()+-]+$/
    if (!regex.test(valor)) {
        errorDiv.textContent = "La descripción solo puede contener letras y espacios. No se permiten símbolos.";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarEditarMarca(event) {
    const nombreInput = document.getElementById('marca_nombre');
    const descripcionInput = document.getElementById('marca_descripcion');

    const nombreValido = validarNombreMarcaEditar(nombreInput);
    const descripcionValida = validarDescripcionMarcaEditar(descripcionInput);

    if (!nombreValido || !descripcionValida ||
        nombreInput.classList.contains("is-invalid") ||
        descripcionInput.classList.contains("is-invalid")) {

        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de actualizar la marca.'
        });
        return false;
    }

    return true;
}


// =======================================
//FUNCIONES DE VALIDACIÓN PARA ÁREAS DESTINO
// =======================================

function validarNombreArea(input) {
    const errorDiv = document.getElementById('error_nombre_area');
    const valor = input.value.trim();

    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-_#/]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre del área no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo letras, números y algunos signos como ( ) / . , están permitidos.";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarDescripcionArea(textarea) {
    const errorDiv = document.getElementById('error_descripcion_area');
    const valor = textarea.value.trim();

    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    if (valor === "") return true;

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()/-]+$/;

    if (!regex.test(valor)) {
        errorDiv.textContent = "La descripción solo puede contener letras, números y signos básicos.";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarAreaDestino(event) {
    const nombre = document.getElementById("nombre");
    const descripcion = document.getElementById("descripcion");

    const nombreValido = validarNombreArea(nombre);
    const descripcionValida = validarDescripcionArea(descripcion);

    if (!nombreValido || !descripcionValida) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de guardar el área destino.'
        });
        return false;
    }

    return true;
}


// ================================
// VALIDACIONES PARA EDITAR ÁREA DESTINO
// ================================

// Validar nombre del área destino
function validarNombreAreaEditar(input) {
    const errorDiv = document.getElementById('error_nombre_area');
    const valor = input.value.trim();

    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-_#/]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre del área no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, números y algunos signos (.,()-). No uses símbolos como #, %, $, etc.";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

// Validar descripción del área destino
function validarDescripcionAreaEditar(textarea) {
    const errorDiv = document.getElementById('error_descripcion_area');
    const valor = textarea.value.trim();

    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    if (valor === "") return true; // Descripción es opcional

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-]+$/;

    if (!regex.test(valor)) {
        errorDiv.textContent = "La descripción solo puede contener letras, números y signos (.,()-).";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

// Función principal al enviar el formulario
function validarEditarArea(event) {
    const nombreInput = document.getElementById('nombre');
    const descripcionInput = document.getElementById('descripcion');

    const nombreValido = validarNombreAreaEditar(nombreInput);
    const descripcionValida = validarDescripcionAreaEditar(descripcionInput);

    if (!nombreValido || !descripcionValida ||
        nombreInput.classList.contains("is-invalid") ||
        descripcionInput.classList.contains("is-invalid")) {

        event.preventDefault(); // Evita el envío
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de actualizar el área destino.'
        });
        return false;
    }

    return true; // Todo válido
}

// =======================================
// FUNCIONES DE VALIDACIÓN PARA CATEGORÍAS
// =======================================
function validarNombreCategoria(input) {
    const errorDiv = document.getElementById('error_cate_nombre');
    const valor = input.value.trim();
    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-+]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre de la categoría no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, números y signos básicos ( . , ( ) - + ).";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarDescripcionCategoria(textarea) {
    const errorDiv = document.getElementById('error_cate_descripcion');
    const valor = textarea.value.trim();
    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    if (valor === "") return true;

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-+]+$/;

    if (!regex.test(valor)) {
        errorDiv.textContent = "La descripción solo puede contener letras, números y signos básicos ( . , ( ) - + ).";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarCategoria(event) {
    const nombreInput = document.getElementById("cate_nombre");
    const descripcionInput = document.getElementById("cate_descripcion");

    const nombreValido = validarNombreCategoria(nombreInput);
    const descripcionValida = validarDescripcionCategoria(descripcionInput);

    if (!nombreValido || !descripcionValida) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de guardar la categoría.'
        });
        return false;
    }

    return true;
}

// =======================================
// FUNCIONES DE VALIDACIÓN PARA EDITAR CATEGORÍAS
// =======================================
function validarNombreCategoriaEditar(input) {
    const errorDiv = document.getElementById('error_cate_nombre');
    const valor = input.value.trim();
    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-+]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre de la categoría no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, números y signos básicos ( . , ( ) - + ).";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarDescripcionCategoriaEditar(textarea) {
    const errorDiv = document.getElementById('error_cate_descripcion');
    const valor = textarea.value.trim();
    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    if (valor === "") return true;

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-+]+$/;

    if (!regex.test(valor)) {
        errorDiv.textContent = "La descripción solo puede contener letras, números y signos básicos ( . , ( ) - + ).";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarEditarCategoria(event) {
    const nombreInput = document.getElementById("cate_nombre");
    const descripcionInput = document.getElementById("cate_descripcion");

    const nombreValido = validarNombreCategoriaEditar(nombreInput);
    const descripcionValida = validarDescripcionCategoriaEditar(descripcionInput);

    if (!nombreValido || !descripcionValida) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de actualizar la categoría.'
        });
        return false;
    }

    return true;
}

// ================================
// VALIDACIONES PARA REGISTRAR ROL
// ================================

function validarNombreRol(input) {
    const errorDiv = document.getElementById('error_rol_nombre');
    const valor = input.value.trim();
    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-+]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre del rol no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, números y signos básicos ( . , ( ) - + ).";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarRol(event) {
    const nombreInput = document.getElementById("rol_nombre");

    const nombreValido = validarNombreRol(nombreInput);

    if (!nombreValido) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de guardar el rol.'
        });
        return false;
    }

    return true;
}

// ================================
// VALIDACIONES PARA EDITAR ROL
// ================================
// ================================
// VALIDACIONES PARA EDITAR ROL
// ================================

function validarNombreRolEditar(input) {
    const errorDiv = document.getElementById("error_rol_nombre");
    const valor = input.value.trim();

    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZÀ-ÿ0-9\s.,()\-+]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre del rol no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, números y signos básicos ( . , ( ) - + ).";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarEditarRol(event) {
    const nombreInput = document.getElementById("rol_nombre");
    const estadoSelect = document.getElementById("estado_id");

    const nombreValido = validarNombreRolEditar(nombreInput);
    const estadoValido = estadoSelect.value !== "";

    if (!nombreValido || !estadoValido ||
        nombreInput.classList.contains("is-invalid")) {
        
        event.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de actualizar el rol.'
        });

        return false;
    }
    return true;
}

// =======================================
// VALIDACIONES PARA TIPO DE DOCUMENTO
// =======================================
function validarNombreTipoDocumento(input) {
    const valor = input.value.trim();
    const errorDiv = document.getElementById('error_tipo_docu_nombre');
    const soloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-.,()]+$/;

    if (valor === '') {
        errorDiv.textContent = 'Este campo es obligatorio.';
        return false;
    } else if (!soloLetras.test(valor)) {
        errorDiv.textContent = 'Solo se permiten letras y espacios.';
        return false;
    } else {
        errorDiv.textContent = '';
        return true;
    }
}

// Validar al enviar
function validarTipoDocumento(e) {
    const input = document.getElementById('tipo_docu_nombre');
    const valido = validarNombreTipoDocumento(input);

    if (!valido) {
        e.preventDefault();
        Swal.fire('Campos inválidos', 'Por favor revisa los errores en el formulario.', 'warning');
        return false;
    }
    return true;
}

//========================================
// VALIDACIONES PARA EDITAR TIPO DE DOCUMENTO
//========================================
function validarNombreTipoDocumentoEditar(input) {
    const errorDiv = document.getElementById('error_tipo_docu_nombre');
    const valor = input.value.trim();

    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-.,()]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre del tipo de documento no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, espacios y signos básicos ( . , - ).";
        input.classList.add("is-invalid");
        return false;
    }

    return true;
}

function validarEditarTipoDocumento(event) {
    const nombreInput = document.getElementById("tipo_docu_nombre");

    const nombreValido = validarNombreTipoDocumentoEditar(nombreInput);

    if (!nombreValido || nombreInput.classList.contains("is-invalid")) {
        event.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Formulario incompleto',
            text: 'Corrige los errores antes de actualizar el tipo de documento.'
        });

        return false;
    }
    return true;
}

// =======================================
// VALIDACIONES PARA AREAS
// =======================================
function validarNombreArea(input) {
    const nombre = input.value.trim();
    const errorDiv = document.getElementById('error_area_nombre');
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s.,()-]+$/;

    if (nombre === '') {
        errorDiv.textContent = 'El nombre del área es obligatorio.';
        return false;
    } else if (!regex.test(nombre)) {
        errorDiv.textContent = 'Solo se permiten letras, números y signos como , . ( ) -';
        return false;
    } else {
        errorDiv.textContent = '';
        return true;
    }
}

// ===========================
// Validar descripción del área
// ===========================
function validarDescripcionArea(textarea) {
    const descripcion = textarea.value.trim();
    const errorDiv = document.getElementById('error_area_descripcion');
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s.,()-]*$/; // * porque es opcional

    if (descripcion !== '' && !regex.test(descripcion)) {
        errorDiv.textContent = 'La descripción contiene caracteres no permitidos.';
        return false;
    } else {
        errorDiv.textContent = '';
        return true;
    }
}

// ===========================
// Validar todo el formulario
// ===========================
function validarArea(event) {
    const nombreValido = validarNombreArea(document.getElementById('area_nombre'));
    const descripcionValida = validarDescripcionArea(document.getElementById('area_descripcion'));

    if (!nombreValido || !descripcionValida) {
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Campos inválidos',
            text: 'Por favor corrige los errores antes de continuar.',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }

    return true;
}

// ================================
// VALIDACIONES PARA EDITAR ÁREA
// ================================

// Validar nombre del área (editar)
function validarNombreAreaEditar(input) {
    const errorDiv = document.getElementById('error_area_nombre');
    const valor = input.value.trim();

    errorDiv.textContent = "";
    input.classList.remove("is-invalid");

    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s.,()\-]+$/;

    if (valor === "") {
        errorDiv.textContent = "El nombre del área no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    }

    if (!regex.test(valor)) {
        errorDiv.textContent = "Solo se permiten letras, números y signos como , . ( ) -";
        input.classList.add("is-invalid");
        return false;
    }
    return true;
}

// Validar descripción del área (editar)
function validarDescripcionAreaEditar(textarea) {
    const errorDiv = document.getElementById('error_area_descripcion');
    const valor = textarea.value.trim();

    errorDiv.textContent = "";
    textarea.classList.remove("is-invalid");

    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s.,()\-]*$/;

    if (valor !== "" && !regex.test(valor)) {
        errorDiv.textContent = "La descripción contiene caracteres no permitidos.";
        textarea.classList.add("is-invalid");
        return false;
    }

    return true;
}

// Validar todo el formulario (editar)
function validarEditarArea(event) {
    const nombreInput = document.getElementById('area_nombre');
    const descripcionInput = document.getElementById('area_descripcion');

    const nombreValido = validarNombreAreaEditar(nombreInput);
    const descripcionValida = validarDescripcionAreaEditar(descripcionInput);

    if (!nombreValido || !descripcionValida) {
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Campos inválidos',
            text: 'Corrige los errores antes de actualizar el área.',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }
    return true;
}

