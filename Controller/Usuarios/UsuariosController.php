<?php
// ==============================
// CONTROLADOR DE USUARIOS
// ==============================

include_once 'C:\xampp\htdocs\inventario\Model\Usuarios\UsuariosModel.php';

class UsuariosController
{
    private $model;

    // ==============================
    // CONSTRUCTOR: CREA EL MODELO
    // ==============================
    public function __construct()
    {
        $this->model = new UsuariosModel();
    }

    // ==============================
    // MOSTRAR FORMULARIO PARA REGISTRAR UN NUEVO USUARIO
    // ==============================
    public function getInsert()
    {
        $roles = $this->model->obtenerRoles();
        $tipos_doc = $this->model->obtenerTiposDocumento();
        $estados = $this->model->obtenerEstados();

        require_once 'C:\xampp\htdocs\inventario\Views\Usuarios\insert.php';
    }

    // ==============================
    // GUARDAR UN NUEVO USUARIO
    // ==============================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'usu_nombre'      => $_POST['usu_nombre'] ?? '',
                'usu_apellido'    => $_POST['usu_apellido'] ?? '',
                'usu_telefono'    => $_POST['usu_telefono'] ?? '',
                'usu_numero_docu'   => $_POST['usu_numero_docu'] ?? '',
                'usu_email'       => $_POST['usu_email'] ?? '',
                'usu_clave'       => $_POST['usu_clave'] ?? '',
                'rol_id'          => $_POST['rol_id'] ?? '',
                'tipo_docu_id'    => $_POST['tipo_docu_id'] ?? '',
                'estado_id'       => $_POST['estado_id'] ?? '',
                'usu_direccion'   => $_POST['usu_direccion'] ?? '',
            ];

            // Validación básica
            if ($data['usu_nombre'] && $data['usu_apellido'] && $data['rol_id']) {
                $resultado = $this->model->insertarUsuario($data);
                if ($resultado) {
                    header('Location: index.php?modulo=usuarios&controlador=usuarios&funcion=consult');
                    exit();
                } else {
                    echo "Error al insertar el usuario.";
                }
            } else {
                echo "Los campos obligatorios no fueron completados.";
            }
        }
    }

    // ==============================
    // MOSTRAR LA LISTA DE USUARIOS
    // ==============================
    public function consult()
    {
        $resultado = $this->model->consultarUsuarios();

        $usuarios = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Usuarios\consult.php';
    }

    // ==============================
    // MOSTRAR FORMULARIO PARA EDITAR UN USUARIO
    // ==============================
    public function getEdit()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $usuario = $this->model->obtenerUsuarioPorId($id);
            $roles = $this->model->obtenerRoles();
            $tipos_doc = $this->model->obtenerTiposDocumento();
            $estados = $this->model->obtenerEstados();

            require_once 'C:\xampp\htdocs\inventario\Views\Usuarios\update.php';
        } else {
            echo "ID no válido.";
        }
    }

    // ==============================
    // ACTUALIZAR UN USUARIO EN LA BASE DE DATOS
    // ==============================
    public function postEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'usu_id'          => $_POST['usu_id'] ?? '',
                'usu_nombre'      => $_POST['usu_nombre'] ?? '',
                'usu_apellido'    => $_POST['usu_apellido'] ?? '',
                'usu_telefono'    => $_POST['usu_telefono'] ?? '',
                'usu_numero_docu'   => $_POST['usu_numero_docu'] ?? '',
                'usu_email'       => $_POST['usu_email'] ?? '',
                'usu_clave'       => $_POST['usu_clave'] ?? '',
                'rol_id'          => $_POST['rol_id'] ?? '',
                'tipo_docu_id'    => $_POST['tipo_docu_id'] ?? '',
                'estado_id'       => $_POST['estado_id'] ?? '',
                'usu_direccion'   => $_POST['usu_direccion'] ?? '',
            ];

            if ($data['usu_id'] && $data['usu_nombre']) {
                $resultado = $this->model->actualizarUsuario($data);
                if ($resultado) {
                    header('Location: index.php?modulo=usuarios&controlador=usuarios&funcion=consult');
                    exit();
                } else {
                    echo "Error al actualizar el usuario.";
                }
            } else {
                echo "Datos incompletos.";
            }
        }
    }

    // ==============================
    // ELIMINAR UN USUARIO POR ID
    // ==============================
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->model->eliminarUsuario($id);
        }

        header('Location: index.php?modulo=usuarios&controlador=usuarios&funcion=consult');
        exit();
    }

    // ==============================
    // CAMBIAR EL ESTADO DE UN USUARIO
    // ==============================
    public function cambiarEstado()
    {
        ob_start();

        $id = $_GET['id'] ?? null;
        $estado_nombre = $_GET['estado'] ?? null;

        if ($id && $estado_nombre) {
            $estado = $this->model->buscarEstadoPorNombre($estado_nombre);
            if ($estado) {
                $this->model->actualizarEstadoUsuario($id, $estado['estado_id']);
            }
        }

        ob_end_clean();
        header('Location: index.php?modulo=usuarios&controlador=usuarios&funcion=consult');
        exit();
    }

    // ==============================
    // MOSTRAR DETALLES DE UN USUARIO
    // ==============================
    public function ver()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $usuario = $this->model->obtenerUsuarioPorId($id);
            require_once 'C:\xampp\htdocs\inventario\Views\Usuarios\ver.php';
        } else {
            echo "ID no válido.";
        }
    }
}
