<?php
// ====================================
// MODELO PARA LA ENTIDAD "CATEGORIA"
// ====================================
include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class TipoDocumentoModel extends MasterModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // ============================
    // INSERTAR TIPO DE DOCUMENTO
    // ============================
    public function insertarTipoDocumento($nombre)
    {
        $nuevoId = $this->autoincrement('tipo_docu_id', 'tipo_documento');

        $sql = "INSERT INTO tipo_documento (tipo_docu_id, tipo_docu_nombre) 
                VALUES ('$nuevoId', '$nombre')";

        return $this->insert($sql);
    }

    // ============================
    // CONSULTAR TODOS LOS TIPOS
    // ============================
    public function consultarTipoDocumento()
    {
        $sql = "SELECT * FROM tipo_documento ORDER BY tipo_docu_id ASC";
        return $this->consult($sql);
    }

    // ============================
    // CONSULTAR POR ID
    // ============================
    public function consultarPorId($id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM tipo_documento WHERE tipo_docu_id = $id";
        return $this->consult($sql);
    }

    // ============================
    // EDITAR TIPO DE DOCUMENTO
    // ============================
    public function editarTipoDocumento($id, $nombre)
    {
        $id = intval($id);
        $nombre = mysqli_real_escape_string($this->getConnect(), $nombre);

        $sql = "UPDATE tipo_documento 
                SET tipo_docu_nombre = '$nombre' 
                WHERE tipo_docu_id = $id";

        return $this->update($sql);
    }

    // ============================
    // ELIMINAR TIPO DE DOCUMENTO
    // ============================
    public function eliminarTipoDocumento($id)
    {
        $id = intval($id);
        $sql = "DELETE FROM tipo_documento WHERE tipo_docu_id = $id";
        return $this->delete($sql);
    }

    // ============================
    // VERIFICAR SI EL NOMBRE DEL TIPO DE DOCUMENTO YA EXISTE
    // ============================
    public function existeNombreTipoDocumento($nombre, $excluirId = null)
    {
        $conexion = $this->getConnect();
        $nombre = mysqli_real_escape_string($conexion, trim($nombre));

        $sql = "SELECT 1 FROM tipo_documento 
                WHERE LOWER(tipo_docu_nombre) = LOWER('$nombre')";

        if ($excluirId !== null) {
            $excluirId = intval($excluirId);
            $sql .= " AND tipo_docu_id != $excluirId";
        }

        $sql .= " LIMIT 1";

        $resultado = $this->consult($sql);
        return ($resultado && mysqli_num_rows($resultado) > 0);
    }  

    // ==============================================
    // VERIFICAR SI EL TIPO DE DOCUMENTO ESTÁ ASOCIADO A USUARIOS
    // ==============================================
    public function tieneUsuariosAsociados($tipo_docu_id)
    {
        $tipo_docu_id = mysqli_real_escape_string($this->getConnect(), $tipo_docu_id);
        $sql = "SELECT 1 FROM usuario WHERE tipo_docu_id = '$tipo_docu_id' LIMIT 1";
        $resultado = $this->consult($sql);
        return ($resultado && mysqli_num_rows($resultado) > 0);
    }
}
