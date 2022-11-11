<?php
require 'config/Database.php';
require 'models/Model.php';

class Tienda implements Model
{
    private $id_tienda;
    private $id_producto;
    private $cantidad;

    // Class constructor
    public function __construct()
    {
    }

    function getId_tienda()
    {
        return $this->id_tienda;
    }

    function getId_producto()
    {
        return $this->id_producto;
    }

    function getCantidad()
    {
        return $this->cantidad;
    }

    function setId_tienda($id_tienda)
    {
        $this->id_tienda = $id_tienda;
    }

    function setId_producto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM tienda");
        return $findAll;
    }

    // Me devuelve el elemento filtrado por id
    public function findById($id_tienda)
    {
        $db = Database::conectar();
        $findById = $db->query("SELECT * FROM tienda WHERE id_tienda = " . $this->id_tienda);
        return $findById;
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        // En las dobles comillas, se puede poner lo del $this sin los  ' . ' ya que te lo cogen
        // En las comillas simples no te lo coge
        $save = $db->query("INSERT INTO tienda (id_producto, cantidad) 
        VALUES ('$this->id_producto', '$this->cantidad')");
        return $save;
    }

    // Actualizar en la base de datos filtrando por id
    public function update()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE tienda SET id_producto='$this->id_producto', cantidad='$this->cantidad'");
        return $update;
    }

    // Eliminar en la base de datos filtrando por id
    public function delete($id_tienda)
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM tienda WHERE id_tienda=$this->id_tienda");
        return $delete;
    }
}
