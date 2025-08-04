<!-- ============================= -->
<!-- VISTA PARA REGISTRAR TIPO DE DOCUMENTO -->
<!-- ============================= -->

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título -->
        <h4 class="text-center text-primary fw-bold mb-3">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Registrar Tipo de Documento
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted text-center mb-4">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <form action="<?php echo getUrl('tipoDocumento', 'tipoDocumento', 'postInsert'); ?>" method="POST" onsubmit="return validarTipoDocumento(event)">

            <div class="mb-3">
                <label for="tipo_docu_nombre" class="form-label">
                    <i class="bi bi-file-text text-primary"></i> Nombre del tipo de documento <span class="text-danger">*</span>
                </label>
                <input type="text" name="tipo_docu_nombre" id="tipo_docu_nombre" class="form-control"
                    placeholder="Ej: Cédula, Pasaporte, Licencia" onchange="validarNombreTipoDocumento(this)" required>
                <div class="text-danger mt-1" id="error_tipo_docu_nombre"></div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save"></i> Registrar
                </button>
                <a href="<?php echo getUrl('tipoDocumento', 'tipoDocumento', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Inventario/Web/Js/validaciones/validaciones_config.js"></script>
