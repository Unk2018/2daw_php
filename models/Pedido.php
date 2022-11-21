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

    public function findById()
    {
    }

    // Me devuelve el elemento filtrado por usuario
    public function findByUser()
    {
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        $save = $db->query("INSERT INTO pedido (id_usuario, fecha) VALUES ('$this->usuario', CURDATE())");
        return $db->insert_id_pedido;
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