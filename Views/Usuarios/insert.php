<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-success text-center mb-3">
                        <i class='bx bx-user-plus'></i> Registrar Nuevo Usuario
                    </h4>

                    <p class="text-muted small text-center mb-4">
                        <span class="text-danger">*</span> Los campos con asterisco son obligatorios.
                    </p>

                    <form action="<?= getUrl('usuarios', 'usuarios', 'postInsert'); ?>" method="POST" onsubmit="return validarForm(event)">

                        <!-- Tipo y Número de Documento -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_docu_id" class="form-label">
                                    <i class='bx bx-id-card'></i> Tipo de Documento <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="tipo_docu_id" id="tipo_docu_id" required>
                                    <option value="" disabled <?= empty($form_data['tipo_docu_id']) ? 'selected' : '' ?>>Selecciona el tipo de documento</option>
                                    <?php foreach ($tipos_doc as $tipo): ?>
                                        <option value="<?= $tipo['tipo_docu_id']; ?>" <?= (isset($form_data['tipo_docu_id']) && $form_data['tipo_docu_id'] == $tipo['tipo_docu_id']) ? 'selected' : '' ?>>
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
                                <input type="text" name="usu_numero_docu" id="usu_numero_docu" class="form-control" value="<?= $form_data['usu_numero_docu'] ?? '' ?>" required placeholder="Digita tu número de documento" onchange="validarNumDocum(this)">
                                <div class="text-danger mt-1" id="errorusu_numero_docu"></div>
                            </div>
                        </div>

                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usu_nombre" class="form-label">
                                    <i class='bx bx-user'></i> Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_nombre" id="usu_nombre" class="form-control" required placeholder="Escribe tu nombre" value="<?= $form_data['usu_nombre'] ?? '' ?>" onchange="validarNombre(this)">
                                <div class="text-danger mt-1" id="errorusu_nombre"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_apellido" class="form-label">
                                    <i class='bx bx-user'></i> Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_apellido" id="usu_apellido" class="form-control" required placeholder="Escribe tu apellido"  value="<?= $form_data['usu_apellido'] ?? '' ?>" onchange="validarApellido(this)">
                                <div class="text-danger mt-1" id="errorusu_apellido"></div>
                            </div>
                        </div>

                        <!-- Correo y Teléfono -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usu_email" class="form-label">
                                    <i class='bx bx-envelope'></i> Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="usu_email" id="usu_email" class="form-control" required placeholder="Escribe tu correo personal"  value="<?= $form_data['usu_email'] ?? '' ?>" onchange="validarCorreo(this)">
                                <div class="text-danger mt-1" id="errorusu_email"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_telefono" class="form-label">
                                    <i class='bx bx-phone'></i> Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_telefono" id="usu_telefono" class="form-control" required placeholder="Digita tu número de teléfono" value="<?= $form_data['usu_telefono'] ?? '' ?>" onchange="validarTelefono(this)">
                                <div class="text-danger mt-1" id="errorusu_telefono"></div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="usu_direccion" class="form-label">
                                <i class='bx bx-map'></i> Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="usu_direccion" id="usu_direccion" class="form-control" required placeholder="Escribe tu dirección actual" value="<?= $form_data['usu_direccion'] ?? '' ?>" onchange="validarDireccion(this)">
                            <div class="text-danger mt-1" id="errorusu_direccion"></div>
                        </div>

                        <!-- Rol y Contraseña-->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rol_id" class="form-label">
                                    <i class='bx bx-shield'></i> Rol <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="rol_id" id="rol_id" required>
                                    <option value="" selected disabled>Selecciona el rol del usuario</option>
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?= $rol['rol_id']; ?>" <?= (isset($form_data['rol_id']) && $form_data['rol_id'] == $rol['rol_id']) ? 'selected' : '' ?>>
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
                                <input type="password" name="usu_clave" id="usu_clave" class="form-control" required placeholder="Crea una contraseña segura" value="<?= $form_data['usu_clave'] ?? '' ?>" onchange="validarClave(this)">
                                <div class="text-danger mt-1" id="errorusu_clave"></div>
                            </div>     
                        </div>

                        <!-- Botones -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success me-2">
                                <i class='bx bx-save'></i> Guardar Usuario
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