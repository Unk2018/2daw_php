<?php
require_once 'models/Producto.php';
require_once 'models/Genre.php';

class ProductoController implements Controller
{
    /**
     * 
     */
    public static function index()
    {
        if (isset($_SESSION['identity'])) {
            $producto = new Producto();
            $genre = new Genre();

            echo $GLOBALS["twig"]->render(
                'producto/index.twig',
                [
                    'producto' => $producto->findAll(),
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
            $genre = new Genre();

            echo $GLOBALS["twig"]->render(
                'producto/create.twig',
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
    public static function show()
    {
        if (isset($_SESSION['identity'])) {
            $producto = new Producto();
            $genre = new Genre();
            $producto->setId_producto($_GET['id']);

            echo $GLOBALS["twig"]->render(
                'producto/show.twig',
                [
                    'producto' => $producto->findById(),
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
    public static function edit()
    {
        if (isset($_SESSION['identity'])) {
            $producto = new Producto();
            $genre = new Genre();
            $producto->setId_producto($_GET['id']);

            echo $GLOBALS["twig"]->render(
                'producto/edit.twig',
                [
                    'producto' => $producto->findById(),
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
    public static function save()
    {
        if (isset($_SESSION['identity'])) {
            $producto = new Producto();
            $producto->setId_genre($_POST['id_genre']);
            $producto->setNombre($_POST['nombre']);
            $producto->setCantidad($_POST['cantidad']);
            $producto->setPrecio(str_replace(",", ".", $_POST['precio']));
            $producto->save();

            header('Location: ' . url . 'controller=producto&action=index');
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
            $producto = new Producto();
            $producto->setId_producto($_POST['id']);
            $producto->setId_genre($_POST['id_genre']);
            $producto->setNombre($_POST['nombre']);
            $producto->setCantidad($_POST['cantidad']);
            $producto->setPrecio(str_replace(",", ".", $_POST['precio']));
            $producto->update();

            header('Location: ' . url . 'controller=producto&action=index');
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
            $producto = new Producto();
            $producto->setId_producto($_GET['id']);
            $producto->delete();
            header('Location: ' . url . 'controller=producto&action=index');
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }
}

?>