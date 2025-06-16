<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <!-- Título -->
                    <h4 class="fw-bold text-info text-center mb-4">
                        <i class='bx bx-show-alt'></i> Detalles del Usuario
                    </h4>

                    <form>
                        <!-- Tipo y Número de Documento -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-id-card'></i> Tipo de Documento
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['tipo_docu_nombre'] ?? 'Sin dato'; ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-barcode'></i> Número de Documento
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['usu_numero_docu'] ?? ''; ?>" disabled>
                            </div>
                        </div>

                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-user'></i> Nombre
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['usu_nombre'] ?? ''; ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-user'></i> Apellido
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['usu_apellido'] ?? ''; ?>" disabled>
                            </div>
                        </div>

                        <!-- Correo y Teléfono -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-envelope'></i> Correo Electrónico
                                </label>
                                <input type="email" class="form-control bg-light"
                                    value="<?= $usuario['usu_email'] ?? ''; ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-phone'></i> Teléfono
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['usu_telefono'] ?? ''; ?>" disabled>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class='bx bx-map'></i> Dirección
                            </label>
                            <input type="text" class="form-control bg-light"
                                value="<?= $usuario['usu_direccion'] ?? ''; ?>" disabled>
                        </div>

                        <!-- Rol y Estado -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-shield'></i> Rol
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['rol_nombre'] ?? 'Sin rol'; ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class='bx bx-toggle-left'></i> Estado
                                </label>
                                <input type="text" class="form-control bg-light"
                                    value="<?= $usuario['estado_nombre'] ?? 'Sin estado'; ?>" disabled>
                            </div>
                        </div>

                        <!-- Clave (Oculta) -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class='bx bx-lock-alt'></i> Clave (oculta)
                            </label>
                            <input type="password" class="form-control bg-light"
                                value="<?= $usuario['usu_clave'] ?? ''; ?>" disabled>
                        </div>

                        <!-- Botón Volver -->
                        <div class="text-center mt-4">
                            <a href="<?= getUrl('usuarios', 'usuarios', 'consult'); ?>" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Volver al Listado
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>