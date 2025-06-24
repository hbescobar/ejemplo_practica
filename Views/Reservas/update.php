<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <title>Actualizar préstamo</title>
</head>
<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="p-5 rounded shadow-lg" style="background: linear-gradient(135deg, rgb(255, 255, 255), rgb(234, 238, 234)); 
            border: 1px solid rgb(59, 105, 255); 
            max-width: 800px; 
            width: 100%; 
            max-height: 500px; /* Altura máxima del cuadro */
            overflow-y: auto; /* Habilitar scroll vertical */">
            <h1 class="text-center mb-4">
                <i class="fas fa-edit" style="color:rgb(73, 110, 51);"></i> Actualizar reserva
            </h1>
            <!-- Formulario principal para actualizar -->
            <form action="<?= getUrl("Reservas", "Reservas", "update"); ?>" method="post">
            <input type="hidden" name="id_reserva" value="<?= $reserva['reserva_id']; ?>">

                <div class="form-group">
                    <label>Id reserva:</label>
                    <input type="text" class="form-control rounded-pill" value="<?php echo $reserva['reserva_id']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nombre del solicitante:</label>
                    <input type="text" class="form-control rounded-pill" value="<?php echo $reserva['nombre']. " ". $reserva['apellido']. " / Teléfono: ".$reserva['telefono']. " /Correo electrónico:  ". $reserva['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label><strong>Checkea el elemento que deseas desagregar:</strong></label>
                </div>

                <?php foreach ($elementos as $elemento): ?>
                    <div class="form-group">
                        <label>Elemento relacionado:</label>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="eliminar_elementos[]" value="<?php echo $elemento['elem_id']; ?>" class="mr-2">
                            <input type="text" class="form-control rounded-pill" value="<?php echo $elemento['elem_nombre'] . " / Serie: " . $elemento['elem_serie'] . " / Marca: " . $elemento['marca_nombre'] . " / Área: " . $elemento['area_nombre']; ?>" readonly>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="form-group">
                    <label>Fecha de solicitud:</label>
                    <input type="date" class="form-control rounded-pill" name="reserva_fecha_solicitud" value="<?php echo $reserva['reserva_fecha_solicitud']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Fecha de entrega:</label>
                    <input type="date" class="form-control rounded-pill" name="reserva_fecha_entrega" value="<?php echo $reserva['reserva_fecha_entrega']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="destino">Seleccionar un destino:</label>
                    <select class="form-control rounded-pill" id="destino" name="destino" required>
                        <option value="">Seleccione un destino por favor</option>
                        <?php foreach ($area_destino as $destino): ?>
                            <option value="<?php echo $destino['id_area_destino']; ?>" 
                                <?php echo ($destino['id_area_destino'] == $reserva['reserva_area_id']) ? 'selected' : ''; ?>>
                                <?php echo $destino['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Observaciones:</label>
                    <textarea id="observaciones" name="observaciones" class="form-control rounded" rows="4" placeholder="Escribe tus comentarios aquí..."><?php echo $reserva['reserva_observaciones']; ?></textarea>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning btn-sm mb-1">
                        <i class="fas fa-edit"></i> Modificar
                    </button>
                    <a href="<?= getUrl('Reservas', 'Reservas', 'consult'); ?>" class="btn btn-danger rounded-pill shadow-sm px-5 py-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>

            <!-- Botón para abrir el modal -->
            <button type="button" class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#adicionarModal">
                <i class="fas fa-plus"></i> Adicionar elemento
            </button>

            <!-- Modal -->
            <div class="modal fade" id="adicionarModal" tabindex="-1" aria-labelledby="adicionarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Formulario independiente para adicionar -->
                        <form action="<?= getUrl('Reservas', 'Reservas', 'adicionar'); ?>" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="adicionarModalLabel">Adicionar reserva</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="reserva_id" value="<?= $reserva['reserva_id']; ?>">
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
                                        <?php foreach ($elementosNew as $elemento): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="elem_ids[]" id="elem_<?php echo $elemento['elem_id']; ?>" value="<?php echo $elemento['elem_id']; ?>" data-categoria="<?php echo $elemento['elem_cate_id']; ?>"<?php if ($elemento['elem_telem_id'] == 2) echo 'disabled'; ?>>
                                                <label class="form-check-label" for="elem_<?php echo $elemento['elem_id']; ?>">
                                                    <?php echo $elemento['elem_nombre'] . ' ' . $elemento['elem_serie']; ?>
                                                </label>
                                                 
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-info">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>                                       
    <script>




        $(document).ready(function () {
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
        });
        
        
        
        
        $(document).ready(function () {
        $('#adicionarModal button[type="submit"]').click(function (event) {
            event.preventDefault(); 



            const idReserva = $('input[name="reserva_id"]').val(); 

            const elementosSeleccionados = [];

            
            $('#elementoID input[type="checkbox"]:checked').each(function () {
                elementosSeleccionados.push($(this).val());
            });

            console.log('Elementos seleccionados:', elementosSeleccionados); // Verificar los elementos seleccionados en la consola

            // Validar si los campos están vacíos
            if (elementosSeleccionados.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor selecciona al menos un elemento.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Construir la URL para redirigir
            const url = `<?= getUrl('Reservas', 'Reservas', 'adicionar') ?>&reserva_id=${idReserva}&` +
                elementosSeleccionados.map(id => `elem_ids[]=${id}`).join('&');

            console.log('URL generada:', url); 
            window.location.href = url; 
        });   
    });

    </script>
</body>
</html>