<?php
include_once 'C:\xampp\htdocs\inventario\Model\Reportes\ReportesModel.php';

class ReportesController
{
    private $model;

    public function __construct()
    {
        $this->model = new ReportesModel();
    }

    public function verElementos()
    {
        $elementos = $this->model->obtenerTodosElementos();
        $categorias = $this->model->obtenerCategorias();

        include_once 'Views/Reportes/verElementos.php';
    }


    // Método para mostrar el reporte de elementos más prestados
    public function verElementosMasPrestados()
    {
        $elementos = $this->model->obtenerElementosMasPrestados();
        include_once 'Views/Reportes/elementosMasPrestados.php';
    }

}
