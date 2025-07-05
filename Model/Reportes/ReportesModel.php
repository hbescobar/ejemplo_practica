<?php
include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class ReportesModel extends MasterModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtiene todos los elementos del inventario con sus detalles, el orde by funciona para que los elementos no devolutivos con cantidad menor a 10 aparezcan primero
    // y en rojo, mientras que los demás elementos se ordenan alfabéticamente.
    public function obtenerTodosElementos()
    {
        $sql = "SELECT 
                    ei.elem_codigo, 
                    ei.elem_nombre, 
                    ei.elem_telem_id, 
                    ei.elem_cantidad, 
                    c.cate_nombre, 
                    te.telem_nombre
                FROM elementos_inventario ei
                LEFT JOIN categoria c ON ei.elem_cate_id = c.cate_id
                LEFT JOIN tipo_elemento te ON ei.elem_telem_id = te.telem_id
                ORDER BY  
                    CASE 
                        WHEN ei.elem_telem_id = 2 AND ei.elem_cantidad < 5 THEN 0
                        ELSE 1
                    END,
                    ei.elem_nombre";

        return $this->consult($sql);
    }

    public function obtenerCategorias()
    {
        $sql = "SELECT * FROM categoria";
        return $this->consult($sql);
    }

    /**
     * Devuelve Elementos + Nº veces prestado + última fecha + usuario más frecuente
     */
    public function obtenerElementosMasPrestados()
    {
        
            $sql = "SELECT
                    ei.elem_codigo,
                    ei.elem_nombre,
                    CONCAT(u.usu_nombre, ' ', u.usu_apellido) AS usuario_mas_frecuente,
                    COUNT(DISTINCT dp.id_prestamo)            AS veces_prestado,
                    MAX(p.fecha_solicitud)                    AS ultima_fecha
                FROM detalle_prestamo dp
                JOIN prestamos_inventario p ON p.id_prestamo = dp.id_prestamo
                JOIN elementos_inventario ei ON ei.elem_id   = dp.elem_id
                JOIN usuario u              ON u.usu_id      = p.usu_id
                GROUP BY dp.elem_id, u.usu_id
                HAVING COUNT(DISTINCT dp.id_prestamo) > 1
                ORDER BY veces_prestado DESC, ei.elem_codigo";

                return $this->consult($sql);
        
    }

    
}