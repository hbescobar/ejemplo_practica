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
    
    
    
    // Mostrar el nombre del archivo seleccionado
    $('#archivoUsuarios').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        var extension = fileName.split('.').pop().toLowerCase();
        if (extension !== 'csv') {
        $('#nombreArchivo').text('Elegir archivo');
        $(this).val('');
        alert('El archivo seleccionado no es compatible. Solo se permiten archivos .csv');
        return;
        }

        $('#nombreArchivo').text(fileName);
    });



    $('#btnExaminar').on('click', function() {
        // Define los campos que quieres en la plantilla
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
        // Puedes agregar una fila de ejemplo si lo deseas
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
        let csvContent = encabezados.join(',') ;

        // Crear un blob y descargarlo
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = 'plantilla_usuarios.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });


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
        url: '<?= getUrl("Carga", "Carga", "procesarUsuarios") ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(respuesta)  {
            if (respuesta.indexOf('correctamente') !== -1) {
                alert("Carga exitosa");
                $('#formCargaUsuarios')[0].reset();
                $('#nombreArchivo').text('Elegir archivo');
            } else {
                alert(
                    "Error en la carga. Por favor revisa que:\n" +
                    "- Todos los campos requeridos estén diligenciados\n" +
                    "- No existan datos duplicados (como identificaciones o correos)\n" +
                    "- Los valores de claves foráneas (como rol,tipo de documento, estado del usuario) sean correctos"
                );
                $('#formCargaUsuarios')[0].reset();
                $('#nombreArchivo').text('Elegir archivo');
            }
        },
        error: function(xhr, status, error) {
            console.log("Estado:", status);
            console.log("Error:", error);
            console.log("Respuesta del servidor:", xhr.responseText);
            alert("Respuesta inesperada del servidor:\n" + status);
        }
    });
});


    </script>