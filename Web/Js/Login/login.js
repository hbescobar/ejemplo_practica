const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const iconLock = document.getElementById("iconLock");

// Escuchar cambios en el input
passwordInput.addEventListener("input", function () {
  if (this.value.length > 0) {
    // Mostrar ojo, ocultar candado
    togglePassword.style.display = "inline";
    iconLock.style.display = "none";
  } else {
    // Mostrar candado, ocultar ojo
    togglePassword.style.display = "none";
    iconLock.style.display = "inline";

    // Restaurar tipo de campo e ícono si se borró todo
    passwordInput.type = "password";
    togglePassword.classList.remove("bx-hide");
    togglePassword.classList.add("bx-show");
  }
});

// Mostrar/Ocultar contraseña
togglePassword.addEventListener("click", function () {
  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";
  this.classList.toggle("bx-show");
  this.classList.toggle("bx-hide");
});
