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


    // Recibe las cantidades (array asociativo: [elem_id => cantidad])
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];

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

    
    
    
    if ($result) {

        foreach ($elementos as $id) {
            
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

    
}
