<?php
require_once 'models/User.php';

class UsersController implements Controller
{
    /**
     * 
     */
    public static function index()
    {
        // if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
        $user = new User();
        echo $GLOBALS["twig"]->render(
            'users/index.twig',
            [
                'users' => $user->findAll(),
                'identity' => $_SESSION['identity'],
                'url' => url
            ]
        );
        // } else {
        // header('Location: '.url.'auth/login');
        // }
    }

    /**
     * Crear usuarios
     */
    public static function create()
    {
        // Mira si es admin para poder ir a crear y demás
        // if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
        echo $GLOBALS["twig"]->render(
            'users/create.twig',
            [
                'identity' => $_SESSION['identity'],
                'url' => url
            ]
        );
        // } else {
        // header('Location: '.url.'auth/login');
        // }
    }

    /**
     * 
     */
    public static function show()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $user = new User();
            $user->setId_usuario($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'users/show.twig',
                [
                    'user' => $user->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * 
     */
    public static function edit()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $user = new User();
            $user->setId_usuario($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'users/edit.twig',
                [
                    'user' => $user->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Guardar usuarios creados
     */
    public static function save()
    {
        // if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
        $user = new User();
        $user->setNombre($_POST['nombre']);
        $user->setEmail($_POST['email']);
        $user->setId_rol($_POST['id_rol']);
        if (isset($_POST['password'])) {
            $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
        }
        $user->save($user);
        header('Location: '.url.'users/index');
        // } else {
        // header('Location: '.url.'auth/login');
        // }
    }

    /**
     * 
     */
    public static function update()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $user = new User();
            $user->setId_usuario($_POST['id']);
            $user->setNombre($_POST['nombre']);
            $user->setEmail($_POST['email']);
            $user->setId_rol($_POST['id_rol']);
            if (isset($_POST['password'])) {
                $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
            }
            $user->update();
            header('Location: '.url.'users/index');
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }
    /**
     * 
     */
    public static function delete()
    {
        if (isset($_SESSION['identity'])) {
            $user = new User();
            $user->setId_usuario($_GET['id']);
            $user->delete();
            header('Location: '.url.'users/index');
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }
}
