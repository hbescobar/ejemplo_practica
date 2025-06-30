<!-- =============================== -->
<!-- VISTA: Editar Usuario -->
<!-- Archivo: edit.php de usuarios -->
<!-- =============================== -->

<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <!-- Título del formulario -->
                    <h4 class="fw-bold text-warning text-center mb-3">
                        <i class='bx bx-user-check'></i> Actualizar Usuario
                    </h4>

                    <!-- Nota de campos obligatorios -->
                    <p class="text-muted small text-center mb-4">
                        <span class="text-danger">*</span> Los campos con asterisco son obligatorios.
                    </p>

                    <!-- Formulario -->
                    <form action="<?= getUrl('usuarios', 'usuarios', 'postEdit'); ?>" method="POST" onsubmit="return validarForm(event)">
                        <!-- ID oculto -->
                        <input type="hidden" name="usu_id" value="<?= $usuario['usu_id']; ?>">

                        <!-- Tipo y Número de Documento -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_docu_id" class="form-label">
                                    <i class='bx bx-id-card'></i> Tipo de Documento <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="tipo_docu_id" id="tipo_docu_id" required>
                                    <option value="" disabled>Selecciona el tipo de documento</option>
                                    <?php foreach ($tipos_doc as $tipo): ?>
                                        <option value="<?= $tipo['tipo_docu_id']; ?>" <?= ($usuario['tipo_docu_id'] == $tipo['tipo_docu_id']) ? 'selected' : ''; ?>>
                                            <?= $tipo['tipo_docu_nombre']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-danger mt-1" id="errortipo_docu_id"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_numero_docu" class="form-label">
                                    <i class='bx bx-barcode'></i> Número de Documento <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_numero_docu" id="usu_numero_docu" class="form-control"
                                value="<?= $usuario['usu_numero_docu']; ?>" required placeholder="Digita el número de documento" onchange="validarNumDocum(this)">
                                <div class="text-danger mt-1" id="errorusu_numero_docu"></div>
                            </div>
                        </div>

                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usu_nombre" class="form-label">
                                    <i class='bx bx-user'></i> Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_nombre" id="usu_nombre" class="form-control"
                                    value="<?= $usuario['usu_nombre']; ?>" required placeholder="Escribe el nombre" onchange="validarNombre(this)">
                                <div class="text-danger mt-1" id="errorusu_nombre"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_apellido" class="form-label">
                                    <i class='bx bx-user'></i> Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_apellido" id="usu_apellido" class="form-control"
                                    value="<?= $usuario['usu_apellido']; ?>" required placeholder="Escribe el apellido" onchange="validarApellido(this)">
                                <div class="text-danger mt-1" id="errorusu_apellido"></div>
                            </div>
                        </div>

                        <!-- Correo y Teléfono -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usu_email" class="form-label">
                                    <i class='bx bx-envelope'></i> Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="usu_email" id="usu_email" class="form-control"
                                    value="<?= $usuario['usu_email']; ?>" required placeholder="Correo electrónico" onchange="validarCorreo(this)">
                                <div class="text-danger mt-1" id="errorusu_email"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_telefono" class="form-label">
                                    <i class='bx bx-phone'></i> Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_telefono" id="usu_telefono" class="form-control"
                                    value="<?= $usuario['usu_telefono']; ?>" required placeholder="Número de contacto" onchange="validarTelefono(this)">
                                <div class="text-danger mt-1" id="errorusu_telefono"></div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="usu_direccion" class="form-label">
                                <i class='bx bx-map'></i> Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="usu_direccion" id="usu_direccion" class="form-control"
                                value="<?= $usuario['usu_direccion']; ?>" required placeholder="Dirección actual" onchange="validarDireccion(this)">
                            <div class="text-danger mt-1" id="errorusu_direccion"></div>
                        </div>

                        <!-- Rol y Contraseña -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rol_id" class="form-label">
                                    <i class='bx bx-shield'></i> Rol <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="rol_id" id="rol_id" required>
                                    <option value="" disabled>Selecciona el rol</option>
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?= $rol['rol_id']; ?>" <?= ($usuario['rol_id'] == $rol['rol_id']) ? 'selected' : ''; ?>>
                                            <?= $rol['rol_nombre']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Contraseña -->
                            <div class="col-md-6">
                                <label for="usu_clave" class="form-label">
                                    <i class='bx bx-lock-alt'></i> Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="usu_clave" id="usu_clave" class="form-control"
                                    value="<?= $usuario['usu_clave']; ?>" required placeholder="Actualizar contraseña" onchange="validarClave(this)">
                                <div class="text-danger mt-1" id="errorusu_clave"></div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning me-2">
                                <i class='bx bx-refresh'></i> Actualizar Usuario
                            </button>
                            <a href="<?= getUrl('usuarios', 'usuarios', 'consult'); ?>" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/Inventario/Web/Js/validaciones/validaciones.js"></script>