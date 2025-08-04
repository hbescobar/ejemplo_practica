<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "CATEGORIA"
// ====================================
include_once 'C:\xampp\htdocs\inventario\Model\Categoria\CategoriaModel.php';

class CategoriaController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        $this->model = new CategoriaModel();
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
        $tipos_elemento = $this->model->consultarTiposElemento(); // NUEVO
        require_once 'C:\xampp\htdocs\inventario\Views\Categoria\insert.php';
    }


    // ====================================
    // GUARDAR UNA NUEVA CATEGORÍA
    // ====================================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['cate_nombre'] ?? '';
            $descripcion = $_POST['cate_descripcion'] ?? '';
            $telem_id = $_POST['telem_id'] ?? null;

            if ($nombre != '' && $telem_id != null) {

                // Validar si ya existe el nombre
                if ($this->model->existeNombreCategoria($nombre)) {
                    $this->showSweetAlert(
                        'warning',
                        'Categoría duplicada',
                        'Ya existe una categoría con ese nombre.',
                        'index.php?modulo=categoria&controlador=categoria&funcion=getInsert'
                    );
                    return;
                }

                // Si no existe, insertar
                $resultado = $this->model->insertarCategorias($nombre, $descripcion, $telem_id);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        '¡Categoría registrada!',
                        'La categoría fue guardada exitosamente.',
                        'index.php?modulo=categoria&controlador=categoria&funcion=consult'
                    );
                    exit();
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error al guardar',
                        'Ocurrió un problema al registrar la categoría.',
                        'index.php?modulo=categoria&controlador=categoria&funcion=getInsert'
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'El nombre y el tipo de elemento son obligatorios.',
                    'index.php?modulo=categoria&controlador=categoria&funcion=getInsert'
                );
            }
        }
    }

    // ====================================
    // CONSULTAR TODAS LAS CATEGORÍAS
    // ====================================
    public function consult()
    {
        $resultado = $this->model->consultarCategorias();

        $categorias = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $categorias[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Categoria\consult.php';
    }

    // ====================================
    // FORMULARIO PARA EDITAR UNA CATEGORÍA
    // ====================================
    public function getEdit()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $categoria = $this->model->obtenerCategoriaPorId($id);
            $tipos_elemento = $this->model->consultarTiposElemento(); // ← AÑADIDO

            if (!$categoria) {
                echo "Categoría no encontrada.";
                exit();
            }

            require_once 'C:\xampp\htdocs\inventario\Views\Categoria\update.php';
        } else {
            echo "ID no válido.";
        }
    }
    // ====================================
    // ACTUALIZAR UNA CATEGORÍA
    // ====================================
    public function postEdit()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['cate_id'] ?? '';
            $nombre = $_POST['cate_nombre'] ?? '';
            $descripcion = $_POST['cate_descripcion'] ?? '';
            $telem_id = $_POST['telem_id'] ?? null;

            if ($id !== '' && $nombre !== '' && $telem_id != null) {

                // Verificar duplicado excluyendo el ID actual
                if ($this->model->existeNombreCategoria($nombre, $id)) {
                    $this->showSweetAlert(
                        'warning',
                        'Nombre duplicado',
                        'Ya existe otra categoría con ese nombre.',
                        'index.php?modulo=categoria&controlador=categoria&funcion=getEdit&id=' . $id
                    );
                    return;
                }

                // Actualizar si no está duplicado
                $resultado = $this->model->actualizarCategoria($id, $nombre, $descripcion, $telem_id);

                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        '¡Categoría actualizada!',
                        'La categoría fue actualizada correctamente.',
                        'index.php?modulo=categoria&controlador=categoria&funcion=consult'
                    );
                    exit();
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error al actualizar',
                        'Ocurrió un problema al actualizar la categoría.',
                        'index.php?modulo=categoria&controlador=categoria&funcion=getEdit&id=' . $id
                    );
                }

            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'Todos los campos requeridos deben estar llenos.',
                    'index.php?modulo=categoria&controlador=categoria&funcion=getEdit&id=' . $id
                );
            }
        }
    }

    // ====================================
    // ELIMINAR UNA CATEGORÍA CON VALIDACIÓN
    // ====================================
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            // Validar si tiene elementos asociados
            if ($this->model->tieneElementosAsociados($id)) {
                
                $this->showSweetAlert(
                    'warning',
                    'No se puede eliminar',
                    'Esta categoría está asociada a uno o más elementos.',
                    'index.php?modulo=categoria&controlador=categoria&funcion=consult'
                );
                exit();
            }

            // Eliminar si no tiene elementos
            $resultado = $this->model->eliminarCategoria($id);
            if ($resultado) {
                $this->showSweetAlert(
                    'success',
                    'Categoría eliminada',
                    'La categoría fue eliminada correctamente.',
                    'index.php?modulo=categoria&controlador=categoria&funcion=consult'
                );
            } else {
                $this->showSweetAlert(
                    'error',
                    'Error',
                    'No se pudo eliminar la categoría.',
                    'index.php?modulo=categoria&controlador=categoria&funcion=consult'
                );
            }
        }
    }
}
