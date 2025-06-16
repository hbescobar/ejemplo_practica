<div class="container" style="margin-top: 100px; max-width: 480px;">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Cargar Usuarios</h3>

        <form id="formCargaUsuarios" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="archivoUsuarios" class="form-label fw-semibold">Selecciona un archivo:</label>
                <input
                    type="file"
                    class="form-control"
                    id="archivoUsuarios"
                    name="archivoUsuarios"
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

<script>
    // Mostrar el nombre del archivo seleccionado y validar extensión
    $('#archivoUsuarios').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        var extension = fileName.split('.').pop().toLowerCase();

        if (extension !== 'csv') {
            alert('El archivo seleccionado no es compatible. Solo se permiten archivos .csv');
            $(this).val('');
            return;
        }

        // No necesitamos cambiar label porque el input file ya muestra el nombre
        // Si quieres mostrarlo en otro lado, lo puedes hacer aquí
    });

    // Descargar plantilla CSV
    $('#btnExaminar').on('click', function() {
        const encabezados = [
            'nombre',
            'apellido',
            'telefono',
            'clave',
            'identificacion',
            'email',
            'rol_id',
            'tipo_documento',
            'estado',
            'direccion'
        ];

        // Ejemplo para la plantilla (opcional)
        const ejemplo = [
            'Juan',
            'Pérez',
            '3103683021',
            '123',
            '1107104715',
            'nicola.fernandez@gmail.com',
            '1',
            '1',
            '1',
            'Calle 14C34 58 ejemplo'
        ];

        // Crear CSV con encabezados + ejemplo
        let csvContent = encabezados.join(',') + '\n' + ejemplo.join(',');

        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = 'plantilla_usuarios.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });

    // Manejar el envío del formulario con Ajax
    $('#formCargaUsuarios').on('submit', function(e) {
        e.preventDefault();

        var archivo = $('#archivoUsuarios')[0].files[0];
        if (!archivo) {
            alert('Por favor selecciona un archivo .csv');
            return;
        }

        var formData = new FormData();
        formData.append('archivoUsuarios', archivo);

        $.ajax({
            url: '<?= getUrl("Carga", "Carga", "procesarUsuarios") ?>', // Ajusta esta URL a la correcta
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(respuesta) {
                if (respuesta.indexOf('correctamente') !== -1) {
                    alert("Carga exitosa");
                    $('#formCargaUsuarios')[0].reset();
                } else {
                    alert(
                        "Error en la carga. Por favor revisa que:\n" +
                        "- Todos los campos requeridos estén diligenciados\n" +
                        "- No existan datos duplicados (como identificaciones o correos)\n" +
                        "- Los valores de claves foráneas (como rol, tipo de documento, estado del usuario) sean correctos"
                    );
                    $('#formCargaUsuarios')[0].reset();
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