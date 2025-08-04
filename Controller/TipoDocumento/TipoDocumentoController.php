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
            $nombre = trim($_POST['tipo_docu_nombre'] ?? '');

            if ($nombre !== '') {
                // Validar si ya existe
                if ($this->model->existeNombreTipoDocumento($nombre)) {
                    $this->showSweetAlert(
                        'error',
                        'Duplicado',
                        'Ya existe un tipo de documento con ese nombre.',
                        'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=getInsert'
                    );
                    return;
                }

                // Insertar si no existe
                $resultado = $this->model->insertarTipoDocumento($nombre);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Registro Exitoso',
                        'El tipo de documento ha sido registrado correctamente.',
                        'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error',
                        'No se pudo registrar el tipo de documento.',
                        'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=getInsert'
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'El nombre del tipo de documento es requerido.',
                    'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=getInsert'
                );
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
            $nombre = trim($_POST['tipo_docu_nombre'] ?? '');

            if ($id !== '' && is_numeric($id) && $nombre !== '') {

                // Validar si ya existe otro con ese nombre
                if ($this->model->existeNombreTipoDocumento($nombre, $id)) {
                    $this->showSweetAlert(
                        'error',
                        'Duplicado',
                        'Ya existe otro tipo de documento con ese nombre.',
                        "index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=getEdit&id=$id"
                    );
                    return;
                }

                // Si pasa la validación, actualizar
                $resultado = $this->model->editarTipoDocumento($id, $nombre);

                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Actualización Exitosa',
                        'El tipo de documento ha sido actualizado correctamente.',
                        'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error',
                        'No se pudo actualizar el tipo de documento.',
                        "index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=getEdit&id=$id"
                    );
                }

            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'El ID y nombre son requeridos.',
                    'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
                );
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

            // Validar si hay usuarios asociados
            if ($this->model->tieneUsuariosAsociados($id)) {
                $this->showSweetAlert(
                    'error',
                    'No se puede eliminar',
                    'Este tipo de documento está asociado a uno o más usuarios.',
                    'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
                );
                return;
            }

            // Eliminar si no hay relaciones
            $resultado = $this->model->eliminarTipoDocumento($id);

            if ($resultado) {
                $this->showSweetAlert(
                    'success',
                    'Eliminado',
                    'El tipo de documento fue eliminado correctamente.',
                    'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
                );
            } else {
                $this->showSweetAlert(
                    'error',
                    'Error',
                    'No se pudo eliminar el tipo de documento.',
                    'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
                );
            }

        } else {
            $this->showSweetAlert(
                'warning',
                'ID inválido',
                'No se especificó un ID válido para eliminar.',
                'index.php?modulo=tipoDocumento&controlador=tipoDocumento&funcion=consult'
            );
        }
    }
}
