<div class="container mt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <!-- Título -->
                    <h4 class="fw-bold text-info text-center mb-4">
                        <i class='bx bx-show-alt'></i> Detalle del Elemento
                    </h4>

                    <!-- Tipo de Elemento -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class='bx bx-list-check'></i> Tipo de Elemento
                            </label>
                            <div class="form-control bg-light"><?= $elemento['tipo_elemento'] ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class='bx bx-toggle-left'></i> Estado
                            </label>
                            <div class="form-control bg-light"><?= $elemento['estado'] ?></div>
                        </div>
                    </div>

                    <?php if (strtolower($elemento['tipo_elemento']) === 'devolutivo'): ?>
                        <!-- =============================== -->
                        <!-- CAMPOS: DEVOLUTIVO -->
                        <!-- =============================== -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-barcode'></i> Placa</label>
                                <div class="form-control bg-light"><?= $elemento['elem_placa'] ?? '---' ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-barcode-reader'></i> Serie</label>
                                <div class="form-control bg-light"><?= $elemento['elem_serie'] ?? '---' ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-purchase-tag'></i> Código</label>
                                <div class="form-control bg-light"><?= $elemento['elem_codigo'] ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-label'></i> Nombre</label>
                                <div class="form-control bg-light"><?= $elemento['elem_nombre'] ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-building-house'></i> Área</label>
                                <div class="form-control bg-light"><?= $elemento['area'] ?? '---' ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-category'></i> Categoría</label>
                                <div class="form-control bg-light"><?= $elemento['categoria'] ?? '---' ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-cube'></i> Modelo</label>
                                <div class="form-control bg-light"><?= $elemento['elem_modelo'] ?? '---' ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-paint'></i> Marca</label>
                                <div class="form-control bg-light"><?= $elemento['marca'] ?? '---' ?></div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- =============================== -->
                        <!-- CAMPOS: NO DEVOLUTIVO -->
                        <!-- =============================== -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-purchase-tag'></i> Código</label>
                                <div class="form-control bg-light"><?= $elemento['elem_codigo'] ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-label'></i> Nombre</label>
                                <div class="form-control bg-light"><?= $elemento['elem_nombre'] ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-layer'></i> Cantidad</label>
                                <div class="form-control bg-light"><?= $elemento['elem_cantidad'] ?></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class='bx bx-ruler'></i> Unidad de Medida</label>
                                <div class="form-control bg-light"><?= $elemento['unidad_medida'] ?? '---' ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- BOTÓN VOLVER -->
                    <div class="text-center mt-4">
                        <a href="<?= getUrl('elementos', 'elementos', 'consult') ?>" class="btn btn-secondary">
                            <i class='bx bx-arrow-back'></i> Volver al Listado
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>