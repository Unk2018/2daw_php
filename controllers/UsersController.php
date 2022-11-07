<?php
require_once 'models/User.php';
// Carga el fichero autoload.php
require_once 'vendor/autoload.php';

class UsersController
{

    /**
     * 
     */
    public function index()
    {
        $user = new User();
        echo $GLOBALS["twig"]->render(
            'users/index.twig',
            ['users' => $user->findAll()]
        );
    }

    /**
     * 
     */
    public function create()
    {
        $user = new User();
        echo $GLOBALS["twig"]->render(
            'users/create.twig'
        );
    }

    /**
     * 
     */
    public function show()
    {
        $user = new User();
        echo $GLOBALS["twig"]->render(
            'users/show.twig',
            ['user' => $user->findById($_GET['id'])]
        );
    }

    /**
     * 
     */
    public function edit()
    {
        $user = new User();
        echo $GLOBALS["twig"]->render(
            'users/edit.twig',
            ['user' => $user->findById($_GET['id'])]
        );
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
