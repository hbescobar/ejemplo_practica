<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta para el formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-primary fw-bold mb-3">
            <i class="bi bi-diagram-3-fill me-2"></i> Registrar Área
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted mb-4 text-center">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario -->
        <form action="<?php echo getUrl('areas', 'areas', 'postInsert'); ?>" method="POST">

            <!-- Campo: Nombre del Área -->
            <div class="mb-3">
                <label for="area_nombre" class="form-label">
                    <i class="bi bi-tag-fill text-primary"></i> Nombre del Área <span class="text-danger">*</span>
                </label>
                <input type="text" name="area_nombre" id="area_nombre" class="form-control"
                       placeholder="Ej: Laboratorio de Física" required>
            </div>

            <!-- Campo: Descripción del Área -->
            <div class="mb-3">
                <label for="area_descripcion" class="form-label">
                    <i class="bi bi-card-text text-primary"></i> Descripción del Área
                </label>
                <textarea name="area_descripcion" id="area_descripcion" rows="3" class="form-control"
                          placeholder="Describe brevemente el propósito, ubicación u observaciones..."></textarea>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save-fill"></i> Guardar Área
                </button>
                <a href="<?php echo getUrl('areas', 'areas', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
