<?php
// ====================================
// CONTROLADOR PARA EL LOGIN
// ====================================

include_once 'C:\xampp\htdocs\inventario\Model\Login\LoginModel.php';

class LoginController
{
    private $model;

    public function __construct()
    {
        $this->model = new LoginModel();
    }

    // ====================================
    // MOSTRAR FORMULARIO DE LOGIN
    // ====================================
    public function getLogin()
    {
        $roles = [];
        $resultado = $this->model->obtenerRoles();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $roles[] = $fila;
            }
        }

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

            $usuario = $this->model->validarLogin($num_docum, $clave, $rol_id);

            if ($usuario) {
                // Validar si está activo
                if ($usuario['estado_id'] != 1) {
                    $this->showSweetAlert(
                        'warning',
                        'Usuario inhabilitado',
                        'Tu cuenta está desactivada. Contacta al administrador.',
                        'index.php?modulo=login&controlador=login&funcion=getLogin'
                    );
                    return;
                }

                // Si está activo, continuar
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['usuario'] = $usuario;

                $this->showSweetAlert(
                    'success',
                    '¡Bienvenido!',
                    'Ingreso exitoso al sistema.',
                    'index.php?modulo=dashboard&controlador=dashboard&funcion=index'
                );
            } else {
                $this->showSweetAlert(
                    'error',
                    'Credenciales incorrectas',
                    'Número de documento, clave o rol incorrecto.',
                    'index.php?modulo=login&controlador=login&funcion=getLogin'
                );
            }
        }
    }


    // ====================================
    // CERRAR SESIÓN
    // ====================================
    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: /Inventario/');
        exit();
    }

    // ====================================
    // SWEETALERT REUTILIZABLE
    // ====================================
    private function showSweetAlert($icon, $title, $text, $redirectUrl)
    {
        // Si el icono es "success", uso un color azul personalizado
        $iconColor = ($icon === 'success') ? '#0d6efd' : ''; 

        echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: '$icon',
            title: '$title',
            text: '$text',
            iconColor: '$iconColor',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didClose: () => {
                window.location.href = '$redirectUrl';
            }
        });
    </script>
    ";
        exit();
    }
}
