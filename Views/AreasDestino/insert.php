<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta para el formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-primary fw-bold mb-3">
            <i class="bi bi-diagram-3-fill me-2"></i> Registrar área destino
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted mb-4 text-center">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario -->
        <form action="<?php echo getUrl('areasDestino', 'areasDestino', 'postInsert'); ?>" method="POST" onsubmit="return validarAreaDestino(event)">

            <!-- Campo: Nombre del Área -->
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-tag-fill text-primary"></i> Nombre del área destino <span class="text-danger">*</span>
                </label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Laboratorio de Física" required onchange="validarNombreArea(this)">
                <div class="text-danger mt-1" id="error_nombre_area"></div>
            </div>

            <!-- Campo: Descripción del Área -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">
                    <i class="bi bi-card-text text-primary"></i> Descripción del área destino <small class="text-muted">(opcional)</small>
                </label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Describe brevemente el propósito, ubicación u observaciones..." onchange="validarDescripcionArea(this)"></textarea>
                <div class="text-danger mt-1" id="error_descripcion_area"></div>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save-fill"></i> Guardar área destino
                </button>
                <a href="<?php echo getUrl('areasDestino', 'areasDestino', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Inventario/Web/Js/validaciones/validaciones_config.js"></script>
