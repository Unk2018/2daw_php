<?php

class AuthController
{
    /* Función para redirigir al login */
    public function login()
    {
        echo $GLOBALS['twig']->render(
            'auth/login_register.twig',
            [
                'url' => url
            ]
        );
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

            // Si el usuario es admin, entonces te lleva a home
            if (isset($_SESSION['admin'])) {
                header('Location:' . url . 'auth/home');
                // En caso contario, te lleva al 'home' de los clientes
            } else {
                header('Location:' . url . 'auth/welcome');
            }
        } else {
            header('Location: ' . url . 'index');
        }
    }

    public function home()
    {
        if (isset($_SESSION['identity'])) {
            echo $GLOBALS['twig']->render(
                'home.twig',
                [
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /* Si está logueado, se quita identity */
    public function logout()
    {
        // Si hay una sesión iniciada, entonces quita 'identity'
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }

        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }

        header('Location: ' . url . 'auth/login');
    }

    public static function welcome()
    {
        // Si hay una sesión iniciada, entonces quita 'identity'
        if (isset($_SESSION['identity'])) {
            echo $GLOBALS['twig']->render(
                'welcome.twig',
                [
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    public static function register()
    {
        /* Recoger nombre, email y password del register 
        - Password tiene que estar encriptado
        - Meter el id_rol de la cuenta (no puede ser 1)
        - Utilizo el modelo de usuario para lanzar el método que comprueba si he introducido los datos
        correctamente
        */
        $user = new User();
        $user->setNombre($_POST['nombreReg']);
        $user->setEmail($_POST['emailReg']);
        $user->setId_rol(2);
        if (isset($_POST['passwordReg'])) {
            $user->setPassword(password_hash($_POST['passwordReg'], PASSWORD_BCRYPT, ['cont' => 4]));
        }
        $user->register(); // Objeto usuario si correcto o false si no lo es

        // Registra los datos después y te manda/recarga página después de pasar los datos
        echo $GLOBALS['twig']->render(
            'auth/login_register.twig',
            [
                'url' => url
            ]
        );
    }
}
