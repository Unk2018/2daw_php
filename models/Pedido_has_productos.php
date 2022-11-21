<?php
class Pedido_has_productos implements Model
{
    private $pedido;
    private $producto;
    private $unidades;
    private $precio;

    /**
     * Class constructor.
     */
    public function __construct()
    {
    }

    function getPedido()
    {
        return $this->pedido;
    }

    function getProducto()
    {
        return $this->producto;
    }

    function getUnidades()
    {
        return $this->unidades;
    }

    function getPrecio()
    {
        return $this->precio;
    }

    function setPedido($pedido)
    {
        $this->pedido = $pedido;
    }

    function setProducto($producto)
    {
        $this->producto = $producto;
    }

    function setUnidades($unidades)
    {
        $this->unidades = $unidades;
    }

    function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM pedido_has_productos;");
        return $findAll;
    }

    public function findById()
    {
        $db = Database::conectar();
        $sql = "SELECT * FROM pedido_has_productos WHERE id_pedido=$this->pedido;";
        return $db->query($sql);
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        $save = $db->query("INSERT INTO pedido_has_productos (id_pedido, id_producto, unidades, precio) VALUES ('$this->pedido', '$this->producto', $this->unidades, $this->precio)");
    }

    // Actualizar en la base de datos filtrando por id
    public function update()
    {
    }

    // Eliminar en la base de datos filtrando por id
    public function delete()
    {
    }
}

?>