<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "ROL"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\Rol\RolModel.php';

class RolController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        $this->model = new RolModel();
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
        $estados = $this->model->obtenerEstados();
        require_once 'C:\xampp\htdocs\inventario\Views\Rol\insert.php';
    }

    // ====================================
    // GUARDAR UN NUEVO ROL
    // ====================================
    public function postInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['rol_nombre'] ?? '';
            $estado_id = $_POST['estado_id'] ?? '';

            if ($nombre !== '' && $estado_id !== '') {

                // Validar si el nombre del rol ya existe
                if ($this->model->existeNombreRol($nombre)) {
                    $this->showSweetAlert(
                        'warning',
                        'Nombre duplicado',
                        'El rol ya existe. Por favor, ingresa otro nombre.',
                        'index.php?modulo=rol&controlador=rol&funcion=getInsert'
                    );
                    return;
                }

                $resultado = $this->model->insertarRol($nombre, $estado_id);
                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Rol registrado',
                        'El rol fue registrado exitosamente.',
                        'index.php?modulo=rol&controlador=rol&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error al registrar',
                        'Hubo un problema al insertar el rol.',
                        'index.php?modulo=rol&controlador=rol&funcion=getInsert'
                    );
                }
            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'Todos los campos son requeridos.',
                    'index.php?modulo=rol&controlador=rol&funcion=getInsert'
                );
            }
        }
    }


    // ====================================
    // CONSULTAR TODOS LOS ROLES
    // ====================================
    public function consult()
    {
        $resultado = $this->model->consultarRoles();

        $roles = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $roles[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Rol\consult.php';
    }

    // ====================================
    // CAMBIAR ESTADO DEL ROL (Activo/Inactivo)
    // ====================================
    public function cambiarEstado()
    {
        ob_start();

        $id = $_GET['id'] ?? null;
        $nuevoEstadoNombre = $_GET['estado'] ?? null;

        if ($id && $nuevoEstadoNombre) {
            $estado = $this->model->buscarEstadoPorNombre($nuevoEstadoNombre);
            if ($estado) {
                $this->model->actualizarEstadoRol($id, $estado['estado_id']);
            }
        }

        ob_end_clean();

        header('Location: index.php?modulo=rol&controlador=rol&funcion=consult');
        exit();
    }

    // ====================================
    // FORMULARIO PARA EDITAR UN ROL
    // ====================================
    public function getEdit()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $rol = $this->model->obtenerRolPorId($id);
            $estados = $this->model->obtenerEstados();
            require_once 'C:\xampp\htdocs\inventario\Views\Rol\update.php';
        } else {
            echo "ID no válido.";
        }
    }

    // ====================================
    // ACTUALIZAR UN ROL
    // ====================================
    public function postEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['rol_id'] ?? '';
            $nombre = $_POST['rol_nombre'] ?? '';
            $estado_id = $_POST['estado_id'] ?? '';

            if ($id !== '' && $nombre !== '' && $estado_id !== '') {

                // Verificar si el nombre ya existe en otro rol
                if ($this->model->existeNombreRol($nombre, $id)) {
                    $this->showSweetAlert(
                        'warning',
                        'Nombre duplicado',
                        'Ya existe un rol con ese nombre. Por favor elige otro.',
                        "index.php?modulo=rol&controlador=rol&funcion=getEdit&id=$id"
                    );
                    return;
                }

                // Si no está duplicado, actualiza
                $resultado = $this->model->actualizarRol($id, $nombre, $estado_id);

                if ($resultado) {
                    $this->showSweetAlert(
                        'success',
                        'Rol actualizado',
                        'El rol fue actualizado exitosamente.',
                        'index.php?modulo=rol&controlador=rol&funcion=consult'
                    );
                } else {
                    $this->showSweetAlert(
                        'error',
                        'Error al actualizar',
                        'Hubo un problema al actualizar el rol.',
                        "index.php?modulo=rol&controlador=rol&funcion=getEdit&id=$id"
                    );
                }

            } else {
                $this->showSweetAlert(
                    'warning',
                    'Campos obligatorios',
                    'Todos los campos son requeridos.',
                    "index.php?modulo=rol&controlador=rol&funcion=getEdit&id=$id"
                );
            }
        }
    }

    // ====================================
    // ELIMINAR UN ROL
    // ====================================
    public function delete()
    {
        $rol_id = $_GET['id'] ?? null;

        // Validar si se recibió un ID válido
        if (!$rol_id || !is_numeric($rol_id)) {
            $this->showSweetAlert(
                'error',
                'ID inválido',
                'El ID del rol no es válido.',
                'index.php?modulo=rol&controlador=rol&funcion=consult'
            );
            return;
        }

        // Validar si el rol está en uso por algún usuario
        if ($this->model->tieneUsuariosAsociados($rol_id)) {
            $this->showSweetAlert(
                'warning',
                'No se puede eliminar',
                'Este rol está asociado a uno o más usuarios.',
                'index.php?modulo=rol&controlador=rol&funcion=consult'
            );
            return;
        }

        // Intentar eliminar el rol
        if ($this->model->eliminarRol($rol_id)) {
            $this->showSweetAlert(
                'success',
                'Rol eliminado',
                'El rol fue eliminado correctamente.',
                'index.php?modulo=rol&controlador=rol&funcion=consult'
            );
        } else {
            $this->showSweetAlert(
                'error',
                'Error',
                'No se pudo eliminar el rol. Intenta nuevamente.',
                'index.php?modulo=rol&controlador=rol&funcion=consult'
            );
        }
    }

    // ====================================
    // FORMULARIO DE ASIGNACIÓN DE PERMISOS
    // ====================================
    public function getPermisos()
    {
        $rol_id = $_GET['id'] ?? null;

        if (!$rol_id) {
            exit('No se recibió el ID del rol.');
        }

        // Obtener datos del rol
        $rol = $this->model->obtenerRolPorId($rol_id);
        if (!$rol) {
            exit('Rol no encontrado.');
        }

        $modulos = $this->model->consultarModulos();
        $permisos = $this->model->consultarPermisos();

        // Obtener permisos activos asignados al rol (array con claves moduloId_permisoId)
        $rolPermisos = $this->model->obtenerPermisosPorRol($rol_id);

        $rol_id = $rol['rol_id'];
        $rol_nombre = $rol['rol_nombre'];
        require_once 'C:\xampp\htdocs\inventario\Views\Rol\permisos.php';
    }

    // ====================================
    // OBTENER TODOS LOS MÓDULOS
    // ====================================
    public function obtenerModulos()
    {
        $resultado = $this->model->consultarModulos();
        $modulos = [];

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $modulos[] = $fila;
            }
        }

        return $modulos;
    }

    // ====================================
    // OBTENER TODOS LOS PERMISOS
    // ====================================
    public function obtenerPermisos()
    {
        $resultado = $this->model->consultarPermisos();
        $permisos = [];

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $permisos[] = $fila;
            }
        }

        return $permisos;
    }

    // ====================================
    // GUARDAR PERMISOS ASIGNADOS A UN ROL
    // ====================================
    public function guardarPermisos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rol_id = $_GET['id'] ?? null;

            if (!$rol_id) {
                echo "ID de rol no válido.";
                return;
            }

            $rol_id = (int)$rol_id;
            $permisos = $_POST['permisos'] ?? [];

            // Eliminar todos los permisos anteriores para este rol
            $this->model->eliminarPermisosPorRol($rol_id);

            // Insertar los permisos enviados
            foreach ($permisos as $modulo_id => $permisosModulo) {
                foreach ($permisosModulo as $permiso_id => $valor) {
                    if ($valor == 1) {
                        $this->model->insertarPermisoRol($rol_id, (int)$permiso_id, (int)$modulo_id);
                    }
                }
            }

            header('Location: index.php?modulo=rol&controlador=rol&funcion=consult');
            exit();
        }
    }
}
