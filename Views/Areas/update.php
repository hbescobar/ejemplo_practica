<!-- ============================= -->
<!-- VISTA PARA EDITAR UN ÁREA -->
<!-- ============================= -->

<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta del formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-warning fw-bold mb-3">
            <i class="bi bi-pencil-square me-2"></i> Editar Área
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted mb-4 text-center">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario para actualizar área -->
        <form action="<?php echo getUrl('areas', 'areas', 'postEdit'); ?>" method="POST" onsubmit="return validarEditarArea(event)">

            <!-- Campo oculto: ID del área -->
            <input type="hidden" name="area_id" value="<?php echo $area['area_id']; ?>">

            <!-- Campo: Nombre del Área -->
            <div class="mb-3">
                <label for="area_nombre" class="form-label">
                    <i class="bi bi-tag-fill text-primary"></i> Nombre del Área <span class="text-danger">*</span>
                </label>
                <input type="text" name="area_nombre" id="area_nombre" class="form-control"
                    placeholder="Ej: Laboratorio de Electrónica"
                    value="<?php echo htmlspecialchars($area['area_nombre']); ?>" onchange="validarNombreAreaEditar(this)" required>
                <div class="text-danger mt-1" id="error_area_nombre"></div>
            </div>

            <!-- Campo: Descripción del Área -->
            <div class="mb-3">
                <label for="area_descripcion" class="form-label">
                    <i class="bi bi-card-text text-primary"></i> Descripción del Área
                </label>
                <textarea name="area_descripcion" id="area_descripcion" class="form-control" rows="3"
                    placeholder="Describe brevemente el propósito o ubicación del área..." onchange="validarDescripcionAreaEditar(this)"><?php echo htmlspecialchars($area['area_descripcion']); ?></textarea>
                <div class="text-danger mt-1" id="error_area_descripcion"></div>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning me-2">
                    <i class="bi bi-arrow-repeat"></i> Actualizar Área
                </button>
                <a href="<?php echo getUrl('areas', 'areas', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Inventario/Web/Js/validaciones/validaciones_config.js"></script>