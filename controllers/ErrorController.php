<?php

class ErrorController
{
    // Redirigir a vista error 404
    public static function _404()
    {
        echo $GLOBALS['twig']->render(
            'error/404.twig',
            [
                'url' => url
            ]
        );
    }

    // Redirigir a vista error 403
    public static function _403()
    {
        echo $GLOBALS['twig']->render(
            'error/403.twig',
            [
                'url' => url
            ]
        );
    }

    // Redirigir a vista error 500
    public static function _500()
    {
        echo $GLOBALS['twig']->render(
            'error/500.twig',
            [
                'url' => url
            ]
        );
    }
}

?>