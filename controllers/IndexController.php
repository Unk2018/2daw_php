<?php
class IndexController
{
    public static function index()
    {
        // Mira si ya hay un usuario iniciado (distinguiendo si es admin o no)
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == url) {
                header('Location: ' . url . 'auth/home');
            } else {
                echo $GLOBALS['twig']->render(
                    'home.twig',
                    [
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );
            }
        } else if (isset($_SESSION['identity'])) {
            if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == url) {
                header('Location: ' . url . 'auth/welcome');
            } else {
                echo $GLOBALS['twig']->render(
                    'welcome.twig',
                    [
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );
            }
        } else {
            if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == url) {
                header('Location: ' . url . 'index/index');
            } else {
                echo $GLOBALS['twig']->render(
                    'index.twig',
                    [
                        'url' => url
                    ]
                );
            }
        }
    }
}
