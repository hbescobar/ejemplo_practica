<div class="container" style="margin-top: 100px; max-width: 480px;">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Cargar elementos</h3>

        <form id="formCargaElementos" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="archivoElementos" class="form-label fw-semibold">Selecciona un archivo:</label>
                <input
                    type="file"
                    class="form-control"
                    id="archivoElementos"
                    name="archivoElementos"
                    accept=".csv"
                    required>
                <div class="form-text">Solo archivos con extensión <code>.csv</code> son permitidos.</div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary px-4">Cargar</button>
                <button type="button" class="btn btn-secondary px-4" id="btnExaminar">Descargar plantilla CSV</button>
            </div>
        </form>
    </div>
</div>

<!-- jQuery (para el JS que usas) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Validar y mostrar nombre del archivo (opcional, Bootstrap 5 muestra automáticamente el nombre)
    $('#archivoElementos').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        var extension = fileName.split('.').pop().toLowerCase();

        if (extension !== 'csv') {
            alert('El archivo seleccionado no es compatible. Solo se permiten archivos .csv');
            $(this).val('');
            return;
        }
    });

    $('#btnExaminar').on('click', function() {
        const encabezados = [
            'placa',
            'serie',
            'codigo',
            'nombre',
            'tipo_elemento',
            'area',
            'categoria',
            'cantidad',
            'unidad_medida',
            'modelo',
            'marca',
            'estado'
        ];

        let csvContent = encabezados.join(',');

        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = 'plantilla_elementos.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    $('#formCargaElementos').on('submit', function(e) {
        e.preventDefault();

        var archivo = $('#archivoElementos')[0].files[0];
        if (!archivo) {
             Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor selecciona un archivo csv.',
            confirmButtonColor: '#3085d6'
    });
    return;
        }

        var formData = new FormData();
        formData.append('archivoElementos', archivo);

        $.ajax({
            url: '<?= getUrl("Carga", "Carga", "procesarElementos") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(respuesta) {
                if (respuesta.indexOf('correctamente') !== -1) {
                    Swal.fire({
                    icon: 'success',
                    title: '¡Carga exitosa!',
                    text: 'Los elementos  se cargaron correctamente.',
                    confirmButtonColor: '#3085d6'
                });
                $('#formCargaElementos')[0].reset();
                } else {
                     Swal.fire({
                    icon: 'warning',
                    title: '¡Carga fallida!',
                    text: 'Por favor dirigirse al control de errores de carga masiva.',
                    confirmButtonColor: '#3085d6'
                    });
                    $('#formCargaElementos')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                console.error("Estado:", status);
                console.error("Error:", error);
                console.error("Respuesta del servidor:", xhr.responseText);
                alert("Respuesta inesperada del servidor:\n" + status);
            }
        });
    });
</script>