<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <title>Finalizar préstamo</title>
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
                <i class="fas fa-clipboard-check" style="color:rgb(73, 110, 51);"></i> Finalizar reserva
            </h1>
            <form action="<?=getUrl("Reservas","Reservas","register")?>" method="post">
                <div class="form-group">
                    <label>Datos del usuario:</label>
                    <input type="text" class="form-control rounded-pill" value="<?php echo $usuario['usu_nombre'] . ' ' . $usuario['usu_apellido'] . ' /  CC:' . $usuario['usu_numero_docu']. ' /  Télefono: ' . $usuario['usu_telefono'].' / Correo electrónico: '. $usuario['usu_email']; ?>" readonly>
                </div>
                <?php foreach ($elementos as $index => $elemento): ?>
                <div class="form-group">
                    <label>Datos del elemento <?php /* echo $index + 1 */; ?>:</label>
                    <input type="text" class="form-control rounded-pill" value="<?php echo $elemento['elem_nombre'] . ' (' . $elemento['elem_serie'] . ') / Área: ' . $elemento['area_nombre'] . ' / Marca: ' . $elemento['marca_nombre']; ?>" readonly>
                </div>
                <input type="hidden" name="elem_nombre[]" value="<?php echo $elemento['elem_nombre']; ?>">
                <input type="hidden" name="elem_serie[]" value="<?php echo $elemento['elem_serie']; ?>">
                <input type="hidden" name="marca_id[]" value="<?php echo $elemento['elem_marca_id']; ?>">
                <input type="hidden" name="area_id[]" value="<?php echo $elemento['elem_area_id']; ?>">
                <?php endforeach; ?>
                <?php foreach ($_GET['elem_ids'] as $elemID): ?>
                    <input type="hidden" name="elementoID[]" value="<?php echo $elemID; ?>">
                <?php endforeach; ?>
                
                
                <div class="form-group">
                    <label>Fecha de entrega:</label>
                    <input type="date" class="form-control rounded-pill" name="fecha_entrega" required>
                </div>
                
                <div class="form-group">
                    <label>Fecha de  devolución:</label>
                    <input type="date" class="form-control rounded-pill" name="fecha_devolucion" required>
                </div>
                 <div class="form-group">
                    <label for="hora_entrega">Hora de entrega:</label>
                    <input type="time" class="form-control rounded-pill" id="hora_entrega" name="hora_entrega" required>
                </div>

                <div class="form-group">
                    <label for="hora_devolucion">Hora de devolución:</label>
                    <input type="time" class="form-control rounded-pill" id="hora_devolucion" name="hora_devolucion" required>
                </div>

                <div class="form-group">
                    <label>Observaciones:</label>
                    <textarea id="observaciones" name="observaciones" required class="form-control rounded" rows="4" placeholder="Escribe tus comentarios aquí..."></textarea>
                </div>
                <div class="form-group">
                    <label for="destino">Seleccionar un destino:</label>
                    <select class="form-control rounded-pill" id="destino" name="destino" required>
                        <option value="">Seleccione un destino por favor </option>
                        <?php foreach ($area_destino as $destino): ?>
                            <option value="<?php echo $destino['id_area_destino']; ?>">
                                <?php echo $destino['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" name="usuarioID" value="<?php echo $_GET['usu_id']; ?>">
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-5 py-2">
                        <i class="fas fa-check"></i> Finalizar préstamo
                    </button>
                    <a href="<?= getUrl('Reservas', 'Reservas', 'create'); ?>" class="btn btn-danger rounded-pill shadow-sm px-5 py-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>