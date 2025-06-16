<!-- ============================= -->
<!-- VISTA PARA EDITAR TIPO DE DOCUMENTO -->
<!-- ============================= -->

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título -->
        <h4 class="text-center text-warning fw-bold mb-3">
            <i class="bi bi-file-earmark-text-fill me-2"></i> Editar Tipo de Documento
        </h4>

        <?php if (isset($tipoDocumento) && !empty($tipoDocumento)): ?>
            <form action="<?php echo getUrl('tipoDocumento', 'tipoDocumento', 'postEdit'); ?>" method="POST">
                <input type="hidden" name="tipo_docu_id" value="<?php echo htmlspecialchars($tipoDocumento['tipo_docu_id']); ?>">

                <div class="mb-3">
                    <label for="tipo_docu_nombre" class="form-label">
                        <i class="bi bi-file-text text-warning"></i> Nombre del Tipo de Documento
                    </label>
                    <input type="text" id="tipo_docu_nombre" name="tipo_docu_nombre" class="form-control" required
                           value="<?php echo htmlspecialchars($tipoDocumento['tipo_docu_nombre']); ?>">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning me-2">
                        <i class="bi bi-pencil-square"></i> Actualizar
                    </button>
                    <a href="<?php echo getUrl('tipoDocumento', 'tipoDocumento', 'consult'); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                No se encontró el tipo de documento para editar.
            </div>
        <?php endif; ?>

    </div>
</div>
