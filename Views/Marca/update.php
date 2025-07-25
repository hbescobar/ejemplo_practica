<!-- ============================= -->
<!-- VISTA PARA EDITAR UNA MARCA  -->
<!-- ============================= -->

<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta del formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-warning fw-bold mb-3">
            <i class="bi bi-award-fill me-2"></i> Editar Marca
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted text-center mb-4">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario -->
        <form action="<?= getUrl('marca', 'marca', 'postEdit'); ?>" method="post">

            <!-- ID oculto -->
            <input type="hidden" name="marca_id" value="<?= $marca['marca_id']; ?>">

            <!-- Campo: Nombre de la Marca -->
            <div class="mb-3">
                <label for="marca_nombre" class="form-label">
                    <i class="bi bi-tag-fill text-warning"></i> Nombre de la Marca <span class="text-danger">*</span>
                </label>
                <input type="text" name="marca_nombre" id="marca_nombre" class="form-control"
                    value="<?= htmlspecialchars($marca['marca_nombre']); ?>" required>
            </div>

            <!-- Campo: Descripción -->
            <div class="mb-3">
                <label for="marca_descripcion" class="form-label">
                    <i class="bi bi-card-text text-warning"></i> Descripción
                </label>
                <textarea name="marca_descripcion" id="marca_descripcion" rows="3" class="form-control"
                    placeholder="Información adicional sobre la marca..."><?= htmlspecialchars($marca['marca_descripcion']); ?></textarea>
            </div>

            <!-- Botones -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning me-2">
                    <i class="bi bi-arrow-repeat"></i> Actualizar Marca
                </button>
                <a href="<?= getUrl('marca', 'marca', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>
    </div>
</div>