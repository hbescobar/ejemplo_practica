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
            $nombre = $_POST['area_nombre'] ?? '';
            $descripcion = $_POST['area_descripcion'] ?? '';

            if ($nombre != '') {
                $resultado = $this->model->insertarAreas($nombre, $descripcion);
                if ($resultado) {
                    header('Location: index.php?modulo=areas&controlador=areas&funcion=consult');
                    exit();
                } else {
                    echo "Error al insertar el área.";
                }
            } else {
                echo "El nombre es obligatorio.";
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
            $nombre = $_POST['area_nombre'] ?? '';
            $descripcion = $_POST['area_descripcion'] ?? '';

            if ($id !== '' && $nombre !== '') {
                $resultado = $this->model->actualizarArea($id, $nombre, $descripcion);

                if ($resultado) {
                    header('Location: index.php?modulo=areas&controlador=areas&funcion=consult');
                    exit();
                } else {
                    echo "Error al actualizar el área.";
                }
            } else {
                echo "El nombre es obligatorio.";
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
            $this->model->eliminarArea($id);
        }

        header('Location: index.php?modulo=areas&controlador=areas&funcion=consult');
        exit();
    }
}
