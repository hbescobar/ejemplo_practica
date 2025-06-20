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
                $resultado = $this->model->insertarCategorias($nombre, $descripcion, $telem_id);
                if ($resultado) {
                    header('Location: index.php?modulo=categoria&controlador=categoria&funcion=consult');
                    exit();
                } else {
                    echo "Error al insertar la categoría.";
                }
            } else {
                echo "El nombre y el tipo de elemento son obligatorios.";
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
                $resultado = $this->model->actualizarCategoria($id, $nombre, $descripcion, $telem_id);

                if ($resultado) {
                    header('Location: index.php?modulo=categoria&controlador=categoria&funcion=consult');
                    exit();
                } else {
                    echo "Error al actualizar la categoría.";
                }
            } else {
                echo "Todos los campos son obligatorios.";
            }
        }
    }

    // ====================================
    // ELIMINAR UNA CATEGORÍA
    // ====================================
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->model->eliminarCategoria($id);
        }

        header('Location: index.php?modulo=categoria&controlador=categoria&funcion=consult');
        exit();
    }
}
