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
    public function validarLogin($num_docum, $clave, $rol_id)
    {
        
        $sql = "SELECT * FROM usuario
        WHERE usu_numero_docu = '$num_docum' 
        AND usu_clave = '$clave' 
        AND rol_id = $rol_id
        AND estado_id = 1
        LIMIT 1";


        $resultado = $this->consult($sql);

        // Validar si hay resultados
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }

        return false; // Login fallido
    }
    
}