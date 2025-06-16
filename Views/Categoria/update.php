<!-- ============================= -->
<!-- VISTA PARA EDITAR UNA CATEGORÍA -->
<!-- ============================= -->

<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta para el formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-warning fw-bold mb-3">
            <i class="bi bi-pencil-square me-2"></i> Editar Categoría
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted mb-4 text-center">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario -->
        <form action="<?= getUrl('categoria', 'categoria', 'postEdit'); ?>" method="POST">

            <!-- Campo oculto: ID de categoría -->
            <input type="hidden" name="cate_id" value="<?= $categoria['cate_id']; ?>">

            <!-- Campo: Nombre -->
            <div class="mb-3">
                <label for="cate_nombre" class="form-label">
                    <i class="bi bi-tag-fill text-warning"></i> Nombre de la Categoría <span class="text-danger">*</span>
                </label>
                <input type="text" name="cate_nombre" id="cate_nombre" class="form-control"
                       value="<?= htmlspecialchars($categoria['cate_nombre']); ?>"
                       placeholder="Ej: Herramientas" required>
            </div>

            <!-- Campo: Descripción -->
            <div class="mb-3">
                <label for="cate_descripcion" class="form-label">
                    <i class="bi bi-card-text text-warning"></i> Descripción
                </label>
                <textarea name="cate_descripcion" id="cate_descripcion" rows="3" class="form-control"
                          placeholder="Describe brevemente la categoría..."><?= htmlspecialchars($categoria['cate_descripcion']); ?></textarea>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning me-2">
                    <i class="bi bi-save"></i> Actualizar Categoría
                </button>
                <a href="<?= getUrl('categoria', 'categoria', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
