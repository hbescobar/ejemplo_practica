<?php

function redirect($url){
    echo "<script type='text/javascript'>"
        . "window.location.href='$url'"
        . "</script>";
}

function dd($var){
    echo "<pre>";
    die(print_r($var, true));
}

function getUrl($modulo, $controlador, $funcion, $parametros = false, $pagina = false){
    if ($pagina === false) {
        $pagina = "index";
    }

    $url = "$pagina.php?modulo=$modulo&controlador=$controlador&funcion=$funcion";

    if ($parametros !== false) {
        foreach ($parametros as $key => $value) {
            $url .= "&$key=$value";
        }
    }

    return $url;
}

function resolve(){
    // Rutas absolutas seguras
    $basePath = dirname(__DIR__); // va desde Lib hasta raíz del proyecto
    $modulo = ucwords($_GET['modulo']);
    $controlador = ucwords($_GET['controlador']);
    $funcion = $_GET['funcion'];

    $moduloPath = "$basePath/Controller/$modulo";
    $controllerFile = "$moduloPath/{$controlador}Controller.php";

    if (is_dir($moduloPath)) {
        if (is_file($controllerFile)) {
            include_once $controllerFile;
            $nombreClase = $controlador . "Controller";
            $objeto = new $nombreClase();

            if (method_exists($objeto, $funcion)) {
                $objeto->$funcion();
            } else {
                echo "La función '$funcion' no existe en el controlador '$nombreClase'";
            }
        } else {
            echo "El archivo del controlador no existe: $controllerFile";
        }
    } else {
        echo "El módulo '$modulo' no existe en la ruta: $moduloPath";
    }
}
