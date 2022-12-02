<?php
class CarritoController
{
    public static function index()
    {
        // Si es cliente
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            header('Location: ' . url . 'carrito/show');

            // Si es admin
        } else if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            header('Location: ' . url . 'index/index');

            // Público
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    /**
     * Funcion es la que agrega un elemento a mi $_SESSION['carrito']
     */
    public static function agregar()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            /**
             * Recojo el precio del producto seleccionado
             * Ir a la base de datos, ver que producto he seleccionado(id)
             * Recoger el precio del objeto retornado
             */
            $producto = new Producto();
            $producto->setId_producto($_GET['id']);
            $producto_seleccionado = $producto->findById();

            // Asegura de que en el caso de que el carrito del usuario iniciado no exista,
            // entonces se crea y le asigna un valor por defecto (en este caso es null)
            if (!isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {
                $_SESSION['carrito'][$_SESSION['identity']->id_usuario] = null;
            }

            /**
             * Comprueba si existe el elemento en el carrito
             */
            $contador = 0;
            foreach ($_SESSION['carrito'][$_SESSION['identity']->id_usuario] as $indice => $elemento) {
                if ($elemento['producto_id'] == $producto_seleccionado->id_producto) {
                    $_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['cantidad']++;
                    $contador++;
                }
            }

            // Mi $_SESSION['carrito] contiene un array con los valores seleccionados
            // Solo se añade si no existe previamente el elemento seleccionado de la lista
            // Si no existe, introduce uno nuevo
            if (!isset($contador) || $contador == 0) {

                $_SESSION['carrito'][$_SESSION['identity']->id_usuario][] = array(
                    "producto_id" => $producto_seleccionado->id_producto,
                    "nombre" =>  $producto_seleccionado->nombre,
                    "cantidad" => 1,
                    "precio" => $producto_seleccionado->precio
                );
            }
            header('Location: ' . url . 'producto/welcome');

            // Si es admin
        } else if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            header('Location: ' . url . 'index/index');

            // Público
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    public static function delete()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            // Quita todos los productos del usuario iniciado sesión si existe
            if (isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {
                // Bucle que recorre todos los contenidos del carrito
                foreach ($_SESSION['carrito'][$_SESSION['identity']->id_usuario] as $indice => $elemento) {
                    // Si el id cogido es igual al producto del id a eliminar, entonces
                    // quitará ese elemento en concreto del carro
                    if ($_GET['id'] == ($elemento['producto_id'])) {
                        unset($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]);
                    }
                }
            }
        }
        header('Location: ' . url . 'carrito/index');
    }

    public static function deleteAll()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            // Quita todos los productos del usuario iniciado sesión si existe
            if (isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {
                unset($_SESSION['carrito'][$_SESSION['identity']->id_usuario]);
            }
        }
        header('Location: ' . url . 'carrito/index');
    }

    public static function show()
    {
        $producto = new Producto();
        $genre = new Genre();

        // Solo entra si es cliente
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            // Solo entra si existe
            if (isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {
                /**
                 * Comprueba si existe el elemento en el carrito
                 */
                foreach ($_SESSION['carrito'][$_SESSION['identity']->id_usuario] as $indice => $elemento) {
                    $producto->setId_producto($elemento['producto_id']);
                    $comprobador = $producto->findById();

                    // Ver si existe id en productos y eliminar si no
                    // No encuentra el producto
                    if ($comprobador == null) {
                        unset($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]);
                    }
                }
            }

            // Asegura de que en el caso de que el carrito del usuario iniciado no exista,
            // entonces se crea y le asigna un valor por defecto (en este caso es null)
            if (!isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {
                $_SESSION['carrito'][$_SESSION['identity']->id_usuario] = null;
            }

            // Lanza vista de carrito
            echo $GLOBALS['twig']->render(
                'carrito/index.twig',
                [
                    'genre' => $genre->findAll(),
                    'carrito' => $_SESSION['carrito'][$_SESSION['identity']->id_usuario],
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si es admin
        } else if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            header('Location: ' . url . 'index/index');

            // Público
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }


    public static function moreCant()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {

            // Añade más cantidad a un producto del carrito si existe
            if (isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {

                // Bucle que recorre todos los contenidos del carrito
                foreach ($_SESSION['carrito'][$_SESSION['identity']->id_usuario] as $indice => $elemento) {
                    // Aumenta cantidad si es el elemento correspondiente
                    if ($_GET['id'] == ($elemento['producto_id'])) {
                        $_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['cantidad']++;
                    }
                }
            }
        }
        header('Location: ' . url . 'carrito/index');
    }


    public static function lessCant()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {

            // Quita todos los productos del usuario iniciado sesión si existe
            if (isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario])) {
                
                // Bucle que recorre todos los contenidos del carrito
                foreach ($_SESSION['carrito'][$_SESSION['identity']->id_usuario] as $indice => $elemento) {
                    // Disminuye cantidad si es el elemento correspondiente
                    if ($_GET['id'] == ($elemento['producto_id'])) {
                        $_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['cantidad']--;
                    }

                    // Si hay 0 en cantidad, elimina del carro
                    if($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['cantidad'] == 0){
                        unset($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]);
                    }
                }
            }
        }
        header('Location: ' . url . 'carrito/index');
    }
}
