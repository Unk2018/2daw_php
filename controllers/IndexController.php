<?php
class IndexController
{
    public static function index()
    {
        $genre = new Genre();

        try {
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

                // Si es cliente
            } else if (isset($_SESSION['identity'])) {
                if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == url) {
                    header('Location: ' . url . 'auth/welcome');
                } else {
                    echo $GLOBALS['twig']->render(
                        'welcome.twig',
                        [
                            'genre' => $genre->findAll(),
                            'identity' => $_SESSION['identity'],
                            'url' => url
                        ]
                    );
                }

                // Si es un un usuario público
            } else {
                if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == url) {
                    header('Location: ' . url . 'index/index');
                } else {
                    echo $GLOBALS['twig']->render(
                        'index.twig',
                        [
                            'genre' => $genre->findAll(),
                            'url' => url
                        ]
                    );
                }
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

?>