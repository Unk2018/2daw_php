<?php

/**
 * El API de Twig me obliga a colocar estas líneas para utilizar el motor de plantillas
 * Instalarse Twig mediante el siguiente comando en la terminal: composer require "twig/twig:^3.0"
 * En nuestro caso, usamos -> composer require "twig/twig"
 * Esto instala la versión más actual de twig.
 */

// Carga el fichero autoload.php
require_once 'vendor/autoload.php';

// // Ubicación de mis plantillas de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$GLOBALS["twig"];

include 'controllers/UsersController.php';

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
    }
} else {
    /* Si no existe el parámetro controller en la URL, tengo que hacer algo
    Enviar un error.
    Redirigir a alguna vista.
    
    ¿Número de error que debería enviar? ¿3XX? ¿4XX?
    ¿Enviar a un controlador por defecto?
    */

    echo "Error, no existe";
    // No hay un valor controller por defecto
    echo $_GET['controller'];
}

?>
<!---->