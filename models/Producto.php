<?php
require 'config/Database.php';
require 'models/Model.php';

class Producto implements Model
{
    private $id_producto;
    private $nombre;
    private $f_creado;
    private $id_genre;

    // Class constructor
    public function __construct()
    {
    }

    function getId_producto()
    {
        return $this->id_producto;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getf_creado()
    {
        return $this->f_creado;
    }

    function getId_genre()
    {
        return $this->id_genre;
    }

    function setId_producto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function setf_creado($f_creado)
    {
        $this->f_creado = $f_creado;
    }

    function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM producto");
        return $findAll;
    }

    // Me devuelve el elemento filtrado por id
    public function findById()
    {
        $db = Database::conectar();
        $findById = $db->query("SELECT * FROM producto WHERE id_producto = $this->id_producto");
        return $findById;
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        // En las dobles comillas, se puede poner lo del $this sin los  ' . ' ya que te lo cogen
        // En las comillas simples no te lo coge
        $save = $db->query("INSERT INTO producto (nombre, f_creado, id_genre, password) 
        VALUES ('$this->nombre', '$this->f_creado', '$this->id_genre', '$this->password')");
        return $save;
    }

    // Actualizar en la base de datos filtrando por id
    public function update()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE producto SET nombre='$this->nombre', f_creado='$this->f_creado', id_genre='$this->id_genre', password='$this->password'");
        return $update;
    }

    // Eliminar en la base de datos filtrando por id
    public function delete()
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM producto WHERE id_producto=$this->id_producto");
        return $delete;
    }
}
