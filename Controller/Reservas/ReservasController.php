<?php
// ==============================
// CONTROLADOR DE RESERVAS
// ==============================

include_once 'C:\xampp\htdocs\inventario\Model\Reservas\ReservasModel.php';

class ReservasController 
{
    private $model;

    public function __construct()
    {
        $this->model = new ReservasModel();
    }

    public function getInsert()
    {

        $usuarios = $this->model->obtenerUsuariosActivos();
        $categorias = $this->model->obtenerCategorias();
        $elementos = $this->model->obtenerElementosDisponibles();
        $destinos = $this->model->obtenerAreasDestino();

        require_once 'C:\xampp\htdocs\inventario\Views\Reservas\insert.php';
    }



     // ==============================
    // OBTENER ELEMENTOS POR CATEGORÍA (AJAX)
    // ==============================
    public function getElementosPorCategoria()
    {
        if (isset($_POST['cate_id'])) {
            $cate_ids = $_POST['cate_id'];
            if (!is_array($cate_ids)) {
                $cate_ids = [$cate_ids];
            }
            $elementos = $this->model->obtenerElementosPorCategorias($cate_ids);

            if (!empty($elementos)) {
                foreach ($elementos as $elem) {
                    echo '<div class="form-check mb-2">';
                    echo '<input class="form-check-input" type="checkbox" name="elementos[]" value="' . $elem['elem_id'] . '" id="elem_' . $elem['elem_id'] . '">';
                    echo '<label class="form-check-label" for="elem_' . $elem['elem_id'] . '">';
                    echo htmlspecialchars($elem['elem_nombre']) . ' (Placa: ' . htmlspecialchars($elem['elem_placa']) . ', Serie: ' . htmlspecialchars($elem['elem_serie']) . ')';
                    if (isset($elem['elem_telem_id']) && $elem['elem_telem_id'] == 2) {
                        echo ' <span class="badge bg-info text-dark ms-2">Disponible: ' . intval($elem['elem_cantidad']) . '</span>';
                        echo '<input type="number" class="form-control d-inline-block ms-2" style="width:100px;" ';
                        echo 'name="cantidades[' . $elem['elem_id'] . ']" min="1" max="' . intval($elem['elem_cantidad']) . '" ';
                        echo 'placeholder="Cantidad" disabled>';
                    }
                    echo '</label></div>';
                }
                // Script para habilitar/deshabilitar la caja de texto según el checkbox
                echo '<script>
                    $(function(){
                        $("input[type=checkbox][name=\'elementos[]\']").change(function(){
                            var id = $(this).val();
                            var input = $("input[name=\'cantidades[" + id + "]\']");
                            if($(this).is(":checked")){
                                input.prop("disabled", false).focus();
                            } else {
                                input.prop("disabled", true).val("");
                            }
                        });
                    });
                </script>';
            } else {
                echo '<p class="text-warning">No hay elementos disponibles en estas categorías.</p>';
            }
        } else {
            echo '<p class="text-danger">Categoría no recibida.</p>';
        }

        exit;
    }
    


    public function finalizar()
    {
   
    $usuarioID = $_GET['usu_id'] ?? null;
    $elementosIDs = $_GET['elem_ids'] ?? [];
    
    
    $cantidades = $_GET['cantidades'] ?? [];


    
    foreach ($cantidades as $elemID => $cantidadSolicitada) {
        
        $sql = "SELECT elem_cantidad FROM elementos_inventario WHERE elem_id = " . intval($elemID);
        $result = $this->model->sentencia($sql);
        $row = mysqli_fetch_assoc($result);
        $cantidadDisponible = $row['elem_cantidad'] ?? 0;

        if ($cantidadSolicitada > $cantidadDisponible) {
            $this->showSweetAlert(
            'error',
            'Cantidad excedida',
            "La cantidad solicitada ($cantidadSolicitada) para el elemento $elemID es mayor a la disponible ($cantidadDisponible).",
            "javascript:window.history.back();"
        );
        exit;
        }

        
    }

     // Procesar elementos consumibles
    foreach ($cantidades as $elemID => $cantidad) {
        $this->model->restarCantidad($elemID, $cantidad);
    }

    
    
    $usuario = $this->model->sentencia("SELECT usu_nombre, usu_apellido, usu_numero_docu, usu_telefono, usu_email FROM usuario WHERE usu_id = $usuarioID");
    $usuario = $usuario ? mysqli_fetch_assoc($usuario) : null;
    
    
    if (empty($elementosIDs)) {
    $this->showSweetAlert(
        'error',
        'Sin elementos',
        'No se recibieron elementos para procesar el préstamo.',
        "javascript:window.history.back();"
    );
    exit;
}
    
    $elementos = [];
    $tieneDevolutivo = false; // Bandera para saber si hay al menos un tipo 1

    foreach ($elementosIDs as $elementoID) {
    $elemento = $this->model->sentencia("SELECT elem_nombre, elem_serie, elem_area_id, elem_marca_id, elem_telem_id FROM elementos_inventario WHERE elem_id = $elementoID");
    $elemento = $elemento ? mysqli_fetch_assoc($elemento) : null;

    if ($elemento['elem_telem_id'] == 1) {
        $tieneDevolutivo = true; // Hay al menos un devolutivo
    }

    if ($elemento['elem_telem_id'] == 2) {
        // No salgas aquí, solo no agregues al array si no quieres procesar consumibles como devolutivos
        continue;
    }

    $areaID = $elemento['elem_area_id'];
    $area = $this->model->sentencia("SELECT area_nombre FROM area WHERE area_id = $areaID");
    $area = $area ? mysqli_fetch_assoc($area) : ['area_nombre' => 'Área desconocida'];
    $elemento['area_nombre'] = $area['area_nombre'];

    $marcaID = $elemento['elem_marca_id'];
    $marca = $this->model->sentencia("SELECT marca_nombre FROM marca WHERE marca_id = $marcaID");
    $marca = $marca ? mysqli_fetch_assoc($marca) : ['marca_nombre' => 'Marca desconocida'];
    $elemento['marca_nombre'] = $marca['marca_nombre'];

    $elementos[] = $elemento; // Agregar el elemento al array
    }

    // Validar al final del ciclo
    if (!$tieneDevolutivo) {
        $this->showSweetAlert(
            'error',
            'Préstamo inválido',
            'Debes seleccionar al menos un elemento devolutivo (tipo 1) para realizar el préstamo.',
            "javascript:window.history.back();"
        );
        exit;
    }


    echo '<script>';
    echo 'const elementos = ' . json_encode($elementos) . ';';
    echo 'const cantidades = ' . json_encode($cantidades) . ';';
    echo 'const elementosIDs = ' . json_encode($elementosIDs) . ';';
    echo 'console.log("Array cantidades :", cantidades);';
    echo 'console.log("lista de elementos", elementosIDs);'; 
    echo 'console.log("Elementos seleccionados new:", elementos);';
    echo '</script>';
    $area_destino = $this->model->sentenciaTable('area_destino');


    include_once '../view/Reservas/finalizarReservas.php';
    }




    public function postInsert()
    {
       
        
        // Validar que se reciban los datos necesarios
        if (!isset($_POST['fecha_prestamo']) || !isset($_POST['observaciones']) || !isset($_POST['area_destino']) || !isset($_POST['usu_id'])) {
            echo "Datos incompletos para la reserva. .";
            return;
        }


        $fechaDevolucion = $_POST['fecha_prestamo_entrega'];
        $fechaEntrega = $_POST['fecha_prestamo'];
        $horaDevolucion = $_POST['reserva_fecha_fin'];
        $horaEntrega = $_POST['reserva_fecha_inicio'];
        $observaciones = $_POST['observaciones'];
        $destino = $_POST['area_destino'];
        $estadoReservaID = 1;
        $fechaSolicitud = date('Y-m-d');
        $usu_id = $_POST['usu_id'];
        //validar que el elemento seleccionado sea un array

        if (!isset($_POST['elementos']) || !is_array($_POST['elementos'])) {
            echo "No se han seleccionado elementos válidos.";
            return;
        }

         // Recibe los elementos seleccionados (array de IDs)
        $elementos = isset($_POST['elementos']) ? $_POST['elementos'] : [];
        // Recibe las cantidades (array asociativo: [elem_id => cantidad])
        $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];

        if (empty($elementos)) {
            echo "No se seleccionaron elementos.";
            return;
        }



    
    $idReserva = $this->model->autoincrement('reserva_id', 'reservas_inventario');

    $fields = [
        'reserva_id',
        'reserva_identificacion_solicitante',
        'reserva_area_id',
        'reserva_estado_id',
        'reserva_fecha_solicitud',
        'reserva_fecha_entrega',
        'reserva_fecha_devolucion',
        'reserva_observaciones',
        'reserva_fecha_inicio',
        'reserva_fecha_fin'

    ];

    $values = [
        $idReserva,
        $usu_id,
        $destino,
        $estadoReservaID,
        $fechaSolicitud,
        $fechaEntrega,
        $fechaDevolucion,
        $observaciones,
        $horaEntrega,
        $horaDevolucion 
      ];

   
    $result = $this->model->insertTest('reservas_inventario', $fields, $values);

    if ($result) {

        foreach ($elementos as $id) {
            
            $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [4], 'elem_id', $id);
            $idReserva_detalle = $this->model->autoincrement('id_detalle_reserva', 'detalle_reserva');

            $fields = [
                'id_detalle_reserva',
                'id_reserva',
                'elemen_id',
            ];
            $values = [
                $idReserva_detalle,
                $idReserva,
                $id,
            ];

            $resultDetalle = $this->model->insertTest('detalle_reserva', $fields, $values);
            if (!$resultDetalle) {
                var_dump($fields, $values); // Para ver los datos enviados
                die("Error al insertar en detalle_reserva: " . mysqli_error($this->model->getConnect()));
            }

        }
        $this->showSweetAlert(
            'success',
            'Creación exitosa',
            'La reserva ha sido creada correctamente.',
            getUrl("Reservas", "Reservas", "getInsert")
        );
    } else {
        echo "Error al registrar la reserva.";
    }
    }
    public function consult()
    {
        $resultado = $this->model->consultarReservas();

        $prestamos = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $prestamos[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Reservas\consult.php';
    }




    public function modificar()
    {
    
    $reservaID = $_GET['id'] ?? null;


    if (!$reservaID) {
        echo "<script>
            alert('Error: ID de la reserva no proporcionado.');
            window.history.back();
        </script>";
        exit;
    }


    $reserva = $this->model->getReservaById($reservaID);

    if (!$reserva) {
        echo "No se encontró información de la reserva con ID: " . $reservaID;
        exit;
    }
    $usuId = $reserva['reserva_identificacion_solicitante'];
    $area = $this->model->consult("SELECT usu_nombre, usu_apellido, usu_telefono, usu_email FROM usuario  WHERE usu_id = $usuId");
    $nombre = $area ? mysqli_fetch_assoc($area) : ['usu_nombre' => 'Nombre desconocido'];
    $reserva['nombre'] = $nombre['usu_nombre'];
    $reserva['apellido'] = $nombre['usu_apellido'];
    $reserva['telefono'] = $nombre['usu_telefono'];
    $reserva['email'] = $nombre['usu_email'];


    $destino = $reserva['reserva_area_id'];
    $area = $this->model->consult("SELECT nombre FROM area_destino WHERE id_area_destino = $destino");
    $area = $area ? mysqli_fetch_assoc($area) : ['nombre' => 'Área desconocida'];
    $reserva['area_nombre'] = $area['nombre'];
    $area_destino = $this->model->sentenciaTable('area_destino');

    $elementos = $this->model->getElementosByReservaID($reservaID);

    echo '<script>';
    echo 'const elementos = ' . json_encode($elementos) . ';';
    echo 'console.log("lista de elementos", elementosIDs);'; 
    echo 'console.log("Elementos seleccionados new:", elementos);';
    echo '</script>';
    
    
    $categorias = $this->model->sentenciaTable('categoria');
    $elementosNew = $this->model->consult("SELECT elem_id, elem_nombre, elem_serie, elem_telem_id, elem_cate_id  FROM elementos_inventario WHERE elem_estado_id = 1");
    require_once 'C:\xampp\htdocs\inventario\Views\Reservas\update.php';
}



public function update()
{

    $reservaID = $_POST['id_reserva'] ?? null;
    $fechaSolicitud = $_POST['reserva_fecha_solicitud'] ?? null;
    $fechaEntrega = $_POST['reserva_fecha_entrega'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;
    $destino = $_POST['destino'] ?? null;


    $eliminarElementos = $_POST['eliminar_elementos'] ?? [];


    if (!$reservaID) {
        echo "<script>
            alert('Error: ID de la reserva no proporcionado.');
            window.history.back();
        </script>";
        exit;
    }
    
    
    if (!empty($eliminarElementos)) {
        foreach ($eliminarElementos as $elemID) {
            $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [1], 'elem_id', $elemID);
        }
        $this->model->deleteDetalleReserva($reservaID, $eliminarElementos);
    }
    
    
    $fields = ['reserva_fecha_solicitud','reserva_fecha_entrega','reserva_observaciones', 'reserva_area_id'];
    $values = [$fechaSolicitud, $fechaEntrega, $observaciones, $destino];

    $result = $this->model->updateTest('reservas_inventario', $fields, $values, 'reserva_id', $reservaID);

    if ($result) {
        $this->showSweetAlert(
            'success',
            'Actualización exitosa',
            'La reserva ha sido modificada correctamente.',
            getUrl("Reservas", "Reservas", "consult")
        );
    } else {
        echo "Error al ejecutar la consulta.";
    }
}

    



private function showSweetAlert($icon, $title, $text, $redirectUrl)
    {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$text',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = '$redirectUrl';
            });
        </script>
        ";
    }
    public function adicionar()
    {
        $elementosIDs = $_GET['elem_ids'] ?? [];
        $idReserva = $_GET['reserva_id'] ?? null;


        if (!$idReserva || empty($elementosIDs)) {
            echo "<script>
                alert('Error: Faltan datos para adicionar elementos.');
                window.history.back();
            </script>";
            exit;
        }

        echo '<script>';
        echo 'const elementos = ' . json_encode($elementosIDs) . ';';
        echo 'const elementosIDs = ' . json_encode($idReserva) . ';';
        echo 'console.log("lista de elementos", elementosIDs);'; 
        echo 'console.log("Elementos seleccionados new:", idReserva);';
        echo '</script>';
        
        
        foreach ($elementosIDs as $id) 
        {
            $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [4], 'elem_id', $id);
            $idReserva_detalle = $this->model->autoincrement('id_detalle_reserva', 'detalle_reserva');

            $fields = [
                'id_detalle_reserva',
                'id_reserva',
                'elemen_id',
            ];
            $values = [
                $idReserva_detalle,
                $idReserva, 
                $id,        
            ];

           $result =  $this->model->insertTest('detalle_reserva', $fields, $values);

        }

        if ($result) {    
            $this->showSweetAlert(
                'info',
                'Modificación  exitosa',
                'El préstamo ha sido modificado correctamente.',
                getUrl("Reservas", "Reservas", "consult")
            );
        } else {
            echo "Error al registrar el préstamoDEDEDE.";
        }

    }




    public function detalle(){

    $reservaID = $_GET['id'] ?? null;

    if (!$reservaID) {
        echo "<script>
            alert('Error: ID de la reserva no proporcionado.');
            window.history.back();
        </script>";
        exit;
    }




    $reserva = $this->model->getReservaById($reservaID);

    if (!$reserva) {
        echo "No se encontró información de la reserva con ID: " . $reservaID;
        exit;
    }
    $usuId = $reserva['reserva_identificacion_solicitante'];
    $area = $this->model->consult("SELECT usu_nombre, usu_apellido, usu_telefono, usu_email FROM usuario  WHERE usu_id = $usuId");
    $nombre = $area ? mysqli_fetch_assoc($area) : ['usu_nombre' => 'Nombre desconocido'];
    $reserva['nombre'] = $nombre['usu_nombre'];
    $reserva['apellido'] = $nombre['usu_apellido'];
    $reserva['telefono'] = $nombre['usu_telefono'];
    $reserva['email'] = $nombre['usu_email'];


    $destino = $reserva['reserva_area_id'];
    $area = $this->model->consult("SELECT nombre FROM area_destino WHERE id_area_destino = $destino");
    $area = $area ? mysqli_fetch_assoc($area) : ['nombre' => 'Área desconocida'];
    $reserva['area_nombre'] = $area['nombre'];
    $area_destino = $this->model->sentenciaTable('area_destino');

    $elementos = $this->model->getElementosByReservaID($reservaID);


    require_once 'C:\xampp\htdocs\inventario\Views\Reservas\detalle.php';
    }

    public function crearPrestamo()
    {

        $estadoPrestamoID = 1;
        $cantidad = 1;
        $identificacionSolicitante = $_POST['reserva_identificacion_solicitante'] ?? null;
        $fechaSolicitud = date('Y-m-d H:i:s');
        $reservaID = $_GET['id'] ?? null;
        $elementos = $this->model->getElementosByReservaID($reservaID);
        $elementoID = array_column($elementos, 'elem_id');
       
        
        
        $reserva = $this->model->getReservaById($reservaID);
        if (!$reserva) {
            echo "No se encontró información de la reserva con ID: " . $reservaID;
            exit;       

        }

        $usu_id = $reserva['reserva_identificacion_solicitante'];
        $observaciones = $reserva['reserva_observaciones'] ?? 'No hay observaciones';
        $destino = $reserva['reserva_area_id'] ?? null;
        $fechaEntrega = $reserva['reserva_fecha_entrega'] ?? date('Y-m-d H:i:s');

        
        $idPrestamo = $this->model->autoincrement('id_prestamo', 'prestamos_inventario');

        $fields = [
        'id_prestamo',
        'cantidad_elemento',
        'area_id',
        'estado_prestamo_id',
        'fecha_solicitud',
        'fecha_devolucion',
        'observaciones',
        'usu_id',
    ];

    $values = [
        $idPrestamo,
        $cantidad,
        $destino,
        $estadoPrestamoID,
        $fechaSolicitud,
        $fechaEntrega,
        $observaciones . " Se crea prestamo a partir de reserva por favor editar el prestamo",
        $usu_id   
      ];

   
    $result = $this->model->insertTest('prestamos_inventario', $fields, $values);
    
    
    $this->model->updateTest('reservas_inventario', ['reserva_estado_id'], [2], 'reserva_id', $reservaID);

    if ($result) {

        foreach ($elementoID as $id) {
            $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [2], 'elem_id', $id);
            $id_detalle = $this->model->autoincrement('id_detalle_prestamo', 'detalle_prestamo');

            $fields = [
                'id_detalle_prestamo',
                'id_prestamo',
                'elem_id',
            ];
            $values = [
                $id_detalle,
                $idPrestamo, 
                $id      
            ];

            $this->model->insertTest('detalle_prestamo', $fields, $values);

        }
        $this->showSweetAlert(
            'success',
            'Creación exitosa',
            'El préstamo ha sido creado correctamente.',
            getUrl("Prestamos", "Prestamos", "consult")
        );
    } else {
        echo "Error al registrar el préstamo.";
    }
    }


    public function devolver(){
   
   
   
        $ReservasID = $_GET['id'] ?? null;

        if (!$ReservasID) {
            echo "<script>
                alert('Error: ID de la reserva no proporcionado.');
                window.history.back();
            </script>";
            exit;
        }

        $fields = ['reserva_estado_id'];
        $values = [$estadoReservaID = 3]; 
        $result = $this->model->updateTest('reservas_inventario', $fields, $values, 'reserva_id', $ReservasID);

        $IdsElementos = $this ->model->getElementos($ReservasID);
        
        
        $IdsElementosPlano = array_column($IdsElementos, 'elemen_id');
        if ($result) {
            
            $ids = implode(',', $IdsElementosPlano);
            $sql = "UPDATE elementos_inventario SET elem_estado_id = 1 WHERE elem_id IN ($ids)";
            $this->model->update($sql);

            $this->showSweetAlert(
                'success',
                'Finalización exitosa',
                'El préstamo ha sido finalizado correctamente.',
                getUrl("Reservas", "Reservas", "consult")
            );
        } else {
            echo "Error al ejecutar la consulta.";
        }
    }
}
    



?>