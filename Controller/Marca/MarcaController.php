<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "MARCA"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\Marca\MarcaModel.php';

class MarcaController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        $this->model = new MarcaModel();
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
    // MOSTRAR FORMULARIO DE INSERCIÓN
    // ====================================
    public function getInsert()
    {
        require_once 'C:\xampp\htdocs\inventario\Views\Marca\insert.php';
    }

    // ====================================
    // PROCESAR EL FORMULARIO DE INSERCIÓN
    // ====================================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['marca_nombre'] ?? '';
            $descripcion = $_POST['marca_descripcion'] ?? '';

            if ($nombre != '') {
                // Validación de duplicado
                if ($this->model->existeNombreMarca($nombre)) {
                    $this->showSweetAlert(
                        'warning',
                        'Nombre duplicado',
                        'La marca ya existe. Por favor, ingresa otro nombre.',
                        'index.php?modulo=marca&controlador=marca&funcion=getInsert'
                    );
                    return;
                }

                $resultado = $this->model->insertarMarca($nombre, $descripcion);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Marca registrada',
                        'La marca se registró exitosamente.',
                        'index.php?modulo=marca&controlador=marca&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error',
                        'No se pudo registrar la marca. Intenta nuevamente.',
                        'index.php?modulo=marca&controlador=marca&funcion=getInsert'
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campo obligatorio',
                    'El nombre de la marca no puede estar vacío.',
                    'index.php?modulo=marca&controlador=marca&funcion=getInsert'
                );
            }
        }
    }

    // ====================================
    // CONSULTAR TODAS LAS MARCAS
    // ====================================
    public function consult()
    {
        // Obtener todas las marcas desde el modelo
        $resultado = $this->model->consultarMarcas();

        // Convertir resultado mysqli a array para la vista
        $marcas = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $marcas[] = $fila;
            }
        }

        // Cargar la vista y pasarle el array de marcas
        require_once 'C:\xampp\htdocs\inventario\Views\Marca\consult.php';
    }

    // ====================================
    // MOSTRAR FORMULARIO PARA EDITAR UNA MARCA
    // ====================================
    public function getEdit()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $marca = $this->model->obtenerMarcaPorId($id);
            if ($marca) {
                require_once 'C:\xampp\htdocs\inventario\Views\Marca\update.php';
            } else {
                echo "Marca no encontrada.";
            }
        } else {
            echo "ID no válido.";
        }
    }

    // ====================================
    // ACTUALIZAR UNA MARCA
    // ====================================
    public function postEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['marca_id'] ?? '';
            $nombre = $_POST['marca_nombre'] ?? '';
            $descripcion = $_POST['marca_descripcion'] ?? '';

            if ($id !== '' && $nombre !== '') {

                // Validar si el nombre ya existe en otra marca
                if ($this->model->existeNombreMarca($nombre, $id)) {
                    $this->showSweetAlert(
                        'warning',
                        'Nombre duplicado',
                        'Ya existe otra marca con ese nombre. Por favor, elige otro.',
                        "index.php?modulo=marca&controlador=marca&funcion=getEdit&id=$id"
                    );
                    return;
                }

                $resultado = $this->model->actualizarMarca($id, $nombre, $descripcion);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Actualización exitosa',
                        'La marca fue actualizada correctamente.',
                        'index.php?modulo=marca&controlador=marca&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error al actualizar',
                        'No se pudo actualizar la marca.',
                        'index.php?modulo=marca&controlador=marca&funcion=consult'
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'El nombre de la marca es obligatorio.',
                    'index.php?modulo=marca&controlador=marca&funcion=consult'
                );
            }
        }
    }

    // ====================================
    // ELIMINAR UNA MARCA
    // ====================================
    public function delete()
    {
        $marca_id = $_GET['id'] ?? null;

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->showSweetAlert(
                'error',
                'ID inválido',
                'El ID de la marca no es válido.',
                'index.php?modulo=marca&controlador=marca&funcion=consult'
            );
            return;
        }

        // Validar si tiene elementos asociados
        if ($this->model->tieneElementosAsociados($marca_id)) {
            $this->showSweetAlert(
                'warning',
                'No se puede eliminar',
                'Esta marca está asociada a uno o más elementos del inventario.',
                'index.php?modulo=marca&controlador=marca&funcion=consult'
            );
            return;
        }

        // Eliminar si no tiene elementos
        $resultado = $this->model->eliminarMarca($marca_id);
        if ($resultado) {
            $this->showSweetAlert(
                'success',
                'Marca eliminada',
                'La marca fue eliminada correctamente.',
                'index.php?modulo=marca&controlador=marca&funcion=consult'
            );
        } else {
            $this->showSweetAlert(
                'error',
                'Error',
                'No se pudo eliminar la marca.',
                'index.php?modulo=marca&controlador=marca&funcion=consult'
            );
        }
    }
}
