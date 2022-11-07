<?php
    class IndexController{
        public function index(){
            echo $GLOBALS['twig']->render(
                'index.twig', 
                ['name' => 'EJEMPLO']
            );
        }
    }
?>