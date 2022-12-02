<?php

class ErrorController
{
    // Redirigir a vista error 404 (no encontrado)
    public static function _404()
    {
        try {
            echo $GLOBALS['twig']->render(
                'errors/404.twig',
                [
                    'url' => url
                ]
            );
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    // Redirigir a vista error 403 (solicitud denegada)
    public static function _403()
    {
        try {
            echo $GLOBALS['twig']->render(
                'errors/403.twig',
                [
                    'url' => url
                ]
            );
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    // Redirigir a vista error 500 (petición error)
    public static function _500()
    {
        try {
            echo $GLOBALS['twig']->render(
                'errors/500.twig',
                [
                    'url' => url
                ]
            );
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

?>