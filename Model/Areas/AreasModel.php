<?php
// ====================================
// MODELO PARA LA ENTIDAD "AREAS"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class AreasModel extends MasterModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // ============================================
    // INSERTAR UNA NUEVA AREA
    // ============================================
    public function insertarAreas($nombre, $descripcion)
    {
        $nuevoId = $this->autoincrement('area_id', 'area');
        $sql = "INSERT INTO area (area_id, area_nombre, area_descripcion) 
                VALUES ('$nuevoId', '$nombre', '$descripcion')";
        return $this->insert($sql);
    }

    // ============================================
    // CONSULTAR TODAS LAS AREAS
    // ============================================
    public function consultarAreas()
    {
        $sql = "SELECT * FROM area ORDER BY area_id ASC";
        return $this->consult($sql);
    }

    // ============================================
    // OBTENER UN AREA POR SU ID
    // ============================================
    public function obtenerAreaPorId($id)
    {
        $sql = "SELECT * FROM area WHERE area_id = '$id'";
        $resultado = $this->consult($sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }

        return false;
    }

    // ============================================
    // ACTUALIZAR UN AREA EXISTENTE
    // ============================================
    public function actualizarArea($id, $nombre, $descripcion)
    {
        $sql = "UPDATE area 
                SET area_nombre = '$nombre', area_descripcion = '$descripcion' 
                WHERE area_id = '$id'";
        return $this->update($sql);
    }

    // ============================================
    // ELIMINAR UN AREA
    // ============================================
    public function eliminarArea($id)
    {
        $sql = "DELETE FROM area WHERE area_id = '$id'";
        return $this->delete($sql);
    }

    public function existeNombreArea($nombre)
    {
        $nombre = mysqli_real_escape_string($this->getConnect(), $nombre);
        $sql = "SELECT 1 FROM area WHERE area_nombre = '$nombre' LIMIT 1";
        $resultado = $this->consult($sql);
        return ($resultado && mysqli_num_rows($resultado) > 0);
    }

    // ============================================
    // VERIFICAR SI EL NOMBRE DEL AREA YA EXISTE AL EDITAR
    // ============================================
    public function existeNombreAreaEditar($nombre, $id)
    {
        $nombre = mysqli_real_escape_string($this->getConnect(), $nombre);
        $id = mysqli_real_escape_string($this->getConnect(), $id);

        $sql = "SELECT 1 FROM area WHERE area_nombre = '$nombre' AND area_id != '$id' LIMIT 1";
        $resultado = $this->consult($sql);
        return ($resultado && mysqli_num_rows($resultado) > 0);
    }

    // ============================================
    // VERIFICAR SI UN ÁREA ESTÁ EN USO
    // ============================================
    public function areaEstaEnUso($idArea)
    {
        $sql = "SELECT 1 FROM elementos_inventario WHERE elem_area_id = '$idArea' LIMIT 1";
        $resultado = $this->consult($sql);
        return ($resultado && mysqli_num_rows($resultado) > 0);
    }
}
