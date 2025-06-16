<!-- ======================================= -->
<!-- VISTA: Actualizar Elemento (update.php) -->
<!-- ======================================= -->

<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <!-- Título -->
                    <h4 class="fw-bold text-warning text-center mb-3">
                        <i class='bx bx-edit-alt'></i> Editar Elemento
                    </h4>

                    <!-- Nota campos obligatorios -->
                    <p class="text-muted small text-center mb-4">
                        <span class="text-danger">*</span> Los campos con asterisco son obligatorios.
                    </p>

                    <!-- Formulario -->
                    <form action="<?= getUrl("elementos", "elementos", "postEdit") ?>" method="POST">
                        <input type="hidden" name="elem_id" value="<?= $elemento['elem_id'] ?>">

                        <!-- Tipo de Elemento (no editable) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class='bx bx-category'></i> Tipo de Elemento
                            </label>
                            <div class="form-control bg-light"><?= $elemento['tipo_elemento'] ?></div>
                            <input type="hidden" name="elem_telem_id" value="<?= $elemento['elem_telem_id'] ?>">
                        </div>

                        <!-- =============== -->
                        <!-- Devolutivo -->
                        <!-- =============== -->
                        <?php if (strtolower($elemento['tipo_elemento']) === 'devolutivo'): ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Placa del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_placa" class="form-control" value="<?= $elemento['elem_placa'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Serie del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_serie" class="form-control" value="<?= $elemento['elem_serie'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Código del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_codigo" class="form-control" value="<?= $elemento['elem_codigo'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_nombre" class="form-control" value="<?= $elemento['elem_nombre'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Área <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_area_id" required>
                                        <option value="" disabled>Selecciona un área</option>
                                        <?php foreach ($area as $a): ?>
                                            <option value="<?= $a['area_id'] ?>" <?= $a['area_nombre'] == $elemento['area'] ? 'selected' : '' ?>>
                                                <?= $a['area_nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Categoría <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_cate_id" required>
                                        <option value="" disabled>Selecciona una categoría</option>
                                        <?php foreach ($categoria as $c): ?>
                                            <option value="<?= $c['cate_id'] ?>" <?= $c['cate_nombre'] == $elemento['categoria'] ? 'selected' : '' ?>>
                                                <?= $c['cate_nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Modelo <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_modelo" class="form-control" value="<?= $elemento['elem_modelo'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Marca <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_marca_id" required>
                                        <option value="" disabled>Selecciona una marca</option>
                                        <?php foreach ($marca as $m): ?>
                                            <option value="<?= $m['marca_id'] ?>" <?= $m['marca_nombre'] == $elemento['marca'] ? 'selected' : '' ?>>
                                                <?= $m['marca_nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- ================ -->
                            <!-- No Devolutivo -->
                            <!-- ================ -->
                        <?php else: ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Código del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_codigo" class="form-control" value="<?= $elemento['elem_codigo'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_nombre" class="form-control" value="<?= $elemento['elem_nombre'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                    <input type="number" name="elem_cantidad" class="form-control" value="<?= $elemento['elem_cantidad'] ?>" min="1" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_unidad_id" required>
                                        <option value="" disabled>Selecciona unidad</option>
                                        <?php foreach ($unidadMedida as $um): ?>
                                            <option value="<?= $um['id_unidad_medidas'] ?>" <?= $um['nombre'] == $elemento['unidad_medida'] ? 'selected' : '' ?>>
                                                <?= $um['nombre'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- ============ -->
                        <!-- Botones -->
                        <!-- ============ -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning me-2">
                                <i class='bx bx-refresh'></i> Actualizar Elemento
                            </button>
                            <a href="<?= getUrl('elementos', 'elementos', 'consult'); ?>" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>