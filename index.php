<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$tiempoInactividad = 600; // 600 segundos = 10 minutos

if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $tiempoInactividad) {
        // Destruye la sesión y redirige al login
        session_unset();
        session_destroy();
         header('Location: /Inventario/');
        exit();
    }
}
$_SESSION['LAST_ACTIVITY'] = time();

//======================================================
// PORFAVOR NO TOCAR LO QUE ESTA COMENTADO EN LA PARTE DE ABAJO
// YA QUE CON ESTO ME DOY CUENTA SI ESTAN LLEGANDO PERMISOS O NO 
// ATT: Cristian Sanchez.
//======================================================

// if (isset($_SESSION['usuario'])) {
//     echo '<pre style="background:#000; color:#0f0; padding:10px;">';
//     echo "Usuario en sesión:\n";
//     print_r($_SESSION['usuario']);
    
//     echo "\nPermisos en sesión:\n";
//     if (isset($_SESSION['permisos'])) {
//         print_r($_SESSION['permisos']);
//     } else {
//         echo "No hay permisos cargados en sesión.";
//     }
//     echo '</pre>';
//     exit; 
// }

include_once __DIR__ . '/Lib/helpers.php';

// Detectar si es petición AJAX
function esAjax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

$isAjax = esAjax();

// Incluir head si no es petición AJAX
if (!$isAjax) {
    include_once __DIR__ . '/Views/partials/head.php';
}

echo "<div class='contenedor'>";

// Si no hay sesión, ir al login
if (!isset($_SESSION['usuario'])) {
    $_GET['modulo'] = $_GET['modulo'] ?? 'login';
    $_GET['controlador'] = $_GET['controlador'] ?? 'login';
    $_GET['funcion'] = $_GET['funcion'] ?? 'getLogin';

    resolve();
} else {
    // Si hay sesión y no es AJAX, incluir navbar
    if (!$isAjax) {
        include_once __DIR__ . '/Views/partials/navbar.php';
    }

    if (isset($_GET['modulo']) && isset($_GET['controlador']) && isset($_GET['funcion'])) {
        resolve();
    } else {
        echo "";
    }
}

echo "</div>";

// Incluir footer solo si no es AJAX y hay sesión activa
if (!$isAjax && isset($_SESSION['usuario'])) {
    include_once __DIR__ . '/Views/partials/footer.php';
}

ob_end_flush();
?>
