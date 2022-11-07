<?php
// Carga el fichero autoload.php
require_once 'vendor/autoload.php';

// Ubicación de mis plantillas de Twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('users/create.twig');

?>