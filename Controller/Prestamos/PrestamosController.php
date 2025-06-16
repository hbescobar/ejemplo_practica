<?php
// ==============================
// CONTROLADOR DE PRÉSTAMOS
// ==============================

include_once 'C:\xampp\htdocs\inventario\Model\Prestamos\PrestamosModel.php';

class PrestamosController
{
    private $model;

    // ==============================
    // CONSTRUCTOR: CREA EL MODELO
    // ==============================
    public function __construct()
    {
        $this->model = new PrestamosModel();
    }

    // ==============================
    // MOSTRAR FORMULARIO PARA CREAR UN PRÉSTAMO
    // ==============================
    public function getInsert()
    {

        $usuarios = $this->model->obtenerUsuariosActivos();
        $categorias = $this->model->obtenerCategorias();
        $elementos = $this->model->obtenerElementosDisponibles();
        $destinos = $this->model->obtenerAreasDestino(); 

        require_once 'C:\xampp\htdocs\inventario\Views\Prestamos\insert.php';
    }

    // ==============================
    // OBTENER ELEMENTOS POR CATEGORÍA (AJAX)
    // ==============================
    public function getElementosPorCategoria()
    {
        if (isset($_POST['cate_id'])) {
            $cate_id = intval($_POST['cate_id']);
            $elementos = $this->model->obtenerElementosPorCategoria($cate_id);

            if (!empty($elementos)) {
                foreach ($elementos as $elem) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="elementos[]" value="' . $elem['elem_id'] . '" id="elem_' . $elem['elem_id'] . '">';
                    echo '<label class="form-check-label" for="elem_' . $elem['elem_id'] . '">';
                    echo htmlspecialchars($elem['elem_nombre']) . ' (Placa: ' . htmlspecialchars($elem['elem_placa']) . ', Serie: ' . htmlspecialchars($elem['elem_serie']) . ')';
                    echo '</label></div>';
                }
            } else {
                echo '<p class="text-warning">No hay elementos disponibles en esta categoría.</p>';
            }
        } else {
            echo '<p class="text-danger">Categoría no recibida.</p>';
        }

        exit;
    }
    
}
