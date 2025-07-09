<?php
// ====================================
// MODELO PARA LA TABLA "usuarios"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class UsuariosModel extends MasterModel
{
    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // INSERTAR UN NUEVO USUARIO
    // ====================================
    public function insertarUsuario($data)
    {
        $nuevoId = $this->autoincrement('usu_id', 'usuario');

        $sql = "INSERT INTO usuario (
                    usu_id, usu_nombre, usu_apellido, usu_telefono, usu_numero_docu,
                    usu_email, usu_clave, rol_id, tipo_docu_id, usu_direccion
                ) VALUES (
                    '$nuevoId', '{$data['usu_nombre']}', '{$data['usu_apellido']}', '{$data['usu_telefono']}', '{$data['usu_numero_docu']}',
                    '{$data['usu_email']}', '{$data['usu_clave']}', '{$data['rol_id']}', '{$data['tipo_docu_id']}', '{$data['usu_direccion']}'
                )";

        return $this->insert($sql);
    }

    // ====================================
    // CONSULTAR TODOS LOS USUARIOS CON RELACIONES
    // ====================================
    public function consultarUsuarios()
    {
        $sql = "SELECT u.usu_id, u.usu_nombre, u.usu_apellido, u.usu_telefono, u.usu_numero_docu,
                       u.usu_email, u.usu_clave, u.usu_direccion,
                       r.rol_nombre, t.tipo_docu_nombre, e.estado_nombre
                FROM usuario u
                INNER JOIN rol r ON u.rol_id = r.rol_id
                INNER JOIN tipo_documento t ON u.tipo_docu_id = t.tipo_docu_id
                INNER JOIN estado e ON u.estado_id = e.estado_id
                ORDER BY u.usu_id ASC";

        return $this->consult($sql);
    }

    // ====================================
    // OBTENER UN USUARIO POR SU ID
    // ====================================
    public function obtenerUsuarioPorId($usu_id)
    {
        $sql = "SELECT u.*, r.rol_nombre, t.tipo_docu_nombre, e.estado_nombre
            FROM usuario u
            INNER JOIN rol r ON u.rol_id = r.rol_id
            INNER JOIN tipo_documento t ON u.tipo_docu_id = t.tipo_docu_id
            INNER JOIN estado e ON u.estado_id = e.estado_id
            WHERE u.usu_id = '$usu_id'
            LIMIT 1";

        $resultado = $this->consult($sql);
        return mysqli_fetch_assoc($resultado);
    }


    // ====================================
    // ACTUALIZAR UN USUARIO
    // ====================================
    public function actualizarUsuario($data)
    {
        $sql = "UPDATE usuario SET
                    usu_nombre = '{$data['usu_nombre']}',
                    usu_apellido = '{$data['usu_apellido']}',
                    usu_telefono = '{$data['usu_telefono']}',
                    usu_numero_docu = '{$data['usu_numero_docu']}',
                    usu_email = '{$data['usu_email']}',
                    usu_clave = '{$data['usu_clave']}',
                    rol_id = '{$data['rol_id']}',
                    tipo_docu_id = '{$data['tipo_docu_id']}',
                    usu_direccion = '{$data['usu_direccion']}'
                WHERE usu_id = '{$data['usu_id']}'";

        return $this->update($sql);
    }

    // ====================================
    // ELIMINAR UN USUARIO POR SU ID
    // ====================================
    public function eliminarUsuario($usu_id)
    {
        $sql = "DELETE FROM usuario WHERE usu_id = '$usu_id'";
        return $this->delete($sql);
    }

    // ====================================
    // BUSCAR UN ESTADO POR SU NOMBRE
    // ====================================
    public function buscarEstadoPorNombre($nombre)
    {
        $sql = "SELECT * FROM estado WHERE estado_nombre = '$nombre' LIMIT 1";
        $result = $this->consult($sql);
        return mysqli_fetch_assoc($result);
    }

    // ====================================
    // ACTUALIZAR SOLO EL ESTADO DE UN USUARIO
    // ====================================
    public function actualizarEstadoUsuario($usu_id, $estado_id)
    {
        $sql = "UPDATE usuario SET estado_id = '$estado_id' WHERE usu_id = '$usu_id'";
        return $this->update($sql);
    }

    // ====================================
    // OBTENER TODOS LOS ROLES
    // ====================================
    public function obtenerRoles()
    {
        $sql = "SELECT rol_id, rol_nombre FROM rol ORDER BY rol_nombre ASC";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER TODOS LOS TIPOS DE DOCUMENTO
    // ====================================
    public function obtenerTiposDocumento()
    {
        $sql = "SELECT tipo_docu_id, tipo_docu_nombre FROM tipo_documento ORDER BY tipo_docu_nombre ASC";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER TODOS LOS ESTADOS
    // ====================================
    public function obtenerEstados()
    {
        $sql = "SELECT estado_id, estado_nombre FROM estado ORDER BY estado_nombre ASC";
        return $this->consult($sql);
    }

    // ====================================
    // VALIDAR SI EXISTE UN NÚMERO DE DOCUMENTO
    // ====================================
    public function existeNumeroDocumento($numero)
    {
        $sql = "SELECT 1 FROM usuario WHERE usu_numero_docu = '$numero' LIMIT 1";
        return mysqli_num_rows($this->consult($sql)) > 0;
    }

    // ====================================
    // VALIDAR SI UN NÚMERO DE DOCUMENTO ESTÁ DUPLICADO EN OTRO USUARIO
    // ====================================
    public function documentoDuplicadoEnOtro($numero, $idActual)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM usuario
                WHERE usu_numero_docu = '$numero'
                AND usu_id <> '$idActual'";   //excluye al propio usuario
        $res = $this->consult($sql);
        $row = mysqli_fetch_assoc($res);
        return $row['total'] > 0;               //true si algún OTRO lo tiene
    }
}
