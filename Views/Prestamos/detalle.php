<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <title>Detalle del préstamo</title>
</head>
<body>
    <div class="container py-5">
        <div class="p-5 rounded shadow-lg" style="background: linear-gradient(135deg, rgb(255, 255, 255), rgb(234, 238, 234)); 
            border: 1px solid rgb(59, 105, 255); 
            max-width: 800px; 
            width: 100%; 
            max-height: 500px; /* Altura máxima del cuadro */
            overflow-y: auto; /* Habilitar scroll vertical */">
            <h1 class="text-center mb-4">
                <i class="fas fa-edit" style="color:rgb(73, 110, 51);"></i> Detalle  préstamo
            </h1>
            
            <!-- Formulario principal para actualizar -->
            <form action="<?= getUrl("Prestamos", "Prestamos", "update"); ?>" method="post">
            <input type="hidden" name="id_prestamo" value="<?= $prestamo['id_prestamo']; ?>">

                <div class="form-group">
                    <label>Id préstamo:</label>
                    <input type="text" class="form-control rounded-pill" value="<?php echo $prestamo['id_prestamo']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nombre del solicitante:</label>
                    <input type="text" class="form-control rounded-pill" value="<?php echo $prestamo['nombre']. " ". $prestamo['apellido']. " / Teléfono: ".$prestamo['telefono']. " /Correo electrónico:  ". $prestamo['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label><strong>Checkea el elemento que deseas desagregar:</strong></label>
                </div>

                <?php foreach ($elementos as $elemento): ?>
                    <div class="form-group">
                        <label>Elemento relacionado:</label>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="eliminar_elementos[]" value="<?php echo $elemento['elem_id']; ?>" class="mr-2" disabled>
                            <input type="text" class="form-control rounded-pill" value="<?php echo $elemento['elem_nombre'] . " / Serie: " . $elemento['elem_serie'] . " / Marca: " . $elemento['marca_nombre'] . " / Área: " . $elemento['area_nombre']; ?>" readonly>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="form-group">
                    <label>Fecha de Solicitud:</label>
                    <input type="date" class="form-control rounded-pill" value="<?php echo $prestamo['fecha_solicitud']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="destino">Seleccionar un destino:</label>
                    <select class="form-control rounded-pill" id="destino" readonly name="destino" required>
                        <option value="">Destino</option>
                        <?php foreach ($area_destino as $destino): ?>
                            <option value="<?php echo $destino['id_area_destino']; ?>" 
                                <?php echo ($destino['id_area_destino'] == $prestamo['area_id']) ? 'selected' : ''; ?>>
                                <?php echo $destino['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Fecha de Devolución:</label>
                    <input type="date" class="form-control rounded-pill" name="fecha_devolucion" readonly value="<?php echo $prestamo['fecha_devolucion']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Observaciones:</label>
                    <textarea id="observaciones" name="observaciones"  readonly class="form-control rounded" rows="4" placeholder="Escribe tus comentarios aquí..."><?php echo $prestamo['observaciones']; ?></textarea>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= getUrl('Prestamos', 'Prestamos', 'consult'); ?>" class="btn btn-primary rounded-pill shadow-sm px-5 py-2">
                        <i class="fas fa-check"></i> Aceptar
                    </a>
                </div>
            </form>


    <!-- JS Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   
</body>
</html>