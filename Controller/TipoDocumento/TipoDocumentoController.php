<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "CATEGORIA"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\TipoDocumento\TipoDocumentoModel.php';

class TipoDocumentoController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        $this->model = new TipoDocumentoModel();
    }

    // ===========================
    // Mostrar formulario para insertar
    // ===========================
    public function getInsert()
    {
        require_once 'C:\xampp\htdocs\inventario\Views\TipoDocumento\insert.php';
    }

    // ===========================
    // Procesar inserción de nuevo tipo de documento
    // ===========================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['tipo_docu_nombre'] ?? '';

            if ($nombre != '') {
                $resultado = $this->model->insertarTipoDocumento($nombre);
                if ($resultado) {
                    header('Location: index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult');
                    exit();
                } else {
                    echo "Error al insertar el tipo de documento.";
                }
            } else {
                echo "El nombre es obligatorio.";
            }
        }
    }

    // ===========================
    // Mostrar listado de tipos de documento
    // ===========================
    public function consult()
    {
        $resultado = $this->model->consultarTipoDocumento();

        $tipo = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $tipo[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\TipoDocumento\consult.php';
    }

    // ===========================
    // Mostrar formulario para actualizar tipo de documento
    // ===========================
    public function getEdit()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
            $resultado = $this->model->consultarPorId($id);

            $tipoDocumento = null;
            if ($resultado) {
                $tipoDocumento = mysqli_fetch_assoc($resultado);
            }

            if ($tipoDocumento) {
                require_once 'C:\xampp\htdocs\inventario\Views\TipoDocumento\update.php';
            } else {
                echo "No se encontró el tipo de documento.";
            }
        } else {
            echo "ID inválido o no especificado.";
        }
    }


    // ===========================
    // Procesar actualización de tipo de documento
    // ===========================
    public function postEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['tipo_docu_id'] ?? '';
            $nombre = $_POST['tipo_docu_nombre'] ?? '';

            if ($id != '' && is_numeric($id) && $nombre != '') {
                $resultado = $this->model->editarTipoDocumento($id, $nombre);
                if ($resultado) {
                    header('Location: index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult');
                    exit();
                } else {
                    echo "Error al actualizar el tipo de documento.";
                }
            } else {
                echo "ID y nombre son obligatorios.";
            }
        }
    }

    // ===========================
    // Eliminar un tipo de documento
    // ===========================
    public function delete()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
            $resultado = $this->model->eliminarTipoDocumento($id);

            if ($resultado) {
                header('Location: index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult');
                exit();
            } else {
                echo "Error al eliminar el tipo de documento.";
            }
        } else {
            echo "ID inválido o no especificado.";
        }
    }
}
