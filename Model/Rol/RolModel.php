<?php
// ====================================
// MODELO PARA LA TABLA "rol"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class RolModel extends MasterModel
{
    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // INSERTAR UN NUEVO ROL
    // ====================================
    public function insertarRol($nombre, $estado_id)
    {
        $nuevoId = $this->autoincrement('rol_id', 'rol');

        $sql = "INSERT INTO rol (rol_id, rol_nombre, estado_id) 
                VALUES ('$nuevoId', '$nombre', '$estado_id')";

        return $this->insert($sql);
    }

    // ====================================
    // CONSULTAR TODOS LOS ROLES CON SU ESTADO
    // ====================================
    public function consultarRoles()
    {
        $sql = "SELECT r.rol_id, r.rol_nombre, e.estado_nombre 
                FROM rol r 
                INNER JOIN estado e ON r.estado_id = e.estado_id
                ORDER BY r.rol_id ASC";

        return $this->consult($sql);
    }

    // ====================================
    // OBTENER TODOS LOS ESTADOS DISPONIBLES
    // ====================================
    public function obtenerEstados()
    {
        $sql = "SELECT estado_id, estado_nombre 
                FROM estado 
                ORDER BY estado_nombre ASC";

        return $this->consult($sql);
    }

    // ====================================
    // BUSCAR UN ESTADO POR SU NOMBRE
    // ====================================
    public function buscarEstadoPorNombre($nombre)
    {
        $sql = "SELECT * FROM estado 
                WHERE estado_nombre = '$nombre' 
                LIMIT 1";

        $result = $this->consult($sql);
        return mysqli_fetch_assoc($result);
    }

    // ====================================
    // ACTUALIZAR SOLO EL ESTADO DE UN ROL
    // ====================================
    public function actualizarEstadoRol($rol_id, $estado_id)
    {
        $sql = "UPDATE rol 
                SET estado_id = '$estado_id' 
                WHERE rol_id = '$rol_id'";

        return $this->update($sql);
    }

    // ====================================
    // OBTENER UN ROL POR SU ID
    // ====================================
    public function obtenerRolPorId($rol_id)
    {
        $sql = "SELECT r.rol_id, r.rol_nombre, r.estado_id, e.estado_nombre
                FROM rol r 
                INNER JOIN estado e ON r.estado_id = e.estado_id
                WHERE r.rol_id = '$rol_id'
                LIMIT 1";

        $result = $this->consult($sql);
        return mysqli_fetch_assoc($result);
    }

    // ====================================
    // ACTUALIZAR UN ROL COMPLETO (NOMBRE Y ESTADO)
    // ====================================
    public function actualizarRol($rol_id, $nombre, $estado_id)
    {
        $sql = "UPDATE rol 
                SET rol_nombre = '$nombre', estado_id = '$estado_id' 
                WHERE rol_id = '$rol_id'";

        return $this->update($sql);
    }

    // ================================
    // ELIMINAR UN ROL POR SU ID
    // ================================
    public function eliminarRol($rol_id)
    {
        // Creamos la consulta para eliminar
        $sql = "DELETE FROM rol WHERE rol_id = '$rol_id'";

        // Ejecutamos la eliminación
        return $this->delete($sql);
    }

    // ====================================
    // CONSULTAR TODOS LOS MÓDULOS
    // ====================================
    public function consultarModulos()
    {
        $sql = "SELECT modulo_id, modulo_nombre 
                FROM modulos 
                ORDER BY modulo_nombre ASC";

        return $this->consult($sql);
    }

    // ====================================
    // CONSULTAR TODOS LOS PERMISOS
    // ====================================
    public function consultarPermisos()
    {
        $sql = "SELECT id_permisos, nombre_permiso 
                FROM permisos 
                ORDER BY nombre_permiso ASC";

        return $this->consult($sql);
    }

    // ====================================
    // OBTENER LA RELACIÓN PERMISOS-MÓDULOS
    // ====================================
    public function obtenerDetalleModulosPermisos()
    {
        $sql = "SELECT id_detalle, id_permiso, id_modulo 
                FROM detalle_modulos_permisos";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER PERMISOS ACTIVOS ASIGNADOS A UN ROL
    // ====================================
    public function obtenerPermisosPorRol($rol_id)
    {
        $sql = "SELECT modulo_id, id_permisos, activo
            FROM rol_permisos
            WHERE rol_id = $rol_id AND activo = 1";

        $resultado = $this->consult($sql);
        $permisosAsignados = [];

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $clave = $fila['modulo_id'] . '_' . $fila['id_permisos'];
                $permisosAsignados[$clave] = (int)$fila['activo'];
            }
        }

        return $permisosAsignados;
    }


    // ====================================
    // DESACTIVAR TODOS LOS PERMISOS DE UN ROL (ANTES ELIMINABA)
    // ====================================
    public function eliminarPermisosPorRol($rol_id)
    {
        $rol_id = (int)$rol_id;
        $sql = "UPDATE rol_permisos SET activo = 0 WHERE rol_id = $rol_id";
        return $this->update($sql);
    }


    // ====================================
    // INSERTAR UN PERMISO A UN ROL
    // ====================================
    public function insertarPermisoRol($rol_id, $permiso_id, $modulo_id)
    {
        $rol_id = (int)$rol_id;
        $permiso_id = (int)$permiso_id;
        $modulo_id = (int)$modulo_id;

        // Verificar si ya existe ese permiso para ese rol y módulo
        $sqlVerificar = "SELECT 1 FROM rol_permisos 
                     WHERE rol_id = $rol_id AND id_permisos = $permiso_id AND modulo_id = $modulo_id";

        $resultado = $this->consult($sqlVerificar);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            // Ya existe, lo activamos
            return $this->activarPermisoRol($rol_id, $permiso_id, $modulo_id);
        } else {
            // No existe, insertamos
            $sqlInsertar = "INSERT INTO rol_permisos (rol_id, id_permisos, modulo_id, activo) 
                        VALUES ($rol_id, $permiso_id, $modulo_id, 1)";
            return $this->insert($sqlInsertar);
        }
    }
    
    // ====================================
    // ACTIVAR PERMISO DE UN ROL
    // ====================================
    public function activarPermisoRol($rol_id, $permiso_id, $modulo_id)
    {
        $sql = "UPDATE rol_permisos 
                SET activo = 1 
                WHERE rol_id = $rol_id AND id_permisos = $permiso_id AND modulo_id = $modulo_id";
        return $this->update($sql);
    }

    // ====================================
    // DESACTIVAR PERMISO DE UN ROL
    // ====================================
    public function desactivarPermisoRol($rol_id, $permiso_id, $modulo_id)
    {
        $sql = "UPDATE rol_permisos 
                SET activo = 0 
                WHERE rol_id = $rol_id AND id_permisos = $permiso_id AND modulo_id = $modulo_id";
        return $this->update($sql);
    }

    public function existeNombreRol($nombre, $id = null)
    {
        $nombre = mysqli_real_escape_string($this->getConnect(), $nombre);

        $sql = "SELECT COUNT(*) as total FROM rol WHERE rol_nombre = '$nombre'";

        if ($id !== null) {
            $id = mysqli_real_escape_string($this->getConnect(), $id);
            $sql .= " AND rol_id != '$id'";
        }

        $resultado = $this->consult($sql);
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
            return $fila['total'] > 0;
        }

        return false;
    }

    // ====================================
    // VERIFICAR SI EL ROL ESTÁ ASOCIADO A USUARIOS
    // ====================================
    public function tieneUsuariosAsociados($rol_id)
    {
        $rol_id = mysqli_real_escape_string($this->getConnect(), $rol_id);
        $sql = "SELECT 1 FROM usuario WHERE rol_id = '$rol_id' LIMIT 1";
        $resultado = $this->consult($sql);
        return ($resultado && mysqli_num_rows($resultado) > 0);
    }
}
