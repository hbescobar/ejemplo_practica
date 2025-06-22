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

    public function obtenerCategoriasPorTipoElemento($tipo_id)
    {
        $tipo_id = intval($tipo_id);

        $sql = "SELECT cate_id, cate_nombre 
            FROM categoria 
            WHERE telem_id = $tipo_id 
            ORDER BY cate_nombre ASC";

        $result = $this->consult($sql);
        $categorias = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $categorias[] = $row;
        }

        return $categorias;
    }


    public function consultarPrestamos()
    {
        $sql = "
        SELECT 
            p.id_prestamo,
            p.fecha_solicitud,
            p.estado_prestamo_id,
            u.usu_nombre,
            u.usu_apellido
        FROM prestamos_inventario p
        JOIN usuario u ON p.usu_id = u.usu_id
        WHERE 1=1
    ";

        return $this->consult($sql);
    }


     public function getPrestamoById($id)
    {
        $sql = "SELECT * FROM prestamos_inventario WHERE id_prestamo = " . intval($id);
        $result = $this->consult($sql);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->getConnect()));
        }

        return $result ? mysqli_fetch_assoc($result) : null;
    }
    
    
    public function getElementosByPrestamoID($id)
    {
        $sql = "SELECT dp.elem_id, e.elem_nombre, e.elem_serie,  a.area_nombre, m.marca_nombre FROM detalle_prestamo dp JOIN elementos_inventario e ON dp.elem_id = e.elem_id LEFT JOIN area a ON e.elem_area_id = a.area_id LEFT JOIN marca m ON e.elem_marca_id = m.marca_id WHERE  id_prestamo = " . intval($id);
        $result = $this->consult($sql);
    
        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->getConnect()));
        }
    
        $elementos = [];
        while ($row = mysqli_fetch_assoc($result)) {
        $elementos[] = $row;
        }

    return $elementos;
    }

    public function sentenciaTable ($table){
        $sql = "SELECT *  FROM $table ";
        return $this->consult($sql);

    }


    public function deleteDetallePrestamo($prestamoID, $elementos)
    {
        $ids = implode(',', $elementos);
        $sql = "DELETE FROM detalle_prestamo WHERE id_prestamo = $prestamoID AND elem_id IN ($ids)";
        return $this->consult($sql);
    }

}
