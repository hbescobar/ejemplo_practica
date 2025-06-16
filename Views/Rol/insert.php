<!-- ============================= -->
<!-- VISTA PARA REGISTRAR UN ROL -->
<!-- ============================= -->

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título -->
        <h4 class="text-center text-primary fw-bold mb-3">
            <i class="bi bi-person-badge-fill me-2"></i> Registrar Rol
        </h4>

        <p class="text-muted text-center mb-4">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <form action="<?php echo getUrl('rol', 'rol', 'postInsert'); ?>" method="post">

            <!-- Campo: Nombre del Rol -->
            <div class="mb-3">
                <label for="rol_nombre" class="form-label">
                    <i class="bi bi-person-lines-fill text-primary"></i> Nombre del Rol <span class="text-danger">*</span>
                </label>
                <input type="text" name="rol_nombre" id="rol_nombre" class="form-control" required>
            </div>

            <!-- Campo: Estado -->
            <div class="mb-3">
                <label for="estado_id" class="form-label">
                    <i class="bi bi-toggle-on text-primary"></i> Estado <span class="text-danger">*</span>
                </label>
                <select name="estado_id" id="estado_id" class="form-select" required>
                    <option value="">Seleccione un estado</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?php echo $estado['estado_id']; ?>">
                            <?php echo $estado['estado_nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save-fill"></i> Guardar Rol
                </button>
                <a href="<?php echo getUrl('rol', 'rol', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>

    </div>
</div>
