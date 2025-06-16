<?php
// ====================================
// CONTROLADOR DEL DASHBOARD
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\Dashboard\DashboardModel.php';

class DashboardController
{
    private $model;

    public function __construct()
    {
        $this->model = new DashboardModel();
    }

    // Función principal para mostrar el dashboard
    public function index()
    {
        // Obtener algunos datos de ejemplo desde el modelo
        $totalUsuarios = $this->model->getTotalUsuarios();
        $totalRoles = $this->model->getTotalRoles();

        // Pasar los datos a la vista
        require_once 'C:\xampp\htdocs\inventario\index.php';
    }
}
