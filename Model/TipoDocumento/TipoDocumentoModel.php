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
}
