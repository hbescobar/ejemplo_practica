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
                
                
                if ($this->model->existeNombreArea($nombre)) {
                    echo "<script>
                        alert('El nombre del área destino ya existe. Por favor, elija otro.');
                        window.history.back();
                    </script>";
                    exit();
                }


                $resultado = $this->model->insertarAreas($nombre, $descripcion);
                if ($resultado) {
                    header('Location: index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult');
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
                echo "<script>
                    alert('El nombre del área destino ya existe. Por favor, elija otro.');
                    window.history.back();
                </script>";
                exit();
                }

                $resultado = $this->model->actualizarArea($id, $nombre, $descripcion);

                if ($resultado) {
                    header('Location: index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult');
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
    // ELIMINAR UN ÁREA DESTINO
    // ====================================
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->model->eliminarArea($id);
        }

        header('Location: index.php?modulo=areasDestino&controlador=areasDestino&funcion=consult');
        exit();
    }
}
