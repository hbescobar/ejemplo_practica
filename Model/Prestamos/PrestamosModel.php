<?php
// ====================================
// MODELO PARA LA TABLA "prestamos"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class PrestamosModel extends MasterModel
{
    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // OBTENER USUARIOS ACTIVOS PARA SELECT
    // Trae usuarios con estado activo (estado_id = 1)
    // ====================================
    public function obtenerUsuariosActivos()
    {
        $sql = "SELECT 
                usu_id, 
                usu_nombre, 
                usu_apellido, 
                usu_numero_docu, 
                usu_email 
            FROM usuario 
            WHERE estado_id = 1 
            ORDER BY usu_nombre ASC";

        $result = $this->consult($sql);
        $usuarios = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }


    // ====================================
    // OBTENER CATEGORÍAS PARA SELECT
    // ====================================
    public function obtenerCategorias()
    {
        $sql = "SELECT cate_id, cate_nombre FROM categoria ORDER BY cate_nombre ASC";
        $result = $this->consult($sql);
        $categorias = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categorias[] = $row;
        }
        return $categorias;
    }

    // ====================================
    // OBTENER ELEMENTOS DISPONIBLES PARA CHECKBOX
    // Se asume que elem_estado_id = 1 es 'disponible'
    // ====================================
    public function obtenerElementosDisponibles()
    {
        $sql = "SELECT elem_id, elem_nombre, elem_placa, elem_serie, elem_codigo, elem_telem_id, elem_cantidad
                FROM elementos_inventario 
                WHERE elem_estado_id = 1 
                ORDER BY elem_nombre ASC";
        $result = $this->consult($sql);
        $elementos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $elementos[] = $row;
        }
        return $elementos;
    }

    // ====================================
    // OBTENER ELEMENTOS DISPONIBLES POR CATEGORÍA
    // ====================================
    public function obtenerElementosPorCategorias($cate_ids)
{
    $ids = array_map('intval', $cate_ids);
    $ids_str = implode(',', $ids);
    $sql = "SELECT elem_id, elem_nombre, elem_placa, elem_serie, elem_telem_id, elem_cantidad
            FROM elementos_inventario 
            WHERE elem_estado_id = 1 AND elem_cate_id IN ($ids_str)
            ORDER BY elem_nombre ASC";
    $result = $this->consult($sql);
    $elementos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $elementos[] = $row;
    }
    return $elementos;
}

    // ====================================
    // OBTENER ÁREAS DESTINO PARA SELECT
    // ====================================
    public function obtenerAreasDestino()
    {
        $sql = "SELECT id_area_destino, nombre, descripcion FROM area_destino ORDER BY nombre ASC";
        $result = $this->consult($sql);

        $areas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $areas[] = $row;
        }

        return $areas;
    }

    
}
