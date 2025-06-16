<?php
// ====================================
// MODELO PARA LA ENTIDAD "CATEGORIA"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class CategoriaModel extends MasterModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // INSERTAR NUEVA CATEGORIA
    // ====================================
    public function insertarCategorias($nombre, $descripcion)
    {
        $nuevoId = $this->autoincrement('cate_id', 'categoria');

        $sql = "INSERT INTO categoria (cate_id, cate_nombre, cate_descripcion) VALUES ('$nuevoId', '$nombre', '$descripcion')";
        return $this->insert($sql);
    }

    // ====================================
    // CONSULTAR TODAS LAS CATEGORIAS
    // ====================================
    public function consultarCategorias()
    {
        $sql = "SELECT * FROM categoria ORDER BY cate_id ASC";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER UNA CATEGORIA POR ID
    // ====================================
    public function obtenerCategoriaPorId($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM categoria WHERE cate_id = $id LIMIT 1";
        $resultado = $this->consult($sql);
        if ($resultado) {
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }

    // ====================================
    // ACTUALIZAR UNA CATEGORIA
    // ====================================
    public function actualizarCategoria($id, $nombre, $descripcion)
    {
        $descripcion = mysqli_real_escape_string($this->getConnect(), $descripcion);

        $sql = "UPDATE categoria SET cate_nombre = '$nombre', cate_descripcion = '$descripcion' WHERE cate_id = $id";
        return $this->update($sql);
    }

    // ====================================
    // ELIMINAR UNA CATEGORIA
    // ====================================
    public function eliminarCategoria($id)
    {
        $id = (int)$id;
        $sql = "DELETE FROM categoria WHERE cate_id = $id";
        return $this->delete($sql);
    }
}
