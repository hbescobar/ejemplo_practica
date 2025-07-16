<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
