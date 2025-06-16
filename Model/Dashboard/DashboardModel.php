<?php
// ====================================
// MODELO PARA EL DASHBOARD
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class DashboardModel extends MasterModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener total de usuarios registrados
    public function getTotalUsuarios()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuario";
        $result = $this->consult($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    // Obtener total de roles registrados
    public function getTotalRoles()
    {
        $sql = "SELECT COUNT(*) AS total FROM rol";
        $result = $this->consult($sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}
