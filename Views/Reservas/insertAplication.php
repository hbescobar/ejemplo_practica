
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <title>Gestión de Préstamos</title>
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="p-5 rounded shadow-lg" style="background: linear-gradient(135deg, rgb(255, 255, 255), rgb(234, 238, 234)); border: 1px solid rgb(59, 105, 255); max-width: 800px; width: 100%;">
            <h1 class="text-center mb-4">
                <i class="fas fa-archive" style="color:rgb(73, 110, 51);"></i> Gestión de reservas
            </h1>

            <!-- Tabs -->
            <ul class="nav nav-tabs mt-4 justify-content-center border-0" id="myTab" role="tablist">
               
            </ul>

            <div class="tab-content mt-4" id="myTabContent">
                <!-- Tab Inicio -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row justify-content-center">
                            <!-- Card: Total -->
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body text-center" style="background: linear-gradient(135deg,rgb(197, 165, 118),rgb(222, 192, 93)); border-radius: 8px;">
                                        <h5 class="card-title text-white">Total de reservas activas</h5>
                                        <p class="card-text text-white font-weight-bold" id="totalSolicitudes" style="font-size: 1.5rem;">
                                            <?php echo $totalReservas; ?>
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-light rounded-pill shadow-sm px-5 py-2" data-toggle="modal" data-target="#crearSolicitudModal">
                            <i class="fas fa-edit"></i> Crear reserva
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="crearSolicitudModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crear</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alertContainer" class="mt-3"></div> 
                    <form id="crearSolicitudForm">
                        <div class="form-group">
                            <label for="usuarioID">Seleccionar usuario:</label>
                            <select class="form-control rounded-pill" id="usuarioID" name="usuarioID">
                                <option value="">Seleccione un usuario por favor</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?php echo $usuario['usu_id']; ?>">
                                        <?php echo $usuario['usu_nombre'] . ' ' . $usuario['usu_apellido']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoriaID">Seleccionar categoría:</label>
                            <select class="form-control rounded-pill" id="categoriaID" name="categoriaID">
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['cate_id']; ?>">
                                        <?php echo $categoria['cate_nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="elementoFiltro">Escribir referencia ó nombre del elemento</label>
                            <input type="text" class="form-control rounded-pill" id="elementoFiltro" placeholder="Escribe para buscar un elemento">
                        </div>
                        <div class="form-group">
                        <label for="elementoID">Seleccionar elementos:</label>
                        <div id="elementoID">
                                <?php foreach ($elementos as $elemento): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            name="elem_ids[]" 
                                            id="elem_<?php echo $elemento['elem_id']; ?>" 
                                            value="<?php echo $elemento['elem_id']; ?>" 
                                            data-categoria="<?php echo $elemento['elem_cate_id']; ?>" 
                                            data-telem-id="<?php echo $elemento['elem_telem_id']; ?>">
                                        <label class="form-check-label" for="elem_<?php echo $elemento['elem_id']; ?>">
                                            <?php echo $elemento['elem_nombre'] . ' ' . $elemento['elem_serie']; ?>
                                            <?php if ($elemento['elem_telem_id'] == 2): ?>
                                                <span class="badge badge-info ml-2">
                                                    Disponible: <?php echo $elemento['elem_cantidad']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </label>
                                        <!-- Campo de cantidad (oculto por defecto) -->
                                        <?php if ($elemento['elem_telem_id'] == 2): // 2 = Consumible ?>
                                            <input type="number" class="form-control mt-2 cantidad-input" 
                                                id="cantidad_<?php echo $elemento['elem_id']; ?>" 
                                                name="cantidad_<?php echo $elemento['elem_id']; ?>" 
                                                placeholder="Cantidad a consumir" 
                                                style="display: none;" 
                                                min="1"
                                                max="<?php echo $elemento['elem_cantidad']; ?>">
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" onclick="limpiarFormulario()">Cerrar</button>
                <button type="button" class="btn btn-light rounded-pill shadow-sm px-5 py-2" id="crearReservaBtn">
                    <i class="fas fa-edit"></i> Crear reserva
                </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <script src="../web/js/script.js"></script>         -->                   
    
    
    
    <script>
    $(document).ready(function () {
        
        $('#crearSolicitudForm').on('submit', function(e) {
            e.preventDefault();
        });
        
        $('#crearSolicitudForm').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                return false;
            }
        });

        
        $('#elementoID input[type="checkbox"]').change(function () {
            const telemID = $(this).data('telem-id'); 
            const cantidadInput = $(`#cantidad_${$(this).val()}`); 
            if ($(this).is(':checked') && telemID == 2) { 
                cantidadInput.show(); 
            } else {
                cantidadInput.hide(); 
                cantidadInput.val(''); 
            }
        });

        
        $('#crearReservaBtn').click(function () {
            const usuarioID = $('#usuarioID').val();
            const elementosSeleccionados = [];
            const cantidades = {};
            let error = false;
            let tipo1Seleccionados = 0; 

            $('#elementoID input[type="checkbox"]:checked').each(function () {
                const elementoID = $(this).val();
                const telemID = $(this).data('telem-id');
                const cantidadInput = $(`#cantidad_${elementoID}`);

                if (telemID == 2) {
                    const cantidad = parseInt(cantidadInput.val(), 10);

                    cantidades[elementoID] = cantidad; 
                } else {
                    elementosSeleccionados.push(elementoID); 
                    tipo1Seleccionados++;
                }
            });

            if (!usuarioID || (tipo1Seleccionados === 0)) {
                mostrarAlerta('Por favor, selecciona un usuario y al menos un elemento devolutivo.', 'danger');
                return;
            }

            // Construir la URL solo si los datos son válidos
            const urlBase = "<?php echo getUrl('Reservas', 'Reservas', 'finalizar'); ?>";
            const url = urlBase + `&usu_id=${usuarioID}&` +
                elementosSeleccionados.map(id => `elem_ids[]=${id}`).join('&') +
                (Object.keys(cantidades).length > 0 ? '&' + Object.entries(cantidades).map(([id, cantidad]) => `cantidades[${id}]=${cantidad}`).join('&') : '');

            window.location.href = url;
        });


        // Función para mostrar alertas
        function mostrarAlerta(mensaje, tipo) {
            const alerta = `
                <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                    ${mensaje}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('#alertContainer').html(alerta);
        }
    // Filtrar elementos por categoría seleccionada
    $('#categoriaID').change(function () {
        const categoriaSeleccionada = $(this).val();

        $('#elementoID .form-check').each(function () {
            const categoriaElemento = $(this).find('input').data('categoria');

            if (categoriaSeleccionada === '' || categoriaElemento == categoriaSeleccionada) {
                $(this).show(); // Mostrar si coincide o si no hay categoría seleccionada
            } else {
                $(this).hide(); // Ocultar si no coincide
            }
        });
    });

    // Filtrar elementos por texto ingresado
    $('#elementoFiltro').on('keyup', function () {
        const filtro = $(this).val().toLowerCase();

        $('#elementoID .form-check').each(function () {
            const textoElemento = $(this).find('label').text().toLowerCase();

            if (textoElemento.includes(filtro)) {
                $(this).show(); // Mostrar si coincide con el filtro
            } else {
                $(this).hide(); // Ocultar si no coincide
            }
        });
    });

    // Limpiar el formulario
    function limpiarFormulario() {
        const form = $('#crearSolicitudForm')[0];
        if (form) {
            form.reset();
        }
        $('#elementoFiltro').val('');
    }
    });
    </script>
</body>
</html>