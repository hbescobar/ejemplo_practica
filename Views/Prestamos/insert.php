<?php
// Suponiendo que $usuarios, $categorias y $destinos llegan desde el controlador
?>

<div id="prestamoCarousel" class="carousel slide" data-bs-interval="false" data-bs-wrap="false">
    <div class="carousel-inner">

        <!-- Paso 1 -->
        <div class="carousel-item active">
            <div class="container mt-4 px-3" style="max-width: 720px;">
                <h3 class="mb-3 fw-semibold">Registrar Préstamo - Paso 1</h3>
                <form id="formPaso1" class="needs-validation" novalidate>
                    <!-- Select Usuario -->
                    <div class="mb-3">
                        <label for="usu_id" class="form-label">Usuario</label>
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

                    <!-- Select Categoría -->
                    <div class="mb-3">
                        <label for="cate_id" class="form-label">Categoría</label>
                        <select class="form-select" id="cate_id" name="cate_id" required>
                            <option value="" selected disabled>Seleccione una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['cate_id'] ?>">
                                    <?= htmlspecialchars($categoria['cate_nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Seleccione una categoría.</div>
                    </div>

                    <!-- Elementos disponibles -->
                    <fieldset class="mb-4">
                        <legend class="fs-6 fw-semibold">Elementos disponibles</legend>
                        <div id="elementos-container" class="ps-2">
                            <p class="text-muted small">Seleccione una categoría para mostrar elementos.</p>
                        </div>
                    </fieldset>

                    <button type="submit" class="btn btn-primary">Continuar</button>
                </form>
            </div>
        </div>

        <!-- Paso 2 -->
        <div class="carousel-item">
            <div class="container mt-4 px-3" style="max-width: 720px;">
                <h3 class="mb-3 fw-semibold">Finalizar Préstamo - Paso 2</h3>
                <form id="formPaso2" action="<?php echo getUrl('prestamos', 'prestamos', 'postInsert'); ?>" method="POST" class="needs-validation" novalidate>

                    <!-- Info Usuario -->
                    <h5 class="mb-2">Datos del Usuario</h5>
                    <p id="infoUsuario" class="small text-muted mb-3"></p>

                    <!-- Info Elementos -->
                    <h5 class="mb-2">Datos del Elemento</h5>
                    <ul id="infoElementos" class="small text-muted mb-3"></ul>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="fecha_prestamo" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control" id="fecha_prestamo" name="fecha_prestamo" required>
                            <div class="invalid-feedback">Seleccione la fecha.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="area_destino" class="form-label">Destino</label>
                            <select class="form-select" id="area_destino" name="area_destino" required>
                                <option value="" selected disabled>Seleccione un destino</option>
                                <?php foreach ($destinos as $destino): ?>
                                    <option value="<?= $destino['id_area_destino'] ?>">
                                        <?= htmlspecialchars($destino['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div class="invalid-feedback">Seleccione un destino.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="btnVolver" class="btn btn-secondary">Volver</button>
                        <button type="submit" class="btn btn-success">Finalizar préstamo</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })();

    $('#cate_id').change(function() {
        var cate_id = $(this).val();
        $.ajax({
            url: 'index.php?modulo=prestamos&controlador=prestamos&funcion=getElementosPorCategoria',
            type: 'POST',
            data: {
                cate_id: cate_id
            },
            success: function(data) {
                $('#elementos-container').html(data);
            },
            error: function() {
                $('#elementos-container').html('<p class="text-danger small">Error al cargar los elementos.</p>');
            }
        });
    });

    $('#formPaso1').submit(function(e) {
        e.preventDefault();

        if ($('input[name="elementos[]"]:checked').length === 0) {
            alert('Seleccione al menos un elemento.');
            return;
        }

        var usuarioSelect = $('#usu_id option:selected');
        var nombre = usuarioSelect.text();
        var documento = usuarioSelect.data('doc') || 'No registrado';
        var email = usuarioSelect.data('email') || 'No registrado';

        $('#infoUsuario').html(`Nombre: <strong>${nombre}</strong><br>Documento: <strong>${documento}</strong><br>Correo: <strong>${email}</strong>`);

        var infoElementos = '';
        $('input[name="elementos[]"]:checked').each(function() {
            var label = $('label[for="' + $(this).attr('id') + '"]').text();
            infoElementos += `<li>${label}</li>`;
        });
        $('#infoElementos').html(infoElementos);

        var carousel = bootstrap.Carousel.getInstance(document.getElementById('prestamoCarousel')) ||
            new bootstrap.Carousel(document.getElementById('prestamoCarousel'), {
                interval: false,
                wrap: false
            });
        carousel.next();
    });

    $('#btnVolver').click(function() {
        var carousel = bootstrap.Carousel.getInstance(document.getElementById('prestamoCarousel')) ||
            new bootstrap.Carousel(document.getElementById('prestamoCarousel'), {
                interval: false,
                wrap: false
            });
        carousel.prev();
    });

    // *** Aquí el nuevo código para enviar los elementos al formPaso2 ***
    $('#formPaso2').submit(function(e) {
        // Limpiar inputs hidden previos para evitar duplicados
        $(this).find('input[name="elementos[]"]').remove();

        // Agregar inputs hidden con elementos seleccionados
        $('input[name="elementos[]"]:checked').each(function() {
            var val = $(this).val();
            $('#formPaso2').append('<input type="hidden" name="elementos[]" value="' + val + '">');
        });

        // Validar el form (Bootstrap)
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }
    });
</script>