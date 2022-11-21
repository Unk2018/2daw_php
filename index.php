<?php

/**
 * El API de Twig me obliga a colocar estas líneas para utilizar el motor de plantillas
 * Instalarse Twig mediante el siguiente comando en la terminal: composer require "twig/twig:^3.0"
 * En nuestro caso, usamos -> composer require "twig/twig"
 * Esto instala la versión más actual de twig.
 */

// Carga el fichero autoload.php y demás ficheros
require_once 'config/Parameters.php';
require_once 'vendor/autoload.php';
include 'controllers/UsersController.php';
include 'controllers/AuthController.php';
include 'controllers/IndexController.php';
include 'controllers/ErrorController.php';
include 'controllers/ProductosController.php';
include 'controllers/CategoriasController.php';
include 'controllers/CarritoController.php';
include 'controllers/PedidosController.php';

// // Ubicación de mis plantillas de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$GLOBALS["twig"];

session_start();

/* Primero comprueba que controlador voy a cargar por URL */

/* Tengo que comprobar si $controller tiene algo */
if (isset($_GET['controller'])) {
    // ucfirst() -> UpperCase First
    $controller = ucfirst($_GET['controller']) . 'Controller'; //UsersController

    /* Una vez he recogido el controlador por URL y lo tengo transformado a mi formato,
    debo comprobar que existe una clase con ese nombre */
    if (class_exists($controller)) {
        // ucfirst() -> UpperCase First
        $controller_object = new $controller(); // UsersController

        /* Creo un objeto de la clase $controller y procedo a comprobar el método de la URL */
        if (isset($_GET['action'])) {
            /* Recoger la acción de mi controlador y guardarla en una variable */
            $action = $_GET['action'];
            $controller_object->$action();
        }
    } else {
        /*
        Error en el caso de no encontrar la clase o no existe
        Lanzar error 404
        CAMBIAR CABECERA
        */
        ErrorController::_404();
    }
} else {
    // Si no existe un controller en mi url, recojo un controlador por defecto
    // Si no existe una action en mi url, recojo una action por defecto
    $controller_default = controller_default;    
    $action_default = action_default;
    $controller = new $controller_default();
    $controller::$action_default();

    // Mi acción por defecto es lanzar mi index.twig como página de caída
    //echo $twig->render('index.twig');
}

?>
<!---->