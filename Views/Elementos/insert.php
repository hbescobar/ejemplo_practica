<div class="container mt-5 pt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary text-center mb-3">
                        <i class='bx bx-package'></i> Registrar Elemento
                    </h4>

                    <p class="text-muted small text-center mb-4">
                        <span class="text-danger">*</span> Los campos con asterisco son obligatorios.
                    </p>

                    <form action="<?= getUrl("elementos", "elementos", "postInsert") ?>" method="POST" onsubmit="return validarElementos(event)">
                        <!-- Tipo de Elemento -->
                        <div class="mb-3">
                            <label for="tipoElementos" class="form-label">
                                <i class='bx bx-list-check'></i> Tipo de Elemento <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="elem_telem_id" id="tipoElementos" required>
                                <option value="" disabled selected>Selecciona el tipo de elemento</option>
                                <?php foreach ($tipoElementos as $tipo) { ?>
                                    <option value="<?= $tipo['telem_id'] ?>"><?= $tipo['telem_nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Devolutivo -->
                        <div id="grupoDevolutivo" class="d-none">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Placa del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_placa" class="form-control" placeholder="Ej: 922818451" onchange="validarPlaca(this)">
                                    <div class="text-danger mt-1" id="errorelem_placa"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Serie del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_serie" class="form-control" placeholder="Ej: S12345-XYZ" onchange="validarSerieElemento(this)">
                                    <div class="text-danger mt-1" id="errorelem_serie"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Código del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_codigo" class="form-control" placeholder="Ej: COD78910" onchange="validarCodElem(this)">
                                    <div class="text-danger mt-1" id="errorelem_codigo"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_nombre" class="form-control" placeholder="Ej: Computador portátil" onchange="validarNombreElem(this)">
                                    <div class="text-danger mt-1" id="errorelem_nombre"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Área <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_area_id">
                                        <option value="" disabled selected>Selecciona un área</option>
                                        <?php foreach ($area as $are) { ?>
                                            <option value="<?= $are['area_id'] ?>"><?= $are['area_nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Categoría <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_cate_id">
                                        <option value="" disabled selected>Selecciona una categoría</option>
                                        <?php foreach ($categoria as $catg) { ?>
                                            <option value="<?= $catg['cate_id'] ?>"><?= $catg['cate_nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Modelo <small class="text-muted">(opcional)</small></label>
                                    <input type="text" name="elem_modelo" class="form-control" placeholder="Ej: ThinkPad L14 Gen3" onchange="validarModeloElem(this)">
                                    <div class="text-danger mt-1" id="errorelem_modelo"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Marca <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_marca_id">
                                        <option value="" disabled selected>Selecciona una marca</option>
                                        <?php foreach ($marca as $mrc) { ?>
                                            <option value="<?= $mrc['marca_id'] ?>"><?= $mrc['marca_nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- Recomendaciones -->
                                <div class="mb-3">
                                    <label class="form-label">Recomendaciones <small class="text-muted">(opcional)</small></label>
                                    <textarea name="recomendaciones"
                                            class="form-control"
                                            rows="2"
                                            placeholder="Ej.: Recordar llevar memoria SD para usar la cámara"
                                            oninput="validarRecomendaciones(this)"
                                            maxlength="250"></textarea>
                                    <div class="text-danger mt-1" id="errorRecomDev"></div>
                                </div>
                            </div>
                        </div>

                        <!-- No Devolutivo -->
                        <div id="grupoNoDevolutivo" class="d-none">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Código del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_codigo" class="form-control" placeholder="Ej: COD456" onchange="validarCodElemNoDevo(this)">
                                    <div class="text-danger mt-1" id="errorelem_codigoNoDevo"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Categoría <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_cate_id">
                                        <option value="" disabled selected>Selecciona una categoría</option>
                                        <?php foreach ($categoria as $catg) { ?>
                                            <option value="<?= $catg['cate_id'] ?>"><?= $catg['cate_nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Elemento <span class="text-danger">*</span></label>
                                    <input type="text" name="elem_nombre" class="form-control" placeholder="Ej: Cinta adhesiva" onchange="validarNombreElemNoDevo(this)">
                                    <div class="text-danger mt-1" id="errorelem_nombre_NoDevo"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                    <input type="number" name="elem_cantidad" class="form-control" placeholder="Ej: 50" min="1" onchange="validarCant(this)">
                                    <div class="text-danger mt-1" id="errorelem_cantidad"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                                    <select class="form-select" name="elem_unidad_id">
                                        <option value="" disabled selected>Selecciona unidad</option>
                                        <?php foreach ($unidadMedida as $md) { ?>
                                            <option value="<?= $md['id_unidad_medidas'] ?>"><?= $md['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- Recomendaciones -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Recomendaciones <small class="text-muted">(opcional)</small>
                                    </label>
                                    <textarea name="recomendaciones"
                                            class="form-control"
                                            rows="2"
                                            placeholder="Ej.: Recordar llevar memoria SD para usar la cámara"
                                            oninput="validarRecomendaciones(this)"
                                            maxlength="250"></textarea>
                                    <div class="text-danger mt-1" id="errorRecomNo"></div>
                                </div>
                            </div>
                        </div>
                        
                        

                        <!-- Botones -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success me-2">
                                <i class='bx bx-save'></i> Guardar Elemento
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
<script src="/Inventario/Web/Js/validaciones/validaciones_elementos.js"></script>

<!-- Script para mostrar grupos según tipo -->
<script>
    const tipoElementos = document.getElementById('tipoElementos');
    const grupoDev = document.getElementById('grupoDevolutivo');
    const grupoNoDev = document.getElementById('grupoNoDevolutivo');

    function toggleFields(tipo) {
        const inputsDev = grupoDev.querySelectorAll("input, select, textarea");
        const inputsNo  = grupoNoDev.querySelectorAll("input, select, textarea");

        if (tipo === '1') {                 // DEVOLUTIVO
            grupoDev.classList.remove('d-none');
            grupoNoDev.classList.add  ('d-none');
            inputsDev.forEach(el => el.disabled = false);
            inputsNo .forEach(el => el.disabled = true );
        } else if (tipo === '2') {          // NO DEVOLUTIVO
            grupoNoDev.classList.remove('d-none');
            grupoDev.classList.add  ('d-none');
            inputsNo .forEach(el => el.disabled = false);
            inputsDev.forEach(el => el.disabled = true );
        } else {                            // ninguno seleccionado
            inputsDev.forEach(el => el.disabled = true );
            inputsNo .forEach(el => el.disabled = true );
            grupoDev.classList.add('d-none');
            grupoNoDev.classList.add('d-none');
        }
    }

    tipoElementos.addEventListener('change', () => {
        toggleFields(tipoElementos.value);
    });

    document.addEventListener('DOMContentLoaded', () => {
        toggleFields(tipoElementos.value);
    });
</script>