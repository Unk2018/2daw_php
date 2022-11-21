<?php
require_once 'models/Pedido.php';
require_once 'models/Pedido_has_productos.php';

class PedidosController implements Controller
{
    public static function index()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {

            echo $GLOBALS['twig']->render(
                'pedido/index.twig',
                [
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        }
    }

    public static function show()
    {
        if (isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {

            echo $GLOBALS['twig']->render(
                'pedido/show.twig',
                [
                    'identity' => $_SESSION['identity'],
                    'url' => url
                ]
            );
        }
    }


    /**
     * Funcion que crea un pedido nuevo con los elementos del carrito
     */
    public static function save()
    {
        if (isset($_SESSION['carrito'][$_SESSION['identity']->id]) && isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
            /**
             * 1. Crear un nuevo pedido
             * 2. Recojo el id del pedido que acabo de crear para usarlo en mi tabla pedidos_has_productos
             * 3. Insertar todos los elementos del carrito en la tabla pedidos_has_producto. 
             * El unico elemento que me faltaba para realizar este punto 3 es el id del pedido, que lo tengo con la insercion anterior.
             * 4. Eliminar elementos del carrito
             */

            // Paso 1 y paso 2
            $pedido = new Pedido();
            $pedido->setUsuario($_SESSION['identity']->id);
            $pedido_id = $pedido->save();

            // Paso 3
            foreach ($_SESSION['carrito'][$_SESSION['identity']->id] as $indice => $elemento) {
                /**
                 * Creo tantas inserciones como sean necesarias en pedidos_has_productos con el producto_id del pedido anterior
                 */
                $pedidos_has_productos = new Pedido_has_productos();
                $pedidos_has_productos->setPedido($pedido_id);
                $pedidos_has_productos->setProducto($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['id_producto']);
                $pedidos_has_productos->setUnidades($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['cantidad']);
                $pedidos_has_productos->setPrecio($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['precio']);
                $pedidos_has_productos->save();

                /**
                 * Reduzco la cantidad de los productos seleccionados
                 */
                $producto = new Producto();
                $producto->setId_producto($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['id_producto']);
                $producto->setCantidad($_SESSION['carrito'][$_SESSION['identity']->id][$indice]['cantidad']);
                $producto->updateByCantidad();
            }


            // Paso 4: eliminar los productos del carrito y redireccionar al carrito ya vacio
            CarritoController::deleteAll();
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }


    /**
     * 
     */
    public static function delete()
    {
        if (isset($_SESSION['carrito']) && isset($_SESSION['identity']) && !isset($_SESSION['admin'])) {
        } else {
            header('Location: ' . url . 'controller=auth&action=login');
        }
    }

    public static function create(){}
    public static function edit(){}
    public static function update(){}
}

?>