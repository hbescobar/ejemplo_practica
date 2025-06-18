<?php
// Suponiendo que $usuarios, $categorias y $destinos llegan desde el controlador
?>

<div id="prestamoCarousel" class="carousel slide" data-bs-interval="false" data-bs-wrap="false">
    <div class="carousel-inner">

        <!-- Paso 1 -->
        <div class="carousel-item active">
            <div class="container mt-4 px-3" style="max-width: 720px;">
                <h3 class="mb-3 fw-semibold">Registrar préstamo - Paso 1</h3>
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
                        <select class="form-select" id="cate_id" name="cate_id[]" multiple required>
                            <option value="" disabled>Seleccione una o más categorías</option>
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
<style>
    body {
        background: linear-gradient(120deg, #f8fafc 0%,rgb(255, 255, 255) 100%);
        min-height: 18vh;
    }
    #prestamoCarousel {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(60, 72, 88, 0.15);
        padding-bottom: 60px;
        margin-top: 20px;
    }
    .carousel-item {
        border-radius: 18px;
    }
    h3 {
        color:rgb(76, 114, 188);
    }
    .form-label {
        color: #6366f1;
        font-weight: 600;
    }
    .form-select, .form-control, textarea {
        border-radius: 8px;
        border-color: #a5b4fc;
    }
    .btn-primary {
        background: #6366f1;
        border: none;
    }
    .btn-primary:hover {
        background: #4f46e5;
    }
    .btn-success {
        background: #22c55e;
        border: none;
    }
    .btn-success:hover {
        background: #16a34a;
    }
    .btn-secondary {
        background: #64748b;
        border: none;
    }
    .btn-secondary:hover {
        background: #334155;
    }
    fieldset {
        border-left: 4px solid #6366f1;
        padding-left: 12px;
        background: #f1f5f9;
        border-radius: 8px;
    }
    legend {
        color: #6366f1;
    }
</style>

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

    function getSeleccionActual() {
    let seleccion = {};
    $('input[name="elementos[]"]:checked').each(function() {
        let id = $(this).val();
        let cantidad = $('input[name="cantidades[' + id + ']"]').val() || '';
        seleccion[id] = cantidad;
    });
    return seleccion;
}

// Restaura los elementos seleccionados y cantidades después de recargar
function restaurarSeleccion(seleccion) {
    for (let id in seleccion) {
        let checkbox = $('input[name="elementos[]"][value="' + id + '"]');
        if (checkbox.length) {
            checkbox.prop('checked', true);
            let input = $('input[name="cantidades[' + id + ']"]');
            if (input.length) {
                input.prop('disabled', false).val(seleccion[id]);
            }
        }
    }
}

$('#cate_id').change(function() {
    let cate_ids = $(this).val();
    let seleccion = getSeleccionActual(); // Guarda selección actual

    $.ajax({
        url: 'index.php?modulo=prestamos&controlador=prestamos&funcion=getElementosPorCategoria',
        type: 'POST',
        data: { cate_id: cate_ids },
        traditional: true,
        success: function(data) {
            $('#elementos-container').html(data);
            restaurarSeleccion(seleccion); // Restaura selección después de recargar
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
    $(this).find('input[name="usu_id"]').remove();

    // Agregar inputs hidden con elementos seleccionados
    $('input[name="elementos[]"]:checked').each(function() {
        var val = $(this).val();
        $('#formPaso2').append('<input type="hidden" name="elementos[]" value="' + val + '">');
    });

    // Agregar input hidden con el usuario seleccionado
    var usu_id = $('#usu_id').val();
    $('#formPaso2').append('<input type="hidden" name="usu_id" value="' + usu_id + '">');

    // Validar el form (Bootstrap)
    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('was-validated');
        return;
    }
    });
</script>