<!-- ============================= -->
<!-- VISTA PARA REGISTRAR UNA MARCA -->
<!-- ============================= -->

<!-- Contenedor principal centrado -->
<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-- Tarjeta del formulario -->
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;">

        <!-- Título del formulario -->
        <h4 class="text-center text-primary fw-bold mb-3">
            <i class="bi bi-award-fill me-2"></i> Registrar Marca
        </h4>

        <!-- Nota de campos obligatorios -->
        <p class="text-muted text-center mb-4">
            Los campos marcados con <span class="text-danger fw-bold">*</span> son obligatorios.
        </p>

        <!-- Formulario -->
        <form action="<?= getUrl('marca', 'marca', 'postInsert'); ?>" method="POST" onsubmit="return validarMarca(event)">

            <!-- Campo: Nombre de la Marca -->
            <div class="mb-3">
                <label for="marca_nombre" class="form-label">
                    <i class="bi bi-tag-fill text-primary"></i> Nombre de la Marca <span class="text-danger">*</span>
                </label>
                <input type="text" name="marca_nombre" id="marca_nombre" class="form-control" placeholder="Ej: Lenovo, HP, Samsung" onchange="validarNombreMarca(this)">
                <div class="text-danger mt-1" id="error_marca_nombre"></div>
            </div>

            <!-- Campo: Descripción -->
            <div class="mb-3">
                <label for="marca_descripcion" class="form-label">
                    <i class="bi bi-card-text text-primary"></i> Descripción <small class="text-muted">(opcional)</small>
                </label>
                <textarea name="marca_descripcion" id="marca_descripcion" rows="3" class="form-control" placeholder="Información adicional sobre la marca..."  onchange="validarDescripcionMarca(this)">
                </textarea>
                <div class="text-danger mt-1" id="error_marca_descripcion"></div>
            </div>

            <!-- Botones -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save"></i> Guardar Marca
                </button>
                <a href="<?= getUrl('marca', 'marca', 'consult'); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancelar
                </a>
            </div>

        </form>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Inventario/Web/Js/validaciones/validaciones_config.js"></script>