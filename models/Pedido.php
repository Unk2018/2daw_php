<?php
class Pedido implements Model
{

    private $id_pedido;
    private $usuario;
    private $fecha;

    /**
     * Class constructor.
     */
    public function __construct()
    {
    }

    function getId_pedido()
    {
        return $this->id_pedido;
    }

    function getUsuario()
    {
        return $this->usuario;
    }

    function getFecha()
    {
        return $this->fecha;
    }

    function setId_pedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

    function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
    }

    // Busca por el id del pedido seleccionado
    public function findById()
    {
        $db = Database::conectar();
        $findById = $db->query("SELECT pedido.id_usuario, pedido.fecha, producto.nombre AS nombre_producto, pedido_has_productos.*
        FROM ((pedido
        INNER JOIN pedido_has_productos ON pedido.id_pedido = pedido_has_productos.id_pedido)
        INNER JOIN producto ON producto.id_producto = pedido_has_productos.id_producto)
        WHERE pedido.id_pedido=$this->id_pedido  AND pedido.id_usuario= $this->usuario;");
        return $findById;
    }

    // Me devuelve el elemento filtrado por usuario (todos los pedidod del usuario registrado)
    public function findByUser()
    {
        $db = Database::conectar();
        $findByUser = $db->query("SELECT pedido.fecha, pedido_has_productos.id_pedido, sum(pedido_has_productos.unidades * pedido_has_productos.precio) AS total
        FROM pedido
        INNER JOIN pedido_has_productos ON pedido.id_pedido = pedido_has_productos.id_pedido
        WHERE pedido.id_usuario= $this->usuario
        GROUP BY id_pedido;");
        return $findByUser;
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        $save = $db->query("INSERT INTO pedido (id_usuario, fecha) VALUES ('$this->usuario', CURDATE())");
        return mysqli_insert_id($db); // Te devuelve la id generada por la query
    }

    // Actualizar en la base de datos filtrando por id_pedido
    public function update()
    {
    }

    // Eliminar en la base de datos filtrando por id_pedido
    public function delete()
    {
    }
}

?>