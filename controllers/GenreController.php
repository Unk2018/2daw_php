<?php
require_once 'models/Producto.php';

class GenreController implements Controller
{
    /**
     * 
     */
    public static function index()
    {
        if (isset($_SESSION['identity'])) {
            $genre = new Genre();

            echo $GLOBALS["twig"]->render(
                'genre/index.twig',
                [
                    'genre' => $genre->findAll(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public static function create()
    {
        if (isset($_SESSION['identity'])) {
            echo $GLOBALS["twig"]->render(
                'genre/create.twig',
                [
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public static function show()
    {
        if (isset($_SESSION['identity'])) {
            $genre = new Genre();
            $genre->setId_genre($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'genre/show.twig',
                [
                    'user' => $genre->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public static function edit()
    {
        if (isset($_SESSION['identity'])) {
            $genre = new Genre();
            $genre->setId_genre($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'genre/edit.twig',
                [
                    'user' => $genre->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public static function save()
    {
        if (isset($_SESSION['identity'])) {
            $genre = new Genre();
            $genre->setNombre($_POST['nombre']);
            $genre->save();
            header('Location: ' . url . 'controller=genre&action=index');
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }

    /**
     * 
     */
    public static function update()
    {
        if (isset($_SESSION['identity'])) {
            $genre = new Genre();
            $genre->setId_genre($_POST['id']);
            $genre->setNombre($_POST['nombre']);
            $genre->update();
            header('Location: ' . url . 'controller=genre&action=index');
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }
    /**
     * 
     */
    public static function delete()
    {
        if (isset($_SESSION['identity'])) {
            $genre = new Genre();
            $genre->setId_genre($_GET['id']);
            $genre->delete();
            header('Location: ' . url . 'controller=genre&action=index');
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }
}

?>