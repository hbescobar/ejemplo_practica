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
        $nuevoId = $this->autoincrement('id_area_destino', 'area_destino');
        $sql = "INSERT INTO area_destino (id_area_destino, nombre, descripcion) 
                VALUES ('$nuevoId', '$nombre', '$descripcion')";
        return $this->insert($sql);
    }

    // ============================================
    // CONSULTAR TODAS LAS AREAS
    // ============================================
    public function consultarAreas()
    {
        $sql = "SELECT * FROM area_destino ORDER BY id_area_destino ASC";
        return $this->consult($sql);
    }

    // ============================================
    // OBTENER UN AREA POR SU ID
    // ============================================
    public function obtenerAreaPorId($id)
    {
        $sql = "SELECT * FROM area_destino WHERE id_area_destino = '$id'";
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
        $sql = "UPDATE area_destino 
                SET nombre = '$nombre', descripcion = '$descripcion' 
                WHERE id_area_destino = '$id'";
        return $this->update($sql);
    }

    // ============================================
    // ELIMINAR UN AREA
    // ============================================
    public function eliminarArea($id)
    {
        $sql = "DELETE FROM area_destino WHERE id_area_destino = '$id'";
        return $this->delete($sql);
    }

    public function existeNombreArea($nombre, $idActual = null) 
    {
        if ($idActual !== null) {
            $sql = "SELECT COUNT(*) as total FROM area_destino 
                    WHERE nombre = '$nombre' AND id_area_destino != '$idActual'";
        } else {
            $sql = "SELECT COUNT(*) as total FROM area_destino 
                    WHERE nombre = '$nombre'";
        }

        $result = $this->consult($sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['total'] > 0;
        }
        return false;
    }

    // ============================================
    // VALIDAR SI EL ÁREA TIENE PRÉSTAMOS O RESERVAS ASOCIADAS
    // ============================================
    public function tieneAsociaciones($id_area)
    {
        $id_area = mysqli_real_escape_string($this->getConnect(), $id_area);

        // Verificar si hay préstamos asociados (campo: area_id)
        $sqlPrestamos = "SELECT 1 FROM prestamos_inventario WHERE area_id = '$id_area' LIMIT 1";
        $resultadoPrestamos = $this->consult($sqlPrestamos);
        if ($resultadoPrestamos && mysqli_num_rows($resultadoPrestamos) > 0) {
            return true;
        }

        // Verificar si hay reservas asociadas (campo: reserva_area_id)
        $sqlReservas = "SELECT 1 FROM reservas_inventario WHERE reserva_area_id = '$id_area' LIMIT 1";
        $resultadoReservas = $this->consult($sqlReservas);
        if ($resultadoReservas && mysqli_num_rows($resultadoReservas) > 0) {
            return true;
        }

        return false;
    }
}
