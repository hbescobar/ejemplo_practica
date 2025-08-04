<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "ÁREA"
// ====================================
include_once 'C:\xampp\htdocs\inventario\Model\Areas\AreasModel.php';

class AreasController
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
        require_once 'C:\xampp\htdocs\inventario\Views\Areas\insert.php';
    }

    // ====================================
    // GUARDAR UNA NUEVA ÁREA
    // ====================================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['area_nombre'] ?? '');
            $descripcion = trim($_POST['area_descripcion'] ?? '');

            if ($nombre !== '') {
                // Validar si ya existe
                if ($this->model->existeNombreArea($nombre)) {
                    $this->showSweetAlert(
                        'error',
                        'Duplicado',
                        'Ya existe un área con ese nombre.',
                        'index.php?modulo=areas&controlador=areas&funcion=getInsert'
                    );
                    return;
                }

                // Insertar si no existe
                $resultado = $this->model->insertarAreas($nombre, $descripcion);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Registro Exitoso',
                        'El área ha sido registrada correctamente.',
                        'index.php?modulo=areas&controlador=areas&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error',
                        'No se pudo registrar el área.',
                        'index.php?modulo=areas&controlador=areas&funcion=getInsert'
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campo obligatorio',
                    'El nombre del área es obligatorio.',
                    'index.php?modulo=areas&controlador=areas&funcion=getInsert'
                );
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

        require_once 'C:\xampp\htdocs\inventario\Views\Areas\consult.php';
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
                echo "Área no encontrada.";
                exit();
            }
            require_once 'C:\xampp\htdocs\inventario\Views\Areas\update.php';
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
            $id = $_POST['area_id'] ?? '';
            $nombre = trim($_POST['area_nombre'] ?? '');
            $descripcion = trim($_POST['area_descripcion'] ?? '');

            if ($id !== '' && $nombre !== '') {

                // Verificar si el nuevo nombre ya existe en otra área
                if ($this->model->existeNombreAreaEditar($nombre, $id)) {
                    $this->showSweetAlert(
                        'error',
                        'Duplicado',
                        'Ya existe otra área con ese nombre.',
                        "index.php?modulo=areas&controlador=areas&funcion=getEdit&id=$id"
                    );
                    return;
                }

                $resultado = $this->model->actualizarArea($id, $nombre, $descripcion);

                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Actualización exitosa',
                        'El área se actualizó correctamente.',
                        'index.php?modulo=areas&controlador=areas&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error',
                        'No se pudo actualizar el área.',
                        "index.php?modulo=areas&controlador=areas&funcion=getEdit&id=$id"
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campo obligatorio',
                    'El nombre del área es obligatorio.',
                    "index.php?modulo=areas&controlador=areas&funcion=getEdit&id=$id"
                );
            }
        }
    }


    // ====================================
    // ELIMINAR UN ÁREA
    // ====================================
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            if ($this->model->areaEstaEnUso($id)) {
                $this->showSweetAlert(
                    'error',
                    'Eliminación no permitida',
                    'No se puede eliminar el área porque está asociada a uno o más elementos del inventario.',
                    'index.php?modulo=areas&controlador=areas&funcion=consult'
                );
                return;
            }

            $this->model->eliminarArea($id);

            $this->showSweetAlert(
                'success',
                'Eliminación exitosa',
                'El área ha sido eliminada correctamente.',
                'index.php?modulo=areas&controlador=areas&funcion=consult'
            );
        } else {
            $this->showSweetAlert(
                'error',
                'ID inválido',
                'No se recibió un ID válido para eliminar.',
                'index.php?modulo=areas&controlador=areas&funcion=consult'
            );
        }
    }
}
