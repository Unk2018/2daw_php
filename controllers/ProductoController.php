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
        $producto = new Producto();

        try {
            // Si es un admin
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
                echo $GLOBALS["twig"]->render(
                    'producto/index.twig',
                    [
                        'producto' => $producto->findAll(),
                        'identity' => $_SESSION['identity'],
                        'url' => url
                    ]
                );

                // Si es un cliente (muestra todos los productos)
            } else if (isset($_SESSION['identity'])) {
                header('Location: ' . url . 'producto/welcome');

                // Si es cualquiera sin registrarse (muestra todos los productos)
            } else {
                header('Location: ' . url . 'producto/seePublic');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Te lleva a la página de crear producto
     */
    public static function create()
    {
        try {
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
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Te muestra el producto seleccionado
     */
    public static function show()
    {
        $producto = new Producto();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
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
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Te lleva a la página para editar el producto seleccionado
     */
    public static function edit()
    {
        $producto = new Producto();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
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
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Guarda nuevo producto
     */
    public static function save()
    {
        $producto = new Producto();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
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
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Actualiza el producto seleccionado
     */
    public static function update()
    {
        $producto = new Producto();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
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
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /**
     * Elimina el producto seleccionado
     */
    public static function delete()
    {
        $producto = new Producto();

        try {
            if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
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
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    // Mira todos los productos (público)
    public static function seePublic()
    {
        $genre = new Genre();
        // Te envia a la vista pública de los listados de productos (sin opción de compra hasta
        // que te hayas logueado)
        $producto = new Producto();

        try {
            // Mira si existe género para mostrar solo productos de ese género
            if (isset($_GET['genre'])) {
                $producto->setId_genre($_GET['genre']);

                // Te pone solo los productos de ese género
                echo $GLOBALS["twig"]->render(
                    'products.twig',
                    [
                        'genre' => $genre->findAll(),
                        'producto' => $producto->filterByGenre(),
                        'url' => url
                    ]
                );

                // Muestra todos los productos
            } else {
                echo $GLOBALS["twig"]->render(
                    'products.twig',
                    [
                        'genre' => $genre->findAll(),
                        'producto' => $producto->findAllWithGenre(),
                        'url' => url
                    ]
                );
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    // Mira todos los productos (cliente)
    public static function welcome()
    {
        $genre = new Genre();
        $producto = new Producto();

        try {
            // Si es un cliente (muestra todos los productos)
            if (isset($_SESSION['identity'])) {

                // Mira si hay id del género de juego. Si no hay te muestra todos los productos.
                // Si la hay, entonces solo te muestra los productos que se quieran ver
                if (isset($_GET['genre'])) {
                    $producto->setId_genre($_GET['genre']);

                    echo $GLOBALS["twig"]->render(
                        'producto/welcome.twig',
                        [
                            'genre' => $genre->findAll(),
                            'producto' => $producto->filterByGenre(),
                            'identity' => $_SESSION['identity'],
                            'url' => url
                        ]
                    );

                    // Muestra todos los productos
                } else {

                    echo $GLOBALS["twig"]->render(
                        'producto/welcome.twig',
                        [
                            'genre' => $genre->findAll(),
                            'producto' => $producto->findAllWithGenre(),
                            'identity' => $_SESSION['identity'],
                            'url' => url
                        ]
                    );
                }
            } else {
                header('Location: ' . url . 'producto/index');
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

?>