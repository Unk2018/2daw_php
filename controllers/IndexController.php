<?php
class IndexController
{
    public static function index()
    {
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
