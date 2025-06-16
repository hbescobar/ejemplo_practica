<?php

// Se incluye la clase base de conexion a la base de datos
include_once 'C:\xampp\htdocs\inventario\Lib\Conf\connection.php';

class MasterModel extends Connection
{
    // Insertar datos en la base de datos
    public function insert($sql)
    {
        // Ejecuta la consulta SQL y devuelve el resultado (true o false)
        $result = mysqli_query($this->getConnect(), $sql);
        return $result;
    }

    // Consultar datos (SELECT)
    public function consult($sql)
    {
        // Ejecuta la consulta SQL y devuelve los datos
        $result = mysqli_query($this->getConnect(), $sql);
        return $result;
    }

    // Actualizar datos existentes (UPDATE)
    public function update($sql)
    {
        // Ejecuta la consulta SQL y devuelve el resultado
        $result = mysqli_query($this->getConnect(), $sql);
        return $result;
    }

    // Eliminar datos (DELETE)
    public function delete($sql)
    {
        // Ejecuta la consulta SQL y devuelve el resultado
        $result = mysqli_query($this->getConnect(), $sql);
        return $result;
    }

    // Obtener el siguiente valor automatico para una tabla
    public function autoincrement($field, $table)
    {
        // Consulta el valor maximo del campo dado en la tabla
        $sql = "SELECT MAX($field) FROM $table";
        $result = $this->consult($sql);
        $resultado = mysqli_fetch_row($result);

        // Retorna el siguiente numero (maximo + 1)
        return $resultado[0] + 1;
    }
}
