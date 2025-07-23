<link rel="stylesheet" href="/Inventario/Web/Css/login.css?v=123">

<div class="contenedor">
    <!-- Formulario de Login -->
    <div class="form-box login">
        <form id="loginForm" action="<?php echo getUrl('login', 'login', 'postLogin'); ?>" method="POST">
            <h1>Login</h1>

            <!-- Documento -->
            <div class="input-box">
                <input type="text" name="usu_numero_docu" id="usu_numero_docu" placeholder="Número de Documento" autocomplete="username">
                <i class='bx bxs-user'></i>
                <small class="error" id="error-doc">Solo se permiten números</small>
            </div>

            <!-- Contraseña -->
            <div class="input-box">
                <input type="password" id="usu_clave" name="usu_clave" placeholder="Contraseña" autocomplete="current-password">
                <i class='bx bxs-lock-alt' id="iconLock"></i>
                <i class='bx bx-show toggle-password' id="togglePassword" style="display: none; cursor: pointer;"></i>
                <small class="error" id="error-pass">Este campo no puede estar vacío</small>
            </div>
            <button type="submit" class="btn">Ingresar</button>

            <p style="font-size: 13px; color: #888; margin-top: 20px;">
                © 2025 Inventix. Todos los derechos reservados.
            </p>
        </form>
    </div>

    <!-- Panel derecho -->
    <div class="toggle-box">
        <div class="toggle-panel toggle-left" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center;">
            <img src="/Inventario/Web/Img/logo1.png" alt="Logo Inventix" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h2 style="font-size: 24px; color: #fff;">¡Hola! Bienvenido a</h2>
            <h1 style="font-size: 32px; color: #fff; margin-top: 5px;">Inventix</h1>
        </div>
    </div>
</div>

<script src="/inventario/Web/Js/Login/login.js"></script>

<style>
    /* ===== VALIDACIONES PERSONALIZADAS ===== */
    small.error {
        color: #dc3545;
        font-size: 14px;
        display: none;
        position: absolute;
        bottom: -18px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        width: max-content;
        max-width: 100%;
        white-space: nowrap;
    }

    /* Campo inválido: borde rojo suave */
    input.invalid,
    select.invalid {
        border: 2px solid #dc3545 !important;
        background-color: #fff !important;
    }

    /* Acomodar ícono en input */
    .input-box input+i {
        right: 20px;
    }

    /* Acomodar ícono del SELECT separado de la flechita */
    .input-box select+i.bx-id-card {
        right: 35px;
    }

    .input-box {
        position: relative;
        margin-bottom: 28px;
    }
</style>
