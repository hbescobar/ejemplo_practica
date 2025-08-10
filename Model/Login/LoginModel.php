<?php
// ====================================
// MODELO PARA LA VALIDACIÓN DE LOGIN
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class LoginModel extends MasterModel
{
    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // OBTENER TODOS LOS ROLES DISPONIBLES
    // ====================================
    public function obtenerRoles()
    {
        $sql = "SELECT rol_id, rol_nombre
                FROM rol
                ORDER BY rol_nombre ASC";

        return $this->consult($sql);
    }


    // ====================================
    // VALIDAR USUARIO PARA LOGIN 
    // ====================================
    public function validarLogin($num_docum, $clave)
    {
        $sql = "SELECT * FROM usuario
            WHERE usu_numero_docu = '$num_docum' 
            AND usu_clave = '$clave'
            LIMIT 1";

        $resultado = $this->consult($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado); // Aquí viene también el rol_id
        }

        return false;
    }

    public function obtenerPermisosPorRol($rol_id)
    {
        $sql = "SELECT modulo_id, id_permisos FROM rol_permisos WHERE rol_id = $rol_id AND activo = 1";
        $resultado = $this->consult($sql);

        $permisos = [];

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                // Guardamos como claves combinadas para fácil consulta: "modulo_permiso"
                $clave = $fila['modulo_id'] . '_' . $fila['id_permisos'];
                $permisos[$clave] = true;
            }
        }

        return $permisos;
    }
}
