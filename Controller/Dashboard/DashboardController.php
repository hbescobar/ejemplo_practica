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
        $totalUsuarios = $this->model->contarUsuariosActivos();
        require_once 'C:\xampp\htdocs\inventario\Views\Dashboard\index.php';
    }
}
