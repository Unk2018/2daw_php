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
        if (isset($_SESSION['identity'])) {
            $user = new User();
            echo $GLOBALS["twig"]->render(
                'users/index.twig',
                ['users' => $user->findAll()]
            );
        } else {
            header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public function create()
    {
        if (isset($_SESSION['identity'])) {
            $user = new User();
            echo $GLOBALS["twig"]->render(
                'users/create.twig'
            );
        } else {
            header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public function show()
    {
        if (isset($_SESSION['identity'])) {
            $user = new User();
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
            echo $GLOBALS["twig"]->render(
                'users/edit.twig',
                ['user' => $user->findById($_GET['id'])]
            );
        } else {
            header('Location: http://localhost/2daw-clase/?controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public function save()
    {
        $user = new User();
        $user->setNombre($_POST['nombre']);
        $user->setEmail($_POST['email']);
        $user->setId_rol($_POST['id_rol']);
        $user->setPassword($_POST['password']);
        $user->save($user);
        header("Location: http://localhost/2daw-clase/?controller=users&action=index");
    }

    /**
     * 
     */
    public function update()
    {
        $user = new User();
        $user->setId_usuario($_POST['id_usuario']);
        $user->setNombre($_POST['nombre']);
        $user->setEmail($_POST['email']);
        $user->setId_rol($_POST['id_rol']);
        $user->setPassword($_POST['password']);
        $user->update();
        header("Location: http://localhost/2daw-clase/?controller=users&action=index");
    }
    /**
     * 
     */
    public function delete()
    {
        $user = new User();
        $user->delete($_GET['id']);
        header("Location: http://localhost/2daw-clase/?controller=users&action=index");
    }
}
