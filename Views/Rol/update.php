<!-- ============================= -->
<!-- VISTA PARA EDITAR UN ROL -->
<!-- ============================= -->

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título -->
        <h4 class="text-center text-warning fw-bold mb-3">
            <i class="bi bi-person-badge-fill me-2"></i> Editar Rol
        </h4>

        <form action="<?php echo getUrl('rol', 'rol', 'postEdit'); ?>" method="post" onsubmit="return validarEditarRol(event)">

            <!-- ID del rol (oculto) -->
            <input type="hidden" name="rol_id" value="<?php echo $rol['rol_id']; ?>">

            <!-- Nombre del Rol -->
            <div class="mb-3">
                <label for="rol_nombre" class="form-label">
                    <i class="bi bi-person-lines-fill text-warning"></i> Nombre del Rol <span class="text-danger">*</span>
                </label>
                <input type="text" name="rol_nombre" id="rol_nombre" class="form-control" value="<?php echo htmlspecialchars($rol       ['rol_nombre']); ?>" onchange="validarNombreRolEditar(this)" required>
                <div class="text-danger mt-1" id="error_rol_nombre"></div>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label for="estado_id" class="form-label">
                    <i class="bi bi-toggle-on text-warning"></i> Estado <span class="text-danger">*</span>
                </label>
                <select
                    name="estado_id"
                    id="estado_id"
                    class="form-select"
                    required>
                    <option value="">Seleccione un estado</option>
                    <?php foreach ($estados as $estado): ?>
                        <option
                            value="<?php echo $estado['estado_id']; ?>"
                            <?php if ($estado['estado_id'] == $rol['estado_id']) echo 'selected'; ?>>
                            <?php echo $estado['estado_nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Actualizar Rol
                </button>
                <a href="<?php echo getUrl('rol', 'rol', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Inventario/Web/Js/validaciones/validaciones_config.js"></script>
