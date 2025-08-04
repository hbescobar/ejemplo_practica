<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "ÁREA"
// ====================================
include_once 'C:\xampp\htdocs\inventario\Model\AreasDestino\AreasDestinoModel.php';

class AreasDestinoController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        $this->model = new AreasModel();
    }

    // ====================================
    // MUESTRA UN MENSAJE CON SWEET ALERT
    // ====================================
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


    // ====================================
    // MOSTRAR FORMULARIO DE REGISTRO
    // ====================================
    public function getInsert()
    {
        require_once 'C:\xampp\htdocs\inventario\Views\AreasDestino\insert.php';
    }

    // ====================================
    // GUARDAR UNA NUEVA ÁREA
    // ====================================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            if ($nombre != '') {

                // Validar si el nombre ya existe
                if ($this->model->existeNombreArea($nombre)) {
                    $this->showSweetAlert(
                        'warning',
                        'Nombre duplicado',
                        'El nombre del área destino ya existe. Por favor, elija otro.',
                        'index.php?modulo=areasDestino&controlador=areasDestino&funcion=getInsert'
                    );
                    exit();
                }

                // Intentar insertar
                $resultado = $this->model->insertarAreas($nombre, $descripcion);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Área registrada',
                        'El área destino fue registrada correctamente.',
                        'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                    );
                    exit();
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error al registrar',
                        'Hubo un problema al insertar el área destino.',
                        'index.php?modulo=areasDestino&controlador=areasDestino&funcion=getInsert'
                    );
                    exit();
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campo obligatorio',
                    'El nombre del área no puede estar vacío.',
                    'index.php?modulo=areasDestino&controlador=areasDestino&funcion=getInsert'
                );
                exit();
            }
        }
    }

    // ====================================
    // CONSULTAR TODAS LAS ÁREAS
    // ====================================
    public function consult()
    {
        $resultado = $this->model->consultarAreas();

        $areas = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $areas[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\areasDestino\consult.php';
    }

    // ====================================
    // FORMULARIO PARA EDITAR UN ÁREA
    // ====================================
    public function getEdit()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $area = $this->model->obtenerAreaPorId($id);
            if (!$area) {
                echo "Área destino no encontrada.";
                exit();
            }
            require_once 'C:\xampp\htdocs\inventario\Views\AreasDestino\update.php';
        } else {
            echo "ID no válido.";
        }
    }

    // ====================================
    // ACTUALIZAR UN ÁREA
    // ====================================
    public function postEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_area_destino'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            if ($id !== '' && $nombre !== '') {
                if ($this->model->existeNombreArea($nombre, $id)) {
                    $this->showSweetAlert(
                        'warning',
                        'Área duplicada',
                        'El nombre del área destino ya existe. Por favor, elija otro.',
                        "index.php?modulo=areasDestino&controlador=areasDestino&funcion=getEdit&id=$id"
                    );
                    exit();
                }

                $resultado = $this->model->actualizarArea($id, $nombre, $descripcion);

                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Área actualizada',
                        'Los datos del área destino se actualizaron correctamente.',
                        'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                    );
                    exit();
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error',
                        'Ocurrió un error al actualizar el área.',
                        'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                    );
                    exit();
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos incompletos',
                    'El nombre del área destino es obligatorio.',
                    'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                );
                exit();
            }
        }
    }

    // ====================================
    // ELIMINAR UN ÁREA DESTINO
    // ====================================
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id !== null) {
            // Validar si el área tiene préstamos o reservas asociadas
            if ($this->model->tieneAsociaciones($id)) {
                $this->showSweetAlert(
                    'warning',
                    'No se puede eliminar',
                    'Esta área está asociada a uno o más préstamos o reservas.',
                    'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                );
                exit();
            }

            // Si no tiene asociaciones, eliminarla
            $resultado = $this->model->eliminarArea($id);
            if ($resultado) {
                $this->showSweetAlert(
                    'success',
                    'Área eliminada',
                    'El área fue eliminada exitosamente.',
                    'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                );
            } else {
                $this->showSweetAlert(
                    'error',
                    'Error',
                    'No se pudo eliminar el área destino.',
                    'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
                );
            }
        } else {
            $this->showSweetAlert(
                'warning',
                'ID inválido',
                'No se especificó un área destino válida para eliminar.',
                'index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult'
            );
        }
    }
}
