<?php
// ====================================
// MODELO PARA LA ENTIDAD "MARCA"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class MarcaModel extends MasterModel
{
    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // INSERTAR UNA NUEVA MARCA
    // ====================================
    public function insertarMarca($nombre, $descripcion)
    {
        // Escapar valores para evitar SQL Injection
        $nombre = mysqli_real_escape_string($this->getConnect(), $nombre);
        $descripcion = mysqli_real_escape_string($this->getConnect(), $descripcion);

        // Obtener el siguiente ID autoincrementado manualmente
        $nuevoId = $this->autoincrement('marca_id', 'marca');

        // Crear la consulta SQL para insertar la marca
        $sql = "INSERT INTO marca (marca_id, marca_nombre, marca_descripcion) VALUES ('$nuevoId', '$nombre', '$descripcion')";

        // Ejecutar la consulta y devolver resultado (true/false)
        return $this->insert($sql);
    }

    // ====================================
    // CONSULTAR TODAS LAS MARCAS
    // ====================================
    public function consultarMarcas()
    {
        $sql = "SELECT * FROM marca ORDER BY marca_id ASC";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER UNA MARCA POR ID
    // ====================================
    public function obtenerMarcaPorId($id)
    {
        $id = mysqli_real_escape_string($this->getConnect(), $id);
        $sql = "SELECT * FROM marca WHERE marca_id = '$id' LIMIT 1";
        $resultado = $this->consult($sql);
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }

    // ====================================
    // ACTUALIZAR UNA MARCA
    // ====================================
    public function actualizarMarca($id, $nombre, $descripcion)
    {
        $id = mysqli_real_escape_string($this->getConnect(), $id);
        $nombre = mysqli_real_escape_string($this->getConnect(), $nombre);
        $descripcion = mysqli_real_escape_string($this->getConnect(), $descripcion);

        $sql = "UPDATE marca SET marca_nombre = '$nombre', marca_descripcion = '$descripcion' WHERE marca_id = '$id'";
        return $this->update($sql);
    }

    // ====================================
    // ELIMINAR UNA MARCA
    // ====================================
    public function eliminarMarca($id)
    {
        $id = mysqli_real_escape_string($this->getConnect(), $id);
        $sql = "DELETE FROM marca WHERE marca_id = '$id'";
        return $this->delete($sql);
    }
}
