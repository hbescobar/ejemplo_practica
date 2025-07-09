<?php
// ====================================
// MODELO PARA LA TABLA "elementos"
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class ElementosModel extends MasterModel
{
    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }

    // ====================================
    // OBTENER TODAS LAS AREAS
    // ====================================
    public function obtenerAreas()
    {
        $sql = "SELECT area_id, area_nombre FROM area ORDER BY area_nombre ASC";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER TODAS LAS CATEGORIAS
    // ====================================
    public function obtenerCategorias()
    {
        $sql = "SELECT cate_id, cate_nombre FROM categoria ORDER BY cate_nombre ASC";
        return $this->consult($sql);
    }

    // ====================================
    // OBTENER TODAS LAS MARCAS
    // ====================================
    public function obtenerMarcas()
    {
        $sql = "SELECT marca_id, marca_nombre FROM marca ORDER BY marca_nombre ASC";
        return $this->consult($sql);
    }

    // ======================================
    // OBTENER TODOS LOS TIPOS DE ELEMENTOS
    // ======================================
    public function obtenerTipoElementos()
    {
        $sql = "SELECT telem_id, telem_nombre FROM tipo_elemento ORDER BY telem_nombre ASC";
        return $this->consult($sql);
    }

    // ======================================
    // OBTENER TODAS LAS UNIDADES DE MEDIDA
    // ======================================
    public function obtenerUnidadMedida()
    {
        $sql = "SELECT id_unidad_medidas, nombre FROM unidad_medida ORDER BY nombre ASC";
        return $this->consult($sql);
    }

    // ====================================
    // No duplicar códigos elementos
    // ====================================
    public function existsCodigo(string $codigo): bool //esta funcion verifica si el código ya existe en la base de datos,  el : bool significa que la función retornará un valor booleano (true o false)
    {
        $sql = "SELECT 1 FROM elementos_inventario
                WHERE elem_codigo = '" . mysqli_real_escape_string($this->getConnect(), $codigo) . "'
                LIMIT 1";
        return (bool) mysqli_fetch_row($this->consult($sql));
    }

    // ====================================
    // No duplicar placas
    // ====================================
    public function existsPlaca(string $placa): bool
    {
        $sql = "SELECT 1 FROM elementos_inventario
                WHERE elem_placa = '" . mysqli_real_escape_string($this->getConnect(), $placa) . "'
                LIMIT 1";
        return (bool) mysqli_fetch_row($this->consult($sql));
    }

    // ====================================
    // No duplicar series
    // ====================================
    public function existsSerie(string $serie): bool
    {
        $sql = "SELECT 1 FROM elementos_inventario
                WHERE elem_serie = '" . mysqli_real_escape_string($this->getConnect(), $serie) . "'
                LIMIT 1";
        return (bool) mysqli_fetch_row($this->consult($sql));
    }

    // ====================================
    // INSERTAR NUEVO ELEMENTO
    // ====================================
    public function insertElemento($data)
{
    $sql = "INSERT INTO elementos_inventario (
                elem_placa,
                elem_serie,
                elem_codigo,
                elem_nombre,
                elem_telem_id,
                elem_area_id,
                elem_cate_id,
                elem_cantidad,
                elem_unidad_id,
                elem_modelo,
                elem_marca_id,
                elem_estado_id,
                recomendaciones         
            ) VALUES (
                " . ($data['elem_placa']  ? "'" . $data['elem_placa']  . "'" : "NULL") . ",
                " . ($data['elem_serie']  ? "'" . $data['elem_serie']  . "'" : "NULL") . ",
                '" .  $data['elem_codigo'] . "',
                '" .  $data['elem_nombre'] . "',
                " .  $data['elem_telem_id'] . ",
                " . ($data['elem_area_id'] ?  $data['elem_area_id'] : "NULL") . ",
                " . ($data['elem_cate_id'] ?  $data['elem_cate_id'] : "NULL") . ",
                " . ($data['elem_cantidad']?  $data['elem_cantidad']: "NULL") . ",
                " . ($data['elem_unidad_id']? $data['elem_unidad_id']: "NULL") . ",
                " . ($data['elem_modelo'] ? "'" . $data['elem_modelo'] . "'" : "NULL") . ",
                " . ($data['elem_marca_id']?  $data['elem_marca_id'] : "NULL") . ",
                " .  $data['elem_estado_id'] . ",                
                " . ($data['recomendaciones']
                ? "'" . mysqli_real_escape_string($this->getConnect(),
                                                $data['recomendaciones']) . "'"
                : "NULL") . "
            )";
    return $this->insert($sql);
}


    // ======================================
    // CONSULTAR ELEMENTOS CON SUS RELACIONES
    // ======================================
    public function consultarElementos()
    {
        $sql = "SELECT 
                ei.elem_id,
                ei.recomendaciones,
                ei.elem_placa,
                ei.elem_serie,
                ei.elem_codigo,
                ei.elem_nombre,
                ei.elem_modelo,
                ei.elem_cantidad,
                ei.recomendaciones,
                te.telem_nombre AS tipo_elemento,
                a.area_nombre AS area,
                c.cate_nombre AS categoria,
                m.marca_nombre AS marca,
                u.nombre AS unidad_medida,
                es.nombre AS estado
            FROM elementos_inventario ei
            LEFT JOIN tipo_elemento te ON ei.elem_telem_id = te.telem_id
            LEFT JOIN area a ON ei.elem_area_id = a.area_id
            LEFT JOIN categoria c ON ei.elem_cate_id = c.cate_id
            LEFT JOIN marca m ON ei.elem_marca_id = m.marca_id
            LEFT JOIN unidad_medida u ON ei.elem_unidad_id = u.id_unidad_medidas
            LEFT JOIN estado_elementos es ON ei.elem_estado_id = es.id_estado_elementos
            ORDER BY ei.elem_id ASC";
            
        return $this->consult($sql);
    }

    // ======================================
    // CONSULTAR ELEMENTO POR ID
    // ======================================
    public function consultarElementoPorId($id)
    {
        $sql = "SELECT 
                ei.*,
                te.telem_nombre AS tipo_elemento,
                te.telem_id,
                a.area_nombre AS area,
                c.cate_nombre AS categoria,
                m.marca_nombre AS marca,
                u.nombre AS unidad_medida,
                es.nombre AS estado
            FROM elementos_inventario ei
            LEFT JOIN tipo_elemento te ON ei.elem_telem_id = te.telem_id
            LEFT JOIN area a ON ei.elem_area_id = a.area_id
            LEFT JOIN categoria c ON ei.elem_cate_id = c.cate_id
            LEFT JOIN marca m ON ei.elem_marca_id = m.marca_id
            LEFT JOIN unidad_medida u ON ei.elem_unidad_id = u.id_unidad_medidas
            LEFT JOIN estado_elementos es ON ei.elem_estado_id = es.id_estado_elementos
            WHERE ei.elem_id = $id
            LIMIT 1";

        return $this->consult($sql);
    }


        // ====================================
    // No duplicar códigos en otro elemento
    // ====================================
    public function existsCodigoOtro(string $codigo,int $elem_id): bool {
    $sql = "SELECT 1 FROM elementos_inventario
            WHERE elem_codigo = '" . mysqli_real_escape_string($this->getConnect(), $codigo) . "'
                AND elem_id <> $elem_id
                LIMIT 1";
        return (bool) mysqli_fetch_row($this->consult($sql));
    }

    // ====================================
    // No duplicar placas en otro elemento
    // ====================================
    public function existsPlacaOtro(string $placa,int $elem_id): bool {
        $sql = "SELECT 1 FROM elementos_inventario
                WHERE elem_placa = '" . mysqli_real_escape_string($this->getConnect(), $placa) . "'
                AND elem_id <> $elem_id
                LIMIT 1";
        return (bool) mysqli_fetch_row($this->consult($sql));
    }

    // ====================================
    // No duplicar series en otro elemento
    // ====================================
    public function existsSerieOtro(string $serie,int $elem_id): bool {
        $sql = "SELECT 1 FROM elementos_inventario
                WHERE elem_serie = '" . mysqli_real_escape_string($this->getConnect(), $serie) . "'
                AND elem_id <> $elem_id
                LIMIT 1";
        return (bool) mysqli_fetch_row($this->consult($sql));
    }

    // ====================================
    // ACTUALIZAR UN ELEMENTO
    // ====================================

    public function actualizarElemento($data)
    {
        $sql = "UPDATE elementos_inventario SET
                elem_codigo     = '" . $data['elem_codigo'] . "',
                elem_nombre     = '" . $data['elem_nombre'] . "',
                elem_telem_id   = " . $data['elem_telem_id'] . ",
                elem_placa      = " . ($data['elem_placa'] ? "'" . $data['elem_placa'] . "'" : "NULL") . ",
                elem_serie      = " . ($data['elem_serie'] ? "'" . $data['elem_serie'] . "'" : "NULL") . ",
                elem_modelo     = " . ($data['elem_modelo'] ? "'" . $data['elem_modelo'] . "'" : "NULL") . ",
                elem_area_id    = " . ($data['elem_area_id'] ? $data['elem_area_id'] : "NULL") . ",
                elem_cate_id    = " . ($data['elem_cate_id'] ? $data['elem_cate_id'] : "NULL") . ",
                elem_marca_id   = " . ($data['elem_marca_id'] ? $data['elem_marca_id'] : "NULL") . ",
                elem_cantidad   = " . ($data['elem_cantidad'] ? $data['elem_cantidad'] : "NULL") . ",
                elem_unidad_id  = " . ($data['elem_unidad_id'] ? $data['elem_unidad_id'] : "NULL") . ",
                recomendaciones = " . (
                    $data['recomendaciones']
                        ? "'" . mysqli_real_escape_string($this->getConnect(), $data['recomendaciones']) . "'"
                        : "NULL"
                ) . "

            WHERE elem_id = " . $data['elem_id'];

        return $this->update($sql);
    }

    // ==============================
    // CAMBIAR EL ESTADO DE UN ELEMENTO
    // ==============================
    public function actualizarEstadoElemento($id, $nuevoEstadoId)
    {
        $sql = "UPDATE elementos_inventario SET elem_estado_id = $nuevoEstadoId WHERE elem_id = $id";
        return $this->update($sql);
    }

    // ==============================
    // BUSCAR ESTADO POR NOMBRE
    // ==============================
    public function buscarEstadoPorNombre($nombre)
    {
        $sql = "SELECT * FROM estado_elementos WHERE nombre = '$nombre' LIMIT 1";
        $res = $this->consult($sql);
        return mysqli_fetch_assoc($res);
    }

    /* ────────────────────────────────────────────────────────────
    OBTENER ELEMENTO POR ID (sólo id y nombre)
    ────────────────────────────────────────────────────────────*/
    public function getElementoById($id)
    {
        $id = intval($id);
        $sql = "SELECT elem_id, elem_nombre
                FROM elementos_inventario
                WHERE elem_id = $id
                LIMIT 1";
        $res = $this->consult($sql);
        return $res ? mysqli_fetch_assoc($res) : null;
    }

    /* ────────────────────────────────────────────────────────────
    SUMAR CANTIDAD A UN ELEMENTO
    ────────────────────────────────────────────────────────────*/
    public function sumarCantidad($elemento_id, $cantidad)
    {
        $sql = "UPDATE elementos_inventario
                SET elem_cantidad = elem_cantidad + $cantidad
                WHERE elem_id = $elemento_id";
        return $this->update($sql);
    }
    

    /* ────────────────────────────────────────────────────────────
    REGISTRAR MOVIMIENTO DE ENTRADA
    ────────────────────────────────────────────────────────────*/
    public function registrarMovimientoEntrada($usuario_id, $elemento_id, $cantidad, $comentario, $fecha)
    {
        // Sacamos la categoría del elemento (para la FK)
        $catRow = $this->consult(
            "SELECT elem_cate_id
            FROM elementos_inventario
            WHERE elem_id = $elemento_id"
        );
        $categoria = $catRow ? mysqli_fetch_assoc($catRow)['elem_cate_id'] : 'NULL';

        $id = $this->autoincrement('id', 'movimientos_elementos');
        $descripcion = mb_substr($comentario, 0, 100); // evita overflow

        $sql = "INSERT INTO movimientos_elementos
                (id, fecha_movimiento, usuario, cantidad, categoria_elm, movimiento, descripcion)
                VALUES ($id, '$fecha', $usuario_id, $cantidad, $categoria, 'Entrada', '$descripcion')";

        return $this->insert($sql);
    }



}
