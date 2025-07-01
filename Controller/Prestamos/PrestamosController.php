<?php
// ==============================
// CONTROLADOR DE PRÉSTAMOS
// ==============================

include_once 'C:\xampp\htdocs\inventario\Model\Prestamos\PrestamosModel.php';

class PrestamosController
{
    private $model;

    // ==============================
    // CONSTRUCTOR: CREA EL MODELO
    // ==============================
    public function __construct()
    {
        $this->model = new PrestamosModel();
    }

    // ==============================
    // MOSTRAR FORMULARIO PARA CREAR UN PRÉSTAMO
    // ==============================
    public function getInsert()
    {

        $usuarios = $this->model->obtenerUsuariosActivos();
        $categorias = $this->model->obtenerCategorias();
        $elementos = $this->model->obtenerElementosDisponibles();
        $destinos = $this->model->obtenerAreasDestino();

        require_once 'C:\xampp\htdocs\inventario\Views\Prestamos\insert.php';
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
                        // Agrega data-tipo al input
                        echo '<input class="form-check-input" type="checkbox" name="elementos[]" value="' . $elem['elem_id'] . '" id="elem_' . $elem['elem_id'] . '" data-tipo="' . intval($elem['elem_telem_id']) . '">';
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
                    $(document).on("change", "input[type=checkbox][name=\'elementos[]\']", function(){
                        var id = $(this).val();
                        var input = $("input[name=\'cantidades[" + id + "]\']");
                        if($(this).is(":checked")){
                            input.prop("disabled", false).focus();
                        } else {
                            input.prop("disabled", true); // No borres el valor aquí
                        }
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


    // ==============================
    // INSERTAR UN NUEVO PRÉSTAMO
    // ==============================
    public function postInsert()
    {
        // Validar que se reciban los datos necesarios
        if (!isset($_POST['fecha_prestamo']) || !isset($_POST['observaciones']) || !isset($_POST['area_destino']) || !isset($_POST['usu_id'])) {
            echo "Datos incompletos para el préstamo.";
            return;
        }

        // Validar que se reciban los elementos y cantidades
        $cantidadElemento = 1;
        $fechaDevolucion = $_POST['fecha_prestamo'];
        $observaciones = $_POST['observaciones'];
        $destino = $_POST['area_destino'];
        $estadoPrestamoID = 1;
        $fechaSolicitud = date('Y-m-d');
        $usu_id = $_POST['usu_id'];

        //validar que el elemento seleccionado sea un array

        if (!isset($_POST['elementos']) || !is_array($_POST['elementos'])) {
            echo "No se han seleccionado elementos válidos.";
            return;
        }

        // Recibe los elementos seleccionados (array de IDs)
        $elementos = isset($_POST['elementos']) ? $_POST['elementos'] : [];


        
         /*

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
        } */

        if (empty($elementos)) {
            echo "No se seleccionaron elementos.";
            return;
        }

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
            $cantidadElemento,
            $destino,
            $estadoPrestamoID,
            $fechaSolicitud,
            $fechaDevolucion,
            $observaciones,
            $usu_id
        ];

        $result = $this->model->insertTest('prestamos_inventario', $fields, $values);
        $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];
        echo "<script>console.log('Elementos:', " . json_encode($elementos) . ");</script>";
        echo "<script>console.log('Cantidades:', " . json_encode($cantidades) . ");</script>";
        //var_dump($_POST['cantidades']); exit;
        
        if ($result) {
            foreach ($elementos as $id) {

                
                $sqlTipo = "SELECT elem_telem_id, elem_cate_id, elem_nombre FROM elementos_inventario WHERE elem_id = " . intval($id);
                $resultTipo = $this->model->consult($sqlTipo);
                $rowTipo = mysqli_fetch_assoc($resultTipo);
                $tipoElemento = $rowTipo['elem_telem_id'] ?? 1; // 1=devolutivo, 2=no devolutivo
                $categoriaElemento = $rowTipo['elem_cate_id'] ?? null; // Obtener la categoría del elemento
                $nombreElemento = $rowTipo['elem_nombre'] ?? 'Elemento desconocido'; // Obtener el nombre del elemento
                $elementos = isset($_POST['elementos']) ? $_POST['elementos'] : [];
                $cantidadSolicitada = $cantidades[$id] ?? 1;

                if ($tipoElemento == 1) {
                    // Lógica para elementos devolutivos

                    $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [2], 'elem_id', $id);
                    $idPrestamo_detalle = $this->model->autoincrement('id_detalle_prestamo', 'detalle_prestamo');

                    $fields = [
                        'id_detalle_prestamo',
                        'id_prestamo',
                        'elem_id',
                    ];
                    $values = [
                        $idPrestamo_detalle,
                        $idPrestamo,
                        $id,
                    ];

                    $this->model->insertTest('detalle_prestamo', $fields, $values);
                } else {
                    // Lógica para elementos no devolutivos
                    $sqlRestar = "UPDATE elementos_inventario SET elem_cantidad = elem_cantidad - $cantidadSolicitada WHERE elem_id = $id";
                    $this->model->update($sqlRestar);
                    
                    $idMovimiento = $this->model->autoincrement('id', 'movimientos_elementos');
                    $fechaMovimiento = date('Y-m-d H:i:s');
                    $salida = "Salida";
                    $descripcion_movimiento = "Salida de elemento no devolutivo" . " (ID: $id, Nombre: $nombreElemento, Cantidad: $cantidadSolicitada)";
                    
                    
                    $fields = [
                        'id',
                        'fecha_movimiento',
                        'usuario',
                        'cantidad',
                        'categoria_elm',
                        'movimiento',
                        'descripcion',
                    ];

                    $values = [
                        $idMovimiento,
                        $fechaMovimiento,
                        $usu_id,
                        $cantidadSolicitada,
                        $categoriaElemento,
                        $salida,
                        $descripcion_movimiento
                    ];
                    $result = $this->model->insertTest('movimientos_elementos', $fields, $values);
                    
                    
                    if (!$result) {
                        error_log("Error al insertar movimiento: " . print_r($values, true));
                    }
                }

            }
            $this->showSweetAlert(
                'success',
                'Creación exitosa',
                'El préstamo ha sido creado correctamente.',
                getUrl("Prestamos", "Prestamos", "getInsert")
            );
        } else {
            echo "Error al registrar el préstamo.";
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

    public function getCategoriasPorTipoElemento() {
    if (isset($_POST['tipo_id'])) {
        $tipo_id = intval($_POST['tipo_id']);
        $categorias = $this->model->obtenerCategoriasPorTipoElemento($tipo_id);

        if (!empty($categorias)) {
            foreach ($categorias as $categoria) {
                echo '<option value="' . $categoria['cate_id'] . '">' . htmlspecialchars($categoria['cate_nombre']) . '</option>';
            }
        } else {
            echo '<option disabled>No hay categorías disponibles.</option>';
        }
    } else {
        echo '<option disabled>Error: Tipo no recibido.</option>';
    }
    exit;
}

public function consult()
    {
        $resultado = $this->model->consultarPrestamos();

        $prestamos = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $prestamos[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Prestamos\consult.php';
    }


   public function detalle(){

    $prestamoID = $_GET['id'] ?? null;

   
    if (!$prestamoID) {
        echo "<script>
            alert('Error: ID del préstamo no proporcionado.');
            window.history.back();
        </script>";
        exit;
    }

    
    $prestamo = $this->model->getPrestamoById($prestamoID);

    if (!$prestamo) {
        echo "No se encontró información del préstamo con ID: " . $prestamoID;
        exit;
    }
    $usuId = $prestamo['usu_id'];
    $area = $this->model->consult("SELECT usu_nombre, usu_apellido, usu_telefono, usu_email FROM usuario  WHERE usu_id = $usuId");
    $nombre = $area ? mysqli_fetch_assoc($area) : ['usu_nombre' => 'Nombre desconocido'];
    $prestamo['nombre'] = $nombre['usu_nombre'];
    $prestamo['apellido'] = $nombre['usu_apellido'];
    $prestamo['telefono'] = $nombre['usu_telefono'];
    $prestamo['email'] = $nombre['usu_email'];
    

 
    $destino = $prestamo['area_id'];
    $area = $this->model->consult("SELECT nombre FROM area_destino WHERE id_area_destino = $destino");
    $area = $area ? mysqli_fetch_assoc($area) : ['area_nombre' => 'Área desconocida'];
    $prestamo['area_nombre'] = $area['nombre'];
    $area_destino = $this->model->sentenciaTable('area_destino');

    $elementos = $this->model->getElementosByPrestamoID($prestamoID);

    
    require_once 'C:\xampp\htdocs\inventario\Views\Prestamos\detalle.php';
    
}



public function modificar()
    {
        
        $prestamoID = $_GET['id'] ?? null;

    
        if (!$prestamoID) {
            echo "<script>
                alert('Error: ID del préstamo no proporcionado para la vista   de editar.');
                window.history.back();
            </script>";
            exit;
        }

        
        $prestamo = $this->model->getPrestamoById($prestamoID);

        if (!$prestamo) {
            echo "No se encontró información del préstamo con ID: " . $prestamoID;
            exit;
        }
        $usuId = $prestamo['usu_id'];
        $area = $this->model->consult("SELECT usu_nombre, usu_apellido, usu_telefono, usu_email FROM usuario  WHERE usu_id = $usuId");
        $nombre = $area ? mysqli_fetch_assoc($area) : ['usu_nombre' => 'Nombre desconocido'];
        $prestamo['nombre'] = $nombre['usu_nombre'];
        $prestamo['apellido'] = $nombre['usu_apellido'];
        $prestamo['telefono'] = $nombre['usu_telefono'];
        $prestamo['email'] = $nombre['usu_email'];
        

    
        $destino = $prestamo['area_id'];
        $area = $this->model->consult("SELECT nombre FROM area_destino WHERE id_area_destino = $destino");
        $area = $area ? mysqli_fetch_assoc($area) : ['area_nombre' => 'Área desconocida'];
        $prestamo['area_nombre'] = $area['nombre'];
        $area_destino = $this->model->sentenciaTable('area_destino');

        $elementos = $this->model->getElementosByPrestamoID($prestamoID);

        echo '<script>';
        echo 'const elementos = ' . json_encode($elementos) . ';';
        echo 'console.log("lista de elementos", elementosIDs);'; 
        echo 'console.log("Elementos seleccionados new:", elementos);';
        echo '</script>';
        
        
        $categorias = $this->model->sentenciaTable('categoria');
        $elementosNew = $this->model->consult("SELECT elem_id, elem_nombre, elem_serie, elem_telem_id, elem_cate_id  FROM elementos_inventario WHERE elem_estado_id = 1");
        require_once 'C:\xampp\htdocs\inventario\Views\Prestamos\update.php';
    }



     public function adicionar()
    {
        $elementosIDs = $_GET['elem_ids'] ?? [];
        $idPrestamo = $_GET['id_prestamo'] ?? null;
       
        
        
        
        if (!$idPrestamo || empty($elementosIDs)) {
            echo "<script>
                alert('Error: Faltan datos para adicionar elementosdedededee.');
                window.history.back();
            </script>";
            exit;
        }

        echo '<script>';
        echo 'const elementos = ' . json_encode($elementosIDs) . ';';
        echo 'const elementosIDs = ' . json_encode($prestamoID) . ';';
        echo 'console.log("lista de elementos", elementosIDs);'; 
        echo 'console.log("Elementos seleccionados new:", prestamoID);';
        echo '</script>';
        
        
        foreach ($elementosIDs as $id) 
        {
            
            $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [2], 'elem_id', $id);
            $idPrestamo_detalle = $this->model->autoincrement('id_detalle_prestamo', 'detalle_prestamo');

            $fields = [
                'id_detalle_prestamo',
                'id_prestamo',
                'elem_id',
            ];
            $values = [
                $idPrestamo_detalle,
                $idPrestamo, 
                $id,        
            ];

           $result =  $this->model->insertTest('detalle_prestamo', $fields, $values);

        }

        if ($result) {    
            $this->showSweetAlert(
                'info',
                'Modificación  exitosa',
                'El préstamo ha sido modificado correctamente.',
                getUrl("Prestamos", "Prestamos", "consult")
            );
        } else {
            echo "Error al adicionar cantidad.";
        }

    }


    public function update()
{
   
    $prestamoID = $_POST['id_prestamo'] ?? null;
    $fechaDevolucion = $_POST['fecha_devolucion'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;
    $destino = $_POST['destino'] ?? null;
    
    
    $eliminarElementos = $_POST['eliminar_elementos'] ?? [];

   
    if (!$prestamoID) {
        echo "<script>
            alert('Error: ID del préstamo no proporcionado.');
            window.history.back();
        </script>";
        exit;
    }
    
    
    if (!empty($eliminarElementos)) {
        foreach ($eliminarElementos as $elemID) {
            $this->model->updateTest('elementos_inventario', ['elem_estado_id'], [1], 'elem_id', $elemID);
        }
        $this->model->deleteDetallePrestamo($prestamoID, $eliminarElementos);
    }
    $fields = ['fecha_devolucion', 'observaciones', 'area_id'];
    $values = [$fechaDevolucion, $observaciones, $destino];

    $result = $this->model->updateTest('prestamos_inventario', $fields, $values, 'id_prestamo', $prestamoID);

    if ($result) {
        $this->showSweetAlert(
            'success',
            'Actualización exitosa',
            'El préstamo ha sido modificado correctamente.',
            getUrl("Prestamos", "Prestamos", "consult")
        );
    } else {
        echo "Error al ejecutar la consulta.";
    }


     
}


public function devolver(){
   
   
   
        $prestamoID = $_GET['id'] ?? null;
        
        if (!$prestamoID) {
            echo "<script>
                alert('Error: ID del préstamo no proporcionado.');
                window.history.back();
            </script>";
            exit;
        }

        $fields = ['estado_prestamo_id'];
        $values = [$estadoPrestamoID = 2]; 
        $result = $this->model->updateTest('prestamos_inventario', $fields, $values, 'id_prestamo', $prestamoID);

        $IdsElementos = $this ->model->getElementos($prestamoID);
        $IdsElementosPlano = array_column($IdsElementos, 'elem_id');
        if ($result) {
            
            $ids = implode(',', $IdsElementosPlano);
            $sql = "UPDATE elementos_inventario SET elem_estado_id = 1 WHERE elem_id IN ($ids)";
            $this->model->consult($sql);

            $this->showSweetAlert(
                'success',
                'Finalización exitosa',
                'El préstamo ha sido finalizado correctamente.',
                getUrl("Prestamos", "Prestamos", "consult")
            );
        } else {
            echo "Error al ejecutar la consulta.";
        }
    }



    public function consultarMovimientos()
    {
        $resultado = $this->model->consultarMovimientos();

        $movimientos = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $movimientos[] = $fila;
            }
        }



        require_once 'C:\xampp\htdocs\inventario\Views\Prestamos\consultMovements.php';
    }





}
