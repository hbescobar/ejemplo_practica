<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary text-center mb-3">
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
                                    <option value="" selected disabled>Selecciona el tipo de documento</option>
                                    <?php foreach ($tipos_doc as $tipo): ?>
                                        <option value="<?= $tipo['tipo_docu_id']; ?>"><?= $tipo['tipo_docu_nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-danger mt-1" id="errortipo_docu_id"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_numero_docu" class="form-label">
                                    <i class='bx bx-barcode'></i> Número de Documento <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_numero_docu" id="usu_numero_docu" class="form-control" required placeholder="Digita tu número de documento" onchange="validarNumDocum(this)">
                                <div class="text-danger mt-1" id="errorusu_numero_docu"></div>
                            </div>
                        </div>

                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usu_nombre" class="form-label">
                                    <i class='bx bx-user'></i> Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_nombre" id="usu_nombre" class="form-control" required placeholder="Escribe tu nombre" onchange="validarNombre(this)">
                                <div class="text-danger mt-1" id="errorusu_nombre"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_apellido" class="form-label">
                                    <i class='bx bx-user'></i> Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_apellido" id="usu_apellido" class="form-control" required placeholder="Escribe tu apellido" onchange="validarApellido(this)">
                                <div class="text-danger mt-1" id="errorusu_apellido"></div>
                            </div>
                        </div>

                        <!-- Correo y Teléfono -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usu_email" class="form-label">
                                    <i class='bx bx-envelope'></i> Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="usu_email" id="usu_email" class="form-control" required placeholder="Escribe tu correo personal" onchange="validarCorreo(this)">
                                <div class="text-danger mt-1" id="errorusu_email"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="usu_telefono" class="form-label">
                                    <i class='bx bx-phone'></i> Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="usu_telefono" id="usu_telefono" class="form-control" required placeholder="Digita tu número de teléfono" onchange="validarTelefono(this)">
                                <div class="text-danger mt-1" id="errorusu_telefono"></div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="usu_direccion" class="form-label">
                                <i class='bx bx-map'></i> Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="usu_direccion" id="usu_direccion" class="form-control" required placeholder="Escribe tu dirección actual" onchange="validarDireccion(this)">
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
                                        <option value="<?= $rol['rol_id']; ?>"><?= $rol['rol_nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Contraseña -->
                            <div class="col-md-6">
                                <label for="usu_clave" class="form-label">
                                    <i class='bx bx-lock-alt'></i> Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="usu_clave" id="usu_clave" class="form-control" required placeholder="Crea una contraseña segura" onchange="validarClave(this)">
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

                    <!-- Modal de Documento Duplicado -->
                    <div class="modal fade" id="modalDuplicado" tabindex="-1" aria-labelledby="modalDuplicadoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="modalDuplicadoLabel">Error de Registro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                Ya existe un usuario con este número de documento.
                            </div>
                            <div class="modal-footer">
                                <button id="btnOkDuplicado" type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal de Documento Duplicado -->                  
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/Inventario/Web/Js/validaciones/validaciones.js"></script>

<!-- Script para mostrar el modal y redirigir -->
<?php if (isset($mensaje) && $mensaje === "Ya existe un usuario con este número de documento."): ?> <!--mensaje de error que se muestra si el número de documento ya existe, es decir si mensaje es igual a "Ya existe un usuario con este número de documento." -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalDuplicado'));
        modal.show();

        const boton = document.getElementById('btnOkDuplicado');
        boton.addEventListener('click', () => {
            window.location.href = 'index.php?modulo=usuarios&controlador=usuarios&funcion=getInsert';
        });

        document.getElementById('modalDuplicado').addEventListener('hidden.bs.modal', () => {
            window.location.href = 'index.php?modulo=usuarios&controlador=usuarios&funcion=getInsert';
        });
    });
</script>
<?php endif; ?>