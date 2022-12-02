<?php
require_once 'models/Producto.php';

class GenreController implements Controller
{
    /**
     * Index que determina si vas o al error o a otra página (login)
     */
    public static function index()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $genre = new Genre();

            echo $GLOBALS["twig"]->render(
                'genre/index.twig',
                [
                    'genre' => $genre->findAll(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Crea género
     */
    public static function create()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            echo $GLOBALS["twig"]->render(
                'genre/create.twig',
                [
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Muestra género seleccionado
     */
    public static function show()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $genre = new Genre();
            $genre->setId_genre($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'genre/show.twig',
                [
                    'genre' => $genre->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Edita género seleccionado
     */
    public static function edit()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $genre = new Genre();
            $genre->setId_genre($_GET['id']);
            echo $GLOBALS["twig"]->render(
                'genre/edit.twig',
                [
                    'genre' => $genre->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Guarda nuevo género
     */
    public static function save()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $genre = new Genre();
            $genre->setTipo($_POST['tipo']);
            $genre->save();
            header('Location: ' . url . 'genre/index');

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Actualiza el género seleccionado
     */
    public static function update()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $genre = new Genre();
            $genre->setId_genre($_POST['id']);
            $genre->setTipo($_POST['tipo']);
            $genre->update();
            header('Location: ' . url . 'genre/index');

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }
    /**
     * Elimina el género seleccionado
     */
    public static function delete()
    {
        $genre = new Genre();
        $prod = new Producto();

        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $genre->setId_genre($_GET['id']);
            $prod->setId_genre($_GET['id']);

            // Se elimina productos primero porque tiene una foreign key que no permite al genre
            // eliminarse primero
            $prod->deleteByGenre();
            $genre->delete();

            header('Location: ' . url . 'genre/index');

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }
}
