<?php
require_once 'models/User.php';
// Carga el fichero autoload.php
require_once 'vendor/autoload.php';

class UsersController
{
    /**
     * 
     */
    public static function index()
    {
        // if (isset($_SESSION['identity'])) {
        $user = new User();
        echo $GLOBALS["twig"]->render(
            'users/index.twig',
            ['users' => $user->findAll()]
        );
        // } else {
        // header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        // }
    }

    /**
     * Crear usuarios
     */
    public function create()
    {
        // Mira si es admin para poder ir a crear y demás
        // if (isset($_SESSION['identity']) && isset($_SESSION['admin])) {
            $user = new User();
            echo $GLOBALS["twig"]->render(
                'users/create.twig'
            );
        // } else {
            // header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        // }
    }

    /**
     * 
     */
    public function show()
    {
        if (isset($_SESSION['identity'])) {
            $user = new User();
            $user->setId_usuario($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'users/show.twig',
                ['user' => $user->findById($_GET['id'])]
            );
        } else {
            header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public function edit()
    {
        if (isset($_SESSION['identity'])) {
            $user = new User();
            $user->setId_usuario($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'users/edit.twig',
                ['user' => $user->findById($_GET['id'])]
            );
        } else {
            header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        }
    }

    /**
     * Guardar usuarios creados
     */
    public function save()
    {
        // if (isset($_SESSION['identity'])) {
            $user = new User();
            $user->setNombre($_POST['nombre']);
            $user->setEmail($_POST['email']);
            $user->setId_rol($_POST['id_rol']);
            if (isset($_POST['password'])) {
                $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
            }
            $user->save($user);
            header("Location: http://localhost/2daw-clase/?controller=users&action=index");
        // } else {
            // header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        // }
    }

    /**
     * 
     */
    public function update()
    {
        if (isset($_SESSION['identity'])) {
            $user = new User();
            $user->setId_usuario($_POST['id']);
            $user->setNombre($_POST['nombre']);
            $user->setEmail($_POST['email']);
            $user->setId_rol($_POST['id_rol']);
            if (isset($_POST['password'])) {
                $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT, ['cont' => 4]));
            }
            $user->update();
            header("Location: http://localhost/2daw-clase/?controller=users&action=index");
        } else {
            header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        }
    }
    /**
     * 
     */
    public function delete()
    {
        $user = new User();
        $user->setId_usuario($_GET['id']);
        $user->delete();
        header("Location: http://localhost/2daw-clase/?controller=users&action=index");
    }
}
