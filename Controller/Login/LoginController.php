<?php
// ====================================
// CONTROLADOR PARA EL LOGIN
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\Login\LoginModel.php';

class LoginController
{
    private $model;

    // ====================================
    // CONSTRUCTOR
    // ====================================
    public function __construct()
    {
        $this->model = new LoginModel();
    }

    // ====================================
    // MOSTRAR FORMULARIO DE LOGIN
    // ====================================
    public function getLogin()
    {
        // Obtener el resultado crudo de roles
        $resultado = $this->model->obtenerRoles();

        // Convertir el resultado mysqli_result a un array asociativo
        $roles = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $roles[] = $fila;
            }
        }

        // Pasar el array de roles a la vista
        require_once 'C:\xampp\htdocs\inventario\Views\Login\login.php';
    }

    // ====================================
    // PROCESAR EL LOGIN
    // ====================================
    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $num_docum = $_POST['usu_numero_docu'] ?? '';
            $clave = $_POST['usu_clave'] ?? '';
            $rol_id = $_POST['rol_id'] ?? '';

            if ($num_docum !== '' && $clave !== '' && $rol_id !== '') {
                $usuario = $this->model->validarLogin($num_docum, $clave, $rol_id);

                if ($usuario) {
                    session_start();
                    $_SESSION['usuario'] = $usuario;

                    // Redirigir al dashboard donde se incluye el navbar
                    header('Location: index.php?modulo=dashboard&controlador=dashboard&funcion=index');
                    exit();
                } else {
                    // Redirigir con error para mostrar alerta
                    header('Location: index.php?modulo=login&controlador=login&funcion=getLogin&error=1');
                    exit();
                }
            } else {
                // Redirigir con error para mostrar alerta
                header('Location: index.php?modulo=login&controlador=login&funcion=getLogin&error=1');
                exit();
            }
        }
    }

    // ====================================
    // CERRAR SESIÓN
    // ====================================
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /Inventario/');
        exit();
    }
}   