<?php
// ====================================
// CONTROLADOR PARA LA ENTIDAD "CARGA MASIVA" (USUARIOS Y ELEMENTOS)
// ====================================
include_once 'C:\xampp\htdocs\inventario\Model\Carga\CargaModel.php';

class CargaController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // Inicializa el modelo para cargar datos
    // ====================================
    public function __construct()
    {
        $this->model = new CargaModel();
    }

    // ====================================
    // MOSTRAR FORMULARIO DE CARGA DE USUARIOS
    // ====================================
    public function createUsuarios()
    {
        require_once 'C:\xampp\htdocs\inventario\Views\Carga\createUsuarios.php';
    }

    // ====================================
    // MOSTRAR FORMULARIO DE CARGA DE ELEMENTOS
    // ====================================
    public function createElements()
    {
        require_once 'C:\xampp\htdocs\inventario\Views\Carga\createElements.php';
    }

    // ====================================
    // PROCESAR CARGA MASIVA DE USUARIOS DESDE CSV
    // Valida duplicados, inserta usuarios, registra errores
    // ====================================
    public function procesarUsuarios()
    {
        $errorCarga = false;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $nombreArchivo = $_FILES['archivoUsuarios']['name'];
        $numero_documento = $_SESSION['usuario']['usu_numero_docu'];
        $sqlUsuario = "SELECT usu_id FROM usuario WHERE usu_numero_docu = '$numero_documento'";
        $resultUsuario = $this->model->consult($sqlUsuario);
        $usu_id = null;
        
        
        if ($resultUsuario && $row = mysqli_fetch_assoc($resultUsuario)) {
            $usu_id = $row['usu_id'];
        } else {
            // Manejo si no se encuentra el usuario
            echo "No se encontró el usuario con documento $numero_documento";
            exit;
        }

        $fecha = date('Y-m-d');
        $descripcion_error = 'Se carga el archivo ' . $nombreArchivo;
        $estado = 1; 

        

        $archivo = $_FILES['archivoUsuarios']['tmp_name'];
        if (!$archivo) {
            echo "Error al acceder al archivo.";
            exit;
        }

        $handle = fopen($archivo, 'r');
        if (!$handle) {
            echo "No se pudo abrir el archivo CSV.";
            exit;
        }
        $carga_id = $this->model->autoincrement('carga_id','carga_masiva');
        $sql = "INSERT INTO carga_masiva (carga_id,carga_fecha_inicio,carga_descripcion,  carga_nombre_archivo,estado_id, usu_id, carga_errores) 
        VALUES ('$carga_id', '$fecha', '$descripcion_error', '$nombreArchivo', $estado, $usu_id, NULL)";
        

        $resultCarga = $this->model->insert($sql);
        echo "<script>console.log(`$sql`);</script>";

        if(!$resultCarga) {
            echo "Error al registrar la carga masiva: " . mysqli_error($this->model->getConnect());
            exit;
        }



        $errores = [];
        $exitos = 0;
        $primera = true;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($primera) { 
                $primera = false; 
                continue; 
            }
             if (empty(array_filter($data, fn($v) => trim($v) !== ''))) {
                continue;
            }


            $numero_docu = $data[4];
            $sqlCheck = "SELECT 1 FROM usuario WHERE usu_numero_docu = '$numero_docu'";

            $resultCheck = $this->model->consult($sqlCheck);

            if ($resultCheck && mysqli_fetch_assoc($resultCheck)) {
                $errores[] = "Identificación duplicada: $numero_docu";
                $errorCarga = true;
                continue;
            }

            if (count($data) < 10 || count($data) > 10) {
                $errores[] = "Fila incompleta para usuario: $numero_docu";
                $errorCarga = true;
                continue;
            }

            $resultado = $this->model->insertTest('usuario', [
                'usu_nombre', 'usu_apellido', 'usu_telefono', 'usu_clave', 'usu_numero_docu', 
                'usu_email', 'rol_id', 'tipo_docu_id', 'estado_id', 'usu_direccion'
            ], $data);
            
            if(!$resultado){
                $errores[] = "Error al insertar usuario con identificación: $numero_docu"." revisar llaves foráneas.";
                $errorCarga = true;
            } else {
                $exitos++;
            }
        }

        fclose($handle);

        if ($errorCarga) {
            $estado = 2; 
            $descripcion_error = implode(" | ", $errores);
            $sqlError = "UPDATE carga_masiva 
                SET estado_id = $estado, 
                    carga_descripcion = 'Errores en la carga', 
                    carga_errores = '$descripcion_error'
                WHERE carga_id = '$carga_id'";
            $this->model->update($sqlError);
            echo "Se encontraron errores en la carga: " . implode(", ", $errores);
        } else {
            echo "Usuarios cargados correctamente";
        }
        exit;
    }

    // ====================================
    // PROCESAR CARGA MASIVA DE ELEMENTOS DESDE CSV
    // Valida duplicados, inserta elementos, registra errores
    // ====================================
    public function procesarElementos()
    {
        $errorCarga = false;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $nombreArchivo = $_FILES['archivoElementos']['name'];
        $numero_documento = $_SESSION['ingresoDocumento'];

        // Buscar ID del usuario que hace la carga para registro en carga_masiva
        $sqlUsuario = "SELECT usu_id FROM usuario WHERE usu_numero_docu = '$numero_documento'";
        $resultUsuario = $this->model->consult($sqlUsuario);
        $usu_id = null;

        if ($resultUsuario && $row = mysqli_fetch_assoc($resultUsuario)) {
            $usu_id = $row['usu_id'];
        } else {
            echo "No se encontró el usuario con documento $numero_documento";
            exit;
        }

        // Preparar datos para registro de carga
        $fecha = date('Y-m-d');
        $descripcion_error = 'Se carga el archivo ' . $nombreArchivo;
        $estado = 1; // Estado inicial exitoso

        // Verificar archivo CSV
        $archivo = $_FILES['archivoElementos']['tmp_name'];
        if (!$archivo) {
            echo "Error al acceder al archivo.";
            exit;
        }

        $handle = fopen($archivo, 'r');
        if (!$handle) {
            echo "No se pudo abrir el archivo CSV.";
            exit;
        }

        // Registrar inicio de carga masiva
        $carga_id = $this->model->autoincrement('carga_id', 'carga_masiva');
        $sql = "INSERT INTO carga_masiva (carga_id, carga_fecha_inicio, carga_descripcion, carga_nombre_archivo, estado_id, usu_id, carga_errores) 
                VALUES ('$carga_id', '$fecha', '$descripcion_error', '$nombreArchivo', $estado, $usu_id, NULL)";
        $this->model->insert($sql);

        $errores = [];
        $exitos = 0;
        $primera = true;

        // Leer archivo CSV línea por línea
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($primera) { // Omitir encabezado
                $primera = false;
                continue;
            }


            if (empty(array_filter($data, fn($v) => trim($v) !== ''))) {
                    continue;
            }

            $placa = trim($data[0]);


            if (count($data) < 12 || count($data) > 12) {
                $errores[] = "Fila incompleta ó se agregarón más campos a la placa: $placa";
                $errorCarga = true;
                continue;
            }

            // Validar placas duplicadas
            $sqlCheck = "SELECT 1 FROM elementos_inventario WHERE elem_placa = '$placa'";
            
            
            $resultCheck = $this->model->consult($sqlCheck);

            if ($resultCheck && mysqli_fetch_assoc($resultCheck)) {
                $errores[] = "Placa duplicada: $placa";
                $errorCarga = true;
                continue;
            }
            

            // Insertar elemento
            $sqlInsert = "INSERT INTO elementos_inventario (
                elem_placa, elem_serie, elem_codigo, elem_nombre, elem_telem_id, elem_area_id,
                elem_cate_id, elem_cantidad, elem_unidad_id, elem_modelo, elem_marca_id, elem_estado_id
            ) VALUES (
                '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', 
                '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]'
            )";
            $resultado = $this->model->insert($sqlInsert);

            if (!$resultado) {
                $errores[] = "Error al insertar elemento con placa: $placa. Revisar llaves foráneas.";
                $errorCarga = true;
            } else {
                $exitos++;
            }
        }

        fclose($handle);

        // Actualizar estado de carga si hubo errores
        if ($errorCarga) {
            $estado = 2; // Estado con errores
            $descripcion_error = implode(" | ", $errores);
            $sqlError = "UPDATE carga_masiva 
                         SET estado_id = $estado, 
                             carga_descripcion = 'Errores en la carga', 
                             carga_errores = '$descripcion_error'
                         WHERE carga_id = '$carga_id'";
            $this->model->update($sqlError);
            echo "Se encontraron errores en la carga: " . implode(", ", $errores);
        } else {
            echo "Elementos cargados correctamente.";
        }
        exit;
    }



    public function consult()
    {
        $resultado = $this->model->consultarCargaMasiva();

        $cargas = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $cargas[] = $fila;
            }
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Carga\consult.php';
    }


    public function detalle()
    {
        $carga_id = $_GET['id'] ?? null;
        if (!$carga_id) {
            echo "ID de carga no proporcionado.";
            exit;
        }

        // Traer solo la carga correspondiente al ID
        $sql = "SELECT * FROM carga_masiva WHERE carga_id = '$carga_id'";
        $resultado = $this->model->consult($sql);
        $carga = null;
        if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
            $carga = $fila;
        }

        require_once 'C:\xampp\htdocs\inventario\Views\Carga\detalle.php';
    }
}
