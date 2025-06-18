<!-- ============================= -->
<!-- VISTA PARA EDITAR UN ÁREA -->
<!-- ============================= -->

<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta del formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-warning fw-bold mb-3">
            <i class="bi bi-pencil-square me-2"></i> Editar área destino
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted mb-4 text-center">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario para actualizar área -->
        <form action="<?php echo getUrl('areasDestino', 'areasDestino', 'postEdit'); ?>" method="POST">

            <!-- Campo oculto: ID del área -->
            <input type="hidden" name="id_area_destino" value="<?php echo $area['id_area_destino']; ?>">

            <!-- Campo: Nombre del Área -->
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-tag-fill text-primary"></i> Nombre del área destino <span class="text-danger">*</span>
                </label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    placeholder="Ej: Laboratorio de Electrónica"
                    value="<?php echo htmlspecialchars($area['nombre']); ?>" required>
            </div>

            <!-- Campo: Descripción del Área -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">
                    <i class="bi bi-card-text text-primary"></i> Descripción del área destino
                </label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"
                    placeholder="Describe brevemente el propósito o ubicación del área..."><?php echo htmlspecialchars($area['descripcion']); ?></textarea>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning me-2">
                    <i class="bi bi-arrow-repeat"></i> Actualizar área destino
                </button>
                <a href="<?php echo getUrl('areasDestino', 'areasDestino', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
