<?php

class AuthController
{
    /* Función para redirigir al login */
    public function login()
    {
        echo $GLOBALS['twig']->render('auth/login.twig');
    }

    public function doLogin()
    {
        /* Recoger email y password del login 
        - Mirar si password y email coinciden con el de mi base de datos
        - Password tiene que estar encriptado
        - Utilizo el modelo de usuario para lanzar el método que comprueba si he introducido los datos
        correctamente
        */
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user_ok = $user->login(); // Objeto usuario si correcto o false si no lo es

        /*  
            Almaceno en $user_ok el resultado de mi método login() 
            Compruebo si $user_ok es un objeto
            Si lo es, entonces lo guardo en una $_SESSION de nombre identity
        */
        if ($user_ok && is_object($user_ok)) {
            $_SESSION['identity'] = $user_ok;
            header('Location:'.url.'controller=auth&action=home');
        } else {
            header('Location: '.url.'index.php');
        }
    }

    public function home()
    {
        if (isset($_SESSION['identity'])) {
            echo $GLOBALS['twig']->render('home.twig');
        } else {
            header('Location: '.url.'controller=auth&action=login');
        }
    }

    /* Si está logueado, se quita identity */
    public function logout()
    {
        // Si hay una sesión iniciada, entonces quita 'identity'
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }

        header('Location: '.url.'controller=auth&action=login');
    }
}
