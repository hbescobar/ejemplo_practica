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
                $resultado = $this->model->insertarMarca($nombre, $descripcion);
                if ($resultado) {
                    // Redirigir a consultar u otro lugar
                    header('Location: index.php?modulo=marca&controlador=marca&funcion=consult');
                    exit();
                } else {
                    echo "Error al insertar la marca.";
                }
            } else {
                echo "El nombre es obligatorio.";
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
                $resultado = $this->model->actualizarMarca($id, $nombre, $descripcion);

                if ($resultado) {
                    header('Location: index.php?modulo=marca&controlador=marca&funcion=consult');
                    exit();
                } else {
                    echo "Error al actualizar la marca.";
                }
            } else {
                echo "Todos los campos obligatorios.";
            }
        }
    }

    // ====================================
    // ELIMINAR UNA MARCA
    // ====================================
    public function delete()
    {
        $marca_id = $_GET['id'] ?? null;

        if ($marca_id) {
            $this->model->eliminarMarca($marca_id);
        }

        header('Location: index.php?modulo=marca&controlador=marca&funcion=consult');
        exit();
    }
}
