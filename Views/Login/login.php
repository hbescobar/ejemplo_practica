<link rel="stylesheet" href="/Inventario/Web/Css/login.css">

<div class="contenedor">
    <!-- Formulario de Login -->
    <div class="form-box login">
        <form action="<?php echo getUrl('login', 'login', 'postLogin'); ?>" method="POST">
            <h1>Login</h1>

            <!-- Documento -->
            <div class="input-box">
                <input type="text" name="usu_numero_docu" placeholder="Número de Documento" required autocomplete="username">
                <i class='bx bxs-user'></i>
            </div>

            <!-- Contraseña -->
            <div class="input-box">
                <input type="password" id="password" name="usu_clave" placeholder="Contraseña" required autocomplete="current-password">
                <i class='bx bxs-lock-alt' id="iconLock"></i>
                <!-- Ícono mostrar/ocultar contraseña -->
                <i class='bx bx-show toggle-password' id="togglePassword" style="display: none; cursor: pointer;"></i>
            </div>


            <!-- Rol -->
            <div class="input-box">
                <select name="rol_id" class="form-control" required>
                    <option value="">Selecciona un rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['rol_id'] ?>"><?= $rol['rol_nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <i class='bx bx-id-card'></i>
            </div>

            <div class="forgot-link">
                <a href="#">¿Olvidaste la contraseña?</a>
            </div>

            <button type="submit" class="btn">Ingresar</button>

            <p style="font-size: 13px; color: #888; margin-top: 20px;">
                © 2025 InvenSys. Todos los derechos reservados.
            </p>
        </form>
    </div>

    <!-- Panel derecho con logo y saludo -->
    <div class="toggle-box">
        <div class="toggle-panel toggle-left" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center;">
            <!-- Logo circular -->
            <img src="/Inventario/Web/Img/logo.jpg" alt="Logo InvenSys" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

            <!-- Mensaje de bienvenida -->
            <h2 style="font-size: 24px; color: #fff;">¡Hola! Bienvenido a</h2>
            <h1 style="font-size: 32px; color: #fff; margin-top: 5px;">InvenSys</h1>
        </div>
    </div>
</div>

<script src="/Inventario/Web/Js/Login/login.js"></script>