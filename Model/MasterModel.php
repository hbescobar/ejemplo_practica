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



    public function insertTest($table, $fields, $values) {
      // Vamos a armar por partes la variable sql concatenando la información pasada por parametros
      $sql = "INSERT INTO $table ("; // Iniciamos la variable
      // Mediante un ciclo recorremos el parametro fields, y le concatenamos el valor, con una coma
      for ($i = 0; $i < sizeof($fields); $i++) { 
	$sql .= $fields[$i].",";
      }

      $sql = trim($sql, ','); // mediante la funcion trim borramos la ultima coma concatenada

      $sql .= ") VALUES ("; // añadimos el values
      for ($i = 0;$i < sizeof($values); $i++) { // lo mismo que con fields
	$sql .= "'$values[$i]'". ",";
      }
      $sql = trim($sql, ','); // quitamos la ultima coma
      $sql .= ")"; // cerramos el sql

      $result = mysqli_query($this -> getConnect(), $sql); // ejecutamos el sql creado // ejecutamos el sql creado

      return $result;

    }



    public function updateTest($table, $fields, $values, $fieldCondicional, $valCondicional)
    {
        $sql = "UPDATE $table SET ";

        for ($i = 0; $i < sizeof($fields); $i++) {
            $sql .= "$fields[$i] = '" . mysqli_real_escape_string($this->getConnect(), $values[$i]) . "',";
        }
        $sql = rtrim($sql, ',');

        
        $valCondicional = mysqli_real_escape_string($this->getConnect(), $valCondicional);

        
        $sql .= " WHERE $fieldCondicional='$valCondicional'";


        $result = mysqli_query($this->getConnect(), $sql);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->getConnect()));
        }

        return $result;
    }
}
