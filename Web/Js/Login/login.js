const passwordInput = document.getElementById("usu_clave");
const togglePassword = document.getElementById("togglePassword");
const iconLock = document.getElementById("iconLock");

const form = document.getElementById("loginForm");
const docInput = document.getElementById("usu_numero_docu");
const rolSelect = document.getElementById("rol_id");

const errorDoc = document.getElementById("error-doc");
const errorPass = document.getElementById("error-pass");
const errorRol = document.getElementById("error-rol");

// Mostrar/Ocultar icono de ojo dinámicamente
passwordInput.addEventListener("input", function () {
  if (this.value.length > 0) {
    togglePassword.style.display = "inline";
    iconLock.style.display = "none";
  } else {
    togglePassword.style.display = "none";
    iconLock.style.display = "inline";
    passwordInput.type = "password";
    togglePassword.classList.remove("bx-hide");
    togglePassword.classList.add("bx-show");
  }
});

// Cambiar visibilidad de la contraseña
togglePassword.addEventListener("click", function () {
  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";
  this.classList.toggle("bx-show");
  this.classList.toggle("bx-hide");
});

// Documento - solo números y no vacío
docInput.addEventListener("input", () => {
  const valor = docInput.value.trim();

  if (valor === "") {
    docInput.classList.add("is-invalid");
    errorDoc.textContent = "Este campo no puede estar vacío";
    errorDoc.style.display = "block";
  } else if (!/^\d+$/.test(valor)) {
    docInput.classList.add("is-invalid");
    errorDoc.textContent = "Solo se permiten números";
    errorDoc.style.display = "block";
  } else {
    docInput.classList.remove("is-invalid");
    errorDoc.style.display = "none";
  }
});

// Contraseña - no vacío
passwordInput.addEventListener("input", () => {
  const valor = passwordInput.value.trim();

  if (valor === "") {
    passwordInput.classList.add("is-invalid");
    errorPass.textContent = "Este campo no puede estar vacío";
    errorPass.style.display = "block";
  } else {
    passwordInput.classList.remove("is-invalid");
    errorPass.style.display = "none";
  }
});

// Rol - selección requerida
rolSelect.addEventListener("change", () => {
  const valor = rolSelect.value;

  if (valor === "") {
    rolSelect.classList.add("is-invalid");
    errorRol.textContent = "Selecciona un rol";
    errorRol.style.display = "block";
  } else {
    rolSelect.classList.remove("is-invalid");
    errorRol.style.display = "none";
  }
});

// Validación final al enviar el formulario
form.addEventListener("submit", function (e) {
  let isValid = true;

  const docVal = docInput.value.trim();
  if (docVal === "") {
    docInput.classList.add("is-invalid");
    errorDoc.textContent = "Este campo no puede estar vacío";
    errorDoc.style.display = "block";
    isValid = false;
  } else if (!/^\d+$/.test(docVal)) {
    docInput.classList.add("is-invalid");
    errorDoc.textContent = "Solo se permiten números";
    errorDoc.style.display = "block";
    isValid = false;
  }

  const passVal = passwordInput.value.trim();
  if (passVal === "") {
    passwordInput.classList.add("is-invalid");
    errorPass.textContent = "Este campo no puede estar vacío";
    errorPass.style.display = "block";
    isValid = false;
  }

  const rolVal = rolSelect.value;
  if (rolVal === "") {
    rolSelect.classList.add("is-invalid");
    errorRol.textContent = "Selecciona un rol";
    errorRol.style.display = "block";
    isValid = false;
  }

  if (!isValid) {
    e.preventDefault(); // Detener envío
  }
});
