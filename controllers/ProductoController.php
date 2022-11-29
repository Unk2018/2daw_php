<?php
require_once 'models/Producto.php';
require_once 'models/Genre.php';

class ProductoController implements Controller
{
    /**
     * Index que determina si vas o al error o a otra página
     */
    public static function index()
    {
        // Si es un admin
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $producto = new Producto();

            echo $GLOBALS["twig"]->render(
                'producto/index.twig',
                [
                    'producto' => $producto->findAll(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si es un cliente
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'producto/welcome');

            // Si es cualquiera sin registrarse
        } else {
            header('Location: ' . url . 'auth/seePublic');
        }
    }

    /**
     * Te lleva a la página de crear producto
     */
    public static function create()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            echo $GLOBALS["twig"]->render(
                'producto/create.twig',
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
     * Te muestra el producto seleccionado
     */
    public static function show()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $producto = new Producto();
            $producto->setId_producto($_GET['id']);

            echo $GLOBALS["twig"]->render(
                'producto/show.twig',
                [
                    'producto' => $producto->findById(),
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
     * Te lleva a la página para editar el producto seleccionado
     */
    public static function edit()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $producto = new Producto();
            $producto->setId_producto($_GET['id']);

            echo $GLOBALS["twig"]->render(
                'producto/edit.twig',
                [
                    'producto' => $producto->findById(),
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
     * Guarda nuevo producto
     */
    public static function save()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $producto = new Producto();
            $producto->setId_genre($_POST['id_genre']);
            $producto->setNombre($_POST['nombre']);
            $producto->setCantidad($_POST['cantidad']);
            $producto->setPrecio(str_replace(",", ".", $_POST['precio']));
            $producto->save();

            header('Location: ' . url . 'producto/index');

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Actualiza el producto seleccionado
     */
    public static function update()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $producto = new Producto();
            $producto->setId_producto($_POST['id']);
            $producto->setId_genre($_POST['id_genre']);
            $producto->setNombre($_POST['nombre']);
            $producto->setCantidad($_POST['cantidad']);
            $producto->setPrecio(str_replace(",", ".", $_POST['precio']));
            $producto->update();

            header('Location: ' . url . 'producto/index');

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'error/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }
    /**
     * Elimina el producto seleccionado
     */
    public static function delete()
    {
        if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            $producto = new Producto();
            $producto->setId_producto($_GET['id']);
            $producto->delete();
            header('Location: ' . url . 'producto/index');

            // Si no tiene permiso, te dirige al error 403
        } else if (isset($_SESSION['identity'])) {
            header('Location: ' . url . 'errors/_403');

            // Te dirige al login
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    // Mira todos los productos (público)
    public static function seePublic()
    {
    }

    // Mira todos los productos (cliente)
    public static function welcome()
    {
    }
}
