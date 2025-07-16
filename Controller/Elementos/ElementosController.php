<?php
// ==============================
// CONTROLADOR DE ELEMENTOS
// ==============================

include_once 'C:\xampp\htdocs\inventario\Model\Elementos\ElementosModel.php';

class ElementosController
{
    private $model;

    // ==============================
    // CONSTRUCTOR: CREA EL MODELO
    // ==============================
    public function __construct()
    {
        $this->model = new ElementosModel();
    }

    // ==============================
    // MOSTRAR ALERTA CON SWEETALERT
    // ==============================
    private function showSweetAlert(string $icon,string $title,string $text,string $redirectUrl)
    {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: `$text`,
                confirmButtonText: 'Aceptar'
            }).then(()=>{ window.location.href = '$redirectUrl'; });
        </script>";
    }

    // ====================================================
    // MOSTRAR FORMULARIO PARA REGISTRAR UN NUEVO ELEMENTO
    // ====================================================
    public function getInsert()
    {
        $area = $this->model->obtenerAreas();
        $categoria = $this->model->obtenerCategorias();
        $marca = $this->model->obtenerMarcas();
        $tipoElementos = $this->model->obtenerTipoElementos();
        $unidadMedida = $this->model->obtenerUnidadMedida();

        $form_data = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_data']); // Limpiar para no usarlo otra vez sin querer

        require_once 'C:\xampp\htdocs\inventario\Views\Elementos\insert.php';
    }

    // ==============================
    // GUARDAR UN NUEVO ELEMENTO
    // ==============================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['elem_codigo'])) {
                echo "El campo Código del Elemento es obligatorio.";
                return;
            }

            $data = [
                'elem_placa'       => $_POST['elem_placa']       ?? null,
                'elem_serie'       => $_POST['elem_serie']       ?? null,
                'elem_codigo'      => $_POST['elem_codigo'],
                'elem_nombre'      => $_POST['elem_nombre']      ?? null,
                'elem_telem_id'    => $_POST['elem_telem_id']    ?? null,
                'elem_area_id'     => $_POST['elem_area_id']     ?? null,
                'elem_cate_id'     => $_POST['elem_cate_id']     ?? null,
                'elem_cantidad'    => $_POST['elem_cantidad']    ?? null,
                'elem_unidad_id'   => $_POST['elem_unidad_id']   ?? null,
                'elem_modelo'      => $_POST['elem_modelo']      ?? null,
                'elem_marca_id'    => $_POST['elem_marca_id']    ?? null,
                'elem_estado_id'   => 1,//por defecto activo
                'recomendaciones' => $_POST['recomendaciones'] ?? null,
            ];

            // Fuerza cantidad a 1 si es devolutivo
            if ($data['elem_telem_id'] == 1) {
                $data['elem_cantidad'] = 1;
            }

            //     existsCodigo($codigo), existsPlaca($placa), existsSerie($serie) )
            if ($this->model->existsCodigo($data['elem_codigo'])) {
                $_SESSION['form_data'] = $data; // Guardar el formulario
                $this->showSweetAlert(
                    'warning',
                    'Código duplicado',
                    "El código '{$data['elem_codigo']}' ya está registrado.",
                    getUrl('elementos','elementos','getInsert')
                );
                return;
            }

            if ($data['elem_placa'] && $this->model->existsPlaca($data['elem_placa'])) {
                 $_SESSION['form_data'] = $data; // Guardar el formulario
                $this->showSweetAlert(
                    'warning',
                    'Placa duplicada',
                    "La placa '{$data['elem_placa']}' ya está registrada.",
                    getUrl('elementos','elementos','getInsert')
                );
                return;
            }

            if ($data['elem_serie'] && $this->model->existsSerie($data['elem_serie'])) {
                 $_SESSION['form_data'] = $data; // Guardar el formulario
                $this->showSweetAlert(
                    'warning',
                    'Serie duplicada',
                    "La serie '{$data['elem_serie']}' ya está registrada.",
                    getUrl('elementos','elementos','getInsert')
                );
                return;
            }

            $resultado = $this->model->insertElemento($data);
            if ($resultado) {
                $this->showSweetAlert(
                    'success',
                    '¡Registrado!',
                    'El elemento se guardó correctamente.',
                    getUrl('elementos','elementos','consult')
                );
            } else {
                $this->showSweetAlert(
                    'error',
                    'Error',
                    'No se pudo guardar el elemento. Intenta nuevamente.',
                    getUrl('elementos','elementos','getInsert')
                );
            }
        }
    }

    // ==============================
    // MOSTRAR LA LISTA DE ELEMENTOS
    // ==============================
    public function consult()
    {
        $resultado = $this->model->consultarElementos();

        $elementos = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $elementos[] = $fila;
            }
        }
        require_once 'C:\xampp\htdocs\inventario\Views\Elementos\consult.php';
    }

    // ==============================
    // VER DETALLE DE UN ELEMENTO
    // ==============================
    public function ver()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $resultado = $this->model->consultarElementoPorId($id);

            if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
                $elemento = $fila;
                require_once 'C:\xampp\htdocs\inventario\Views\Elementos\ver.php';
            } else {
                echo "<script>
                alert('Elemento no encontrado');
                window.location.href = '" . getUrl('elementos', 'elementos', 'consult') . "';
            </script>";
            }
        }
    }


    // ===========================================
    // MOSTRAR FORMULARIO PARA EDITAR UN ELEMENTO
    // ===========================================
    public function getEdit()
    {
        if (!isset($_GET['id'])) {
            echo "ID del elemento no proporcionado.";
            return;
        }

        $id = $_GET['id'];
        $result = $this->model->consultarElementoPorId($id);

        if ($result && $fila = mysqli_fetch_assoc($result)) {
            $elemento = $fila;

            $area = $this->model->obtenerAreas();
            $categoria = $this->model->obtenerCategorias();
            $marca = $this->model->obtenerMarcas();
            $unidadMedida = $this->model->obtenerUnidadMedida();

            require_once 'C:\xampp\htdocs\inventario\Views\Elementos\update.php';
        } else {
            echo "Elemento no encontrado.";
        }
    }


    // ===========================================
    // ACTUALIZAR UN ELEMENTO EN LA BASE DE DATOS
    // ===========================================
    public function postEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'elem_id'        => $_POST['elem_id'],
                'elem_codigo'    => $_POST['elem_codigo'] ?? '',
                'elem_nombre'    => $_POST['elem_nombre'] ?? '',
                'elem_telem_id'  => $_POST['elem_telem_id'],
                'elem_placa'     => $_POST['elem_placa'] ?? null,
                'elem_serie'     => $_POST['elem_serie'] ?? null,
                'elem_modelo'    => $_POST['elem_modelo'] ?? null,
                'elem_area_id'   => $_POST['elem_area_id'] ?? null,
                'elem_cate_id'   => $_POST['elem_cate_id'] ?? null,
                'elem_marca_id'  => $_POST['elem_marca_id'] ?? null,
                'elem_cantidad'  => $_POST['elem_cantidad'] ?? null,
                'elem_unidad_id' => $_POST['elem_unidad_id'] ?? null,
                'recomendaciones' => $_POST['recomendaciones'] ?? null
            ];

            // Fuerza cantidad a 1 si es devolutivo
            if ($data['elem_telem_id'] == 1) {
                $data['elem_cantidad'] = 1;
            }

            // Validaciones de duplicados 
            if ($this->model->existsCodigoOtro($data['elem_codigo'], $data['elem_id'])) {
                $this->showSweetAlert(
                    'warning',
                    'Código duplicado',
                    "El código '{$data['elem_codigo']}' ya pertenece a otro elemento.",
                    getUrl('elementos','elementos','getEdit')."&id={$data['elem_id']}"
                );
                return;
            }

            if ($data['elem_placa'] &&
                $this->model->existsPlacaOtro($data['elem_placa'], $data['elem_id'])) {
                $this->showSweetAlert(
                    'warning',
                    'Placa duplicada',
                    "La placa '{$data['elem_placa']}' ya pertenece a otro elemento.",
                    getUrl('elementos','elementos','getEdit')."&id={$data['elem_id']}"
                );
                return;
            }

            if ($data['elem_serie'] &&
                $this->model->existsSerieOtro($data['elem_serie'], $data['elem_id'])) {
                $this->showSweetAlert(
                    'warning',
                    'Serie duplicada',
                    "La serie '{$data['elem_serie']}' ya pertenece a otro elemento.",
                    getUrl('elementos','elementos','getEdit')."&id={$data['elem_id']}"
                );
                return;
            }

            // Validación básica común
            if (empty($data['elem_codigo']) || empty($data['elem_nombre'])) {
                echo "<script>alert('Código y nombre son obligatorios.'); history.back();</script>";
                return;
            }

            // Validaciones específicas por tipo
            if ($data['elem_telem_id'] == 2) { // No Devolutivo
                if (empty($data['elem_unidad_id'])) {
                    echo "<script>alert('Debe seleccionar una unidad de medida.'); history.back();</script>";
                    return;
                }
            }

            // Ejecutar actualización
            $resultado = $this->model->actualizarElemento($data);

            if ($resultado) {
                $this->showSweetAlert(
                    'success',
                    'Elemento actualizado',
                    'La información fue guardada correctamente.',
                    getUrl("elementos", "elementos", "consult")
                );
                return;
            }
        }
    }

    // ==============================
    // CAMBIAR ESTADO DEL ELEMENTO
    // ==============================
    public function cambiarEstado()
    {
        $id = $_GET['id'] ?? null;
        $estadoNombre = $_GET['estado'] ?? null;

        if ($id && $estadoNombre) {
            $estado = $this->model->buscarEstadoPorNombre($estadoNombre);
            if ($estado) {
                $this->model->actualizarEstadoElemento($id, $estado['id_estado_elementos']);
            }
        }

        header("Location: index.php?modulo=elementos&controlador=elementos&funcion=consult");
        exit();
    }

    //Funcion para registrar una entrada de inventario
    public function registrarEntrada()
    {
        // 1. Solo aceptar POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . getUrl('elementos','elementos','consult'));
            exit;
        }

        // 2. Datos del formulario
        $elemento_id = intval($_POST['elem_id'] ?? 0);
        $cantidad    = intval($_POST['cantidad'] ?? 0);
        $comentario  = trim($_POST['comentario'] ?? '');
        //array del usuario logueado
        $usuario_id  = $_SESSION['usuario']['usu_id'] ?? 0;
        $fecha = $_POST['fecha'] ?? date('Y-m-d');

        // 3. Validación básica
        if ($elemento_id <= 0 || $cantidad <= 0 || $usuario_id <= 0) {
            header('Location: ' . getUrl('elementos','elementos','consult'));
            exit;
        }

        // 4. Actualizar inventario
        $this->model->sumarCantidad($elemento_id, $cantidad);

        // 4‑bis. Obtener nombre del elemento para la descripción
        $elemento = $this->model->getElementoById($elemento_id);
        $nombre_elemento = $elemento['elem_nombre'] ?? 'Desconocido';

        // 4‑ter. Construir descripción
        $texto = $comentario !== ''
            ? $comentario
            : "Entrada manual de elemento (ID: $elemento_id, Nombre: $nombre_elemento, Cantidad: $cantidad)";

        $this->model->registrarMovimientoEntrada(
            $usuario_id, $elemento_id, $cantidad, $texto, $fecha
        );

        // 5. Volver al listado
        header('Location: ' . getUrl('elementos','elementos','consult'));
        exit;
    }
}
