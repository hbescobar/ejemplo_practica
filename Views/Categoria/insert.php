<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta para el formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-primary fw-bold mb-3">
            <i class="bi bi-tags-fill me-2"></i> Registrar Categoría
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted mb-4 text-center">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario -->
        <form action="<?= getUrl('categoria', 'categoria', 'postInsert'); ?>" method="POST">

            <!-- Campo: Nombre -->
            <div class="mb-3">
                <label for="cate_nombre" class="form-label">
                    <i class="bi bi-tag-fill text-primary"></i> Nombre <span class="text-danger">*</span>
                </label>
                <input type="text" name="cate_nombre" id="cate_nombre" class="form-control"
                    placeholder="Ej: Electrónica" required>
            </div>

            <!-- Campo: Descripción -->
            <div class="mb-3">
                <label for="cate_descripcion" class="form-label">
                    <i class="bi bi-card-text text-primary"></i> Descripción
                </label>
                <textarea name="cate_descripcion" id="cate_descripcion" rows="3" class="form-control"
                    placeholder="Breve descripción de la categoría..."></textarea>
            </div>

            <!-- Campo: Tipo de Elemento -->
            <div class="mb-3">
                <label for="telem_id" class="form-label">
                    <i class="bi bi-list-ol text-primary"></i> Tipo de Elemento <span class="text-danger">*</span>
                </label>
                <select name="telem_id" id="telem_id" class="form-select" required>
                    <option value="" selected disabled>Selecciona una opción</option>
                    <?php foreach ($tipos_elemento as $tipo): ?>
                        <option value="<?= $tipo['telem_id'] ?>">
                            <?= htmlspecialchars($tipo['telem_nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save-fill"></i> Guardar Categoría
                </button>
                <a href="<?= getUrl('categoria', 'categoria', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>