<?php
require_once 'models/Pedido.php';
require_once 'models/Pedido_has_productos.php';

class PedidosController implements Controller
{
    public static function index()
    {
        // Si es cliente
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            $genre = new Genre();
            $pedido = new Pedido();
            $pedido->setUsuario($_SESSION['identity']->id_usuario);

            // Cargar todos los pedidos del usuario
            echo $GLOBALS['twig']->render(
                'pedido/index.twig',
                [
                    'genre' => $genre->findAll(),
                    'pedidos' => $pedido->findByUser(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si es admin
        } else if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            header('Location: ' . url . 'index/index');

            // Si es público
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }

    public static function show()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            $genre = new Genre();
            $pedido = new Pedido();
            $pedido->setId_pedido($_GET['id']);
            $pedido->setUsuario($_SESSION['identity']->id_usuario);

            echo $GLOBALS['twig']->render(
                'pedido/show.twig',
                [
                    'genre' => $genre->findAll(),
                    'pedido' => $pedido->findById(),
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );

            // Si es admin
        } else if (isset($_SESSION['identity']) && isset($_SESSION['admin'])) {
            header('Location: ' . url . 'index/index');

            // Si es público
        } else {
            header('Location: ' . url . 'auth/login');
        }
    }


    /**
     * Funcion que crea un pedido nuevo con los elementos del carrito
     */
    public static function save()
    {
        // Si existe carrito y es un cliente
        if (isset($_SESSION['carrito'][$_SESSION['identity']->id_usuario]) && isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            /**
             * 1. Crear un nuevo pedido
             * 2. Recojo el id del pedido que acabo de crear para usarlo en mi tabla pedidos_has_productos
             * 3. Insertar todos los elementos del carrito en la tabla pedidos_has_producto. 
             * El unico elemento que me faltaba para realizar este punto 3 es el id del pedido, que lo tengo con la insercion anterior.
             * 4. Eliminar elementos del carrito
             */

            // Paso 1 y paso 2
            $pedido = new Pedido();
            $pedido->setUsuario($_SESSION['identity']->id_usuario);
            $pedido_id = $pedido->save();

            // Paso 3
            foreach ($_SESSION['carrito'][$_SESSION['identity']->id_usuario] as $indice => $elemento) {
                /**
                 * Creo tantas inserciones como sean necesarias en pedidos_has_productos con el producto_id del pedido anterior
                 */
                $pedidos_has_productos = new Pedido_has_productos();
                $pedidos_has_productos->setPedido($pedido_id);
                $pedidos_has_productos->setProducto($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['producto_id']);
                $pedidos_has_productos->setUnidades($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['cantidad']);
                $pedidos_has_productos->setPrecio($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['precio']);
                $pedidos_has_productos->save();

                /**
                 * Reduzco la cantidad de los productos seleccionados
                 * Es decir, reduce el stock de la tienda ya que ya han sido comprados
                 */
                $producto = new Producto();
                $producto->setId_producto($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['producto_id']);
                $producto->setCantidad($_SESSION['carrito'][$_SESSION['identity']->id_usuario][$indice]['cantidad']);
                $producto->updateByCantidad();
            }


            // Paso 4: eliminar los productos del carrito y redireccionar al carrito ya vacio
            CarritoController::deleteAll();

            // Si no tiene carro o no está logueado, entonces te enviará al index donde decidirá
            // donde enviarte dependiendo de si iniciastes sesión o no
        } else {
            header('Location: ' . url . 'index/index');
        }
    }


    /**
     * 
     */
    public static function delete()
    {
        if (isset($_SESSION['carrito']) && isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
        } else {
            header('Location: ' . url . 'index/index');
        }
    }

    public static function create()
    {
    }
    public static function edit()
    {
    }
    public static function update()
    {
    }
}

?>