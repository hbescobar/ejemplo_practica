<?php // Suponiendo que $usuarios y $destinos llegan desde el controlador 
?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary text-center mb-4">
                        <i class="bx bx-transfer-alt"></i> Registrar Préstamo
                    </h4>

                    <p class="text-muted small text-center mb-4">
                        <span class="text-danger">*</span> Campos obligatorios.
                    </p>

                    <div id="prestamoCarousel" class="carousel slide" data-bs-interval="false" data-bs-wrap="false">
                        <div class="carousel-inner">

                            <!-- Paso 1 -->
                            <div class="carousel-item active">
                                <form id="formPaso1" class="needs-validation" novalidate>
                                    <div class="row g-3">

                                        <!-- Usuario -->
                                        <div class="col-md-6">
                                            <label for="usu_id" class="form-label"><i class="bx bx-user"></i> Usuario <span class="text-danger">*</span></label>
                                            <select class="form-select" id="usu_id" name="usu_id" required>
                                                <option value="" selected disabled>Seleccione un usuario</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?= $usuario['usu_id'] ?>"
                                                        data-doc="<?= $usuario['usu_numero_docu'] ?? '' ?>"
                                                        data-email="<?= $usuario['usu_email'] ?? '' ?>">
                                                        <?= htmlspecialchars($usuario['usu_nombre'] . ' ' . $usuario['usu_apellido']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">Seleccione un usuario.</div>
                                        </div>

                                        <!-- Tipo de Elemento -->
                                        <div class="col-md-6">
                                            <label for="tipo_elemento" class="form-label"><i class="bx bx-cube"></i> Tipo de Elemento <span class="text-danger">*</span></label>
                                            <select class="form-select" id="tipo_elemento" required>
                                                <option value="" selected disabled>Seleccione tipo</option>
                                                <option value="1">Devolutivo</option>
                                                <option value="2">No Devolutivo</option>
                                            </select>
                                            <div class="invalid-feedback">Seleccione un tipo de elemento.</div>
                                        </div>

                                        <!-- Categorías -->
                                        <div class="col-12">
                                            <label for="cate_id" class="form-label"><i class="bx bx-category-alt"></i> Categoría <span class="text-danger">*</span></label>
                                            <select class="form-select" id="cate_id" name="cate_id[]" multiple required disabled>
                                                <option value="" disabled>Seleccione primero el tipo de elemento</option>
                                            </select>
                                            <div class="invalid-feedback">Seleccione al menos una categoría.</div>
                                        </div>

                                        <!-- Elementos disponibles -->
                                        <div class="col-12">
                                            <label class="form-label text-primary fw-semibold"><i class="bx bx-box"></i> Elementos disponibles</label>
                                            <div id="elementos-container" class="border rounded bg-light-subtle p-3">
                                                <p class="text-muted small mb-0">Seleccione una categoría para mostrar elementos.</p>
                                            </div>
                                        </div>

                                        <!-- Carrito de selección visual -->
                                        <div class="col-12 mt-3">
                                            <label class="form-label text-success fw-semibold"><i class="bx bx-cart"></i> Lista de elementos seleccionados</label>
                                            <div id="lista-seleccionados" class="d-flex flex-wrap gap-2"></div>
                                        </div>

                                    </div>

                                    <!-- Botón continuar -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-right-arrow-alt"></i> Continuar
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Paso 2 -->
                            <div class="carousel-item">
                                <form id="formPaso2" action="<?= getUrl('prestamos', 'prestamos', 'postInsert'); ?>" method="POST" class="needs-validation" novalidate>
                                    <h5 class="mb-3"><i class="bx bx-user"></i> Datos del Usuario</h5>
                                    <p id="infoUsuario" class="small text-muted mb-3"></p>

                                    <h5 class="mb-3"><i class="bx bx-box"></i> Elementos Seleccionados</h5>
                                    <ul id="infoElementos" class="small text-muted mb-3"></ul>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="fecha_prestamo" class="form-label"><i class="bx bx-calendar"></i> Fecha de Entrega <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="fecha_prestamo" name="fecha_prestamo" required>
                                            <div class="invalid-feedback">Seleccione la fecha.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="area_destino" class="form-label"><i class="bx bx-map"></i> Destino <span class="text-danger">*</span></label>
                                            <select class="form-select" id="area_destino" name="area_destino" required>
                                                <option value="" selected disabled>Seleccione un destino</option>
                                                <?php foreach ($destinos as $destino): ?>
                                                    <option value="<?= $destino['id_area_destino'] ?>"><?= htmlspecialchars($destino['nombre']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">Seleccione un destino.</div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label"><i class="bx bx-comment"></i> Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="(Opcional) Comentarios adicionales..."></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="btnVolver" class="btn btn-secondary">
                                            <i class="bx bx-arrow-back"></i> Volver
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-check"></i> Finalizar préstamo
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Boxicons + jQuery -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let elementosSeleccionados = {};
    let cantidadesSeleccionadas = {};

    $(document).on('input', 'input[name^="cantidades["]', function() {
    var id = $(this).closest('.form-check').find('input[type=checkbox][name="elementos[]"]').val();
    cantidadesSeleccionadas[id] = $(this).val();
    });

    function actualizarListaSeleccionados() {
        const contenedor = $('#lista-seleccionados');
        contenedor.empty();

        for (const id in elementosSeleccionados) {
            const nombre = elementosSeleccionados[id].nombre;
            const badge = $(`
                <div class="badge bg-primary d-flex align-items-center p-2 px-3 rounded-pill">
                    <span class="me-2">${nombre}</span>
                    <button type="button" class="btn-close btn-close-white btn-sm quitar-elemento" aria-label="Quitar" data-id="${id}"></button>
                </div>
            `);
            contenedor.append(badge);
        }
    }

    function agregarElemento(id, nombre, tipo) {
        elementosSeleccionados[id] = { nombre: nombre, tipo: tipo };
        actualizarListaSeleccionados();
    }

    function quitarElemento(id) {
        delete elementosSeleccionados[id];
        $(`input[name="elementos[]"][value="${id}"]`).prop('checked', false);
        actualizarListaSeleccionados();
    }

    // Al seleccionar/deseleccionar un checkbox de elemento
    $(document).on('change', 'input[name="elementos[]"]', function() {
    const id = $(this).val();
    const label = $(`label[for="${$(this).attr('id')}"]`).text().trim();
    const tipo = $(this).data('tipo');
    if ($(this).is(':checked')) {
        agregarElemento(id, label, tipo);
    } else {
        quitarElemento(id);
    }
});

    // Al hacer clic en la X del carrito
    $(document).on('click', '.quitar-elemento', function() {
        const id = $(this).data('id');
        quitarElemento(id);
    });

    // Mantener selección cuando cambias categorías sin borrar carrito
    function getSeleccionActual() {
        return {
            ...elementosSeleccionados
        };
    }

    function restaurarSeleccion() {
        for (const id in elementosSeleccionados) {
            const checkbox = $(`input[name="elementos[]"][value="${id}"]`);
            if (checkbox.length) {
                checkbox.prop('checked', true);
            }
        }
        actualizarListaSeleccionados();
    }

    // Cargar categorías según tipo (sin limpiar selección)
    $('#tipo_elemento').change(function() {
        const tipo_id = $(this).val();
        $('#cate_id').prop('disabled', true).html('<option disabled>Cargando...</option>');
        $('#elementos-container').html('<p class="text-muted">Seleccione una categoría para mostrar elementos.</p>');

        $.post('index.php?modulo=prestamos&controlador=prestamos&funcion=getCategoriasPorTipoElemento', {
            tipo_id
        }, function(data) {
            $('#cate_id').html(data).prop('disabled', false);
        });
    });

    // Cargar elementos por categoría (sin reiniciar carrito)
    $('#cate_id').change(function() {
        const cate_ids = $(this).val();
        const seleccionGuardada = getSeleccionActual();

        $.ajax({
            url: 'index.php?modulo=prestamos&controlador=prestamos&funcion=getElementosPorCategoria',
            type: 'POST',
            data: {
                cate_id: cate_ids
            },
            traditional: true,
            success: function(data) {
                $('#elementos-container').html(data);
                setTimeout(() => {
                    restaurarSeleccion();
                }, 100);
            },
            error: function() {
                $('#elementos-container').html('<p class="text-danger small">Error al cargar los elementos.</p>');
            }
        });
    });

    // Validación paso 1
    $('#formPaso1').submit(function(e) {
        e.preventDefault();

        if (!$('#usu_id').val()) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Seleccione un usuario.',
            confirmButtonColor: '#3085d6'
        });
        return;
        }

       if (Object.keys(elementosSeleccionados).length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Seleccione al menos un elemento.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // --- Validar que haya al menos un elemento devolutivo seleccionado ---
        let hayDevolutivo = false;
        for (const id in elementosSeleccionados) {
            if (elementosSeleccionados[id].tipo == 1) {
                hayDevolutivo = true;
                break;
            }
        }

        if (!hayDevolutivo) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Debe seleccionar al menos un elemento DEVOLUTIVO.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Insertar datos del usuario
        const usuario = $('#usu_id option:selected');
        $('#infoUsuario').html(`Nombre: <strong>${usuario.text()}</strong><br>Documento: <strong>${usuario.data('doc') || 'No registrado'}</strong><br>Correo: <strong>${usuario.data('email') || 'No registrado'}</strong>`);

        // Insertar lista de elementos seleccionados
        let html = '';
        for (const id in elementosSeleccionados) {
            let cantidad = cantidadesSeleccionadas[id] ? ` <span class="badge bg-info text-dark ms-2">Cantidad: ${cantidadesSeleccionadas[id]}</span>` : '';
            html += `<li>${elementosSeleccionados[id].nombre}${cantidad}</li>`;
        }
        $('#infoElementos').html(html);

        bootstrap.Carousel.getOrCreateInstance(document.getElementById('prestamoCarousel')).next();
    });

    // Volver al paso 1
    $('#btnVolver').click(function() {
        bootstrap.Carousel.getOrCreateInstance(document.getElementById('prestamoCarousel')).prev();
    });

    // Envío final paso 2
    $('#formPaso2').submit(function(e) {
    $(this).find('input[name="elementos[]"]').remove();
    $(this).find('input[name="usu_id"]').remove();

    for (const id in elementosSeleccionados) {
        $('#formPaso2').append(`<input type="hidden" name="elementos[]" value="${id}">`);
    }

    $('#formPaso2').append(`<input type="hidden" name="usu_id" value="${$('#usu_id').val()}">`);

    for (const id in cantidadesSeleccionadas) {
    if (elementosSeleccionados[id] && cantidadesSeleccionadas[id]) {
        $('#formPaso2').append(`<input type="hidden" name="cantidades[${id}]" value="${cantidadesSeleccionadas[id]}">`);
    }
    }

    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('was-validated');
    }
});
</script>