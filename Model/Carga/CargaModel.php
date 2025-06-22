<?php

include_once 'C:\xampp\htdocs\inventario\Model\MasterModel.php';

class CargaModel extends MasterModel {

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        parent::__construct();
    }



    public function consultarCargaMasiva()
    {
        $sql = "
        SELECT * from carga_masiva 
    ";

        return $this->consult($sql);
    }



}
