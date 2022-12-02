<?php
class Producto implements Model
{
    private $id_producto;
    private $id_genre;
    private $nombre;
    private $cantidad;
    private $precio;

    /**
     * Class constructor.
     */
    public function __construct()
    {
    }

    function getId_producto()
    {
        return $this->id_producto;
    }

    function getId_genre()
    {
        return $this->id_genre;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getCantidad()
    {
        return $this->cantidad;
    }

    function getPrecio()
    {
        return $this->precio;
    }

    function setId_producto($id_producto)
    {
        $this->id_producto = $id_producto;
    }

    function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM producto;");
        return $findAll;
    }

    // Me devuelve el elemento filtrado por id_producto
    public function findById()
    {
        $db = Database::conectar();
        return $db->query("SELECT * FROM producto WHERE id_producto=$this->id_producto")->fetch_object();
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        $save = $db->query("INSERT INTO producto (id_genre, nombre, cantidad, precio) VALUES ('$this->id_genre','$this->nombre', '$this->cantidad', '$this->precio')");
    }

    // Actualizar en la base de datos filtrando por id_producto
    public function update()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE producto SET id_genre='$this->id_genre', nombre='$this->nombre', cantidad='$this->cantidad', precio='$this->precio' WHERE id_producto=$this->id_producto");
    }

    // Actualizar en la base de datos filtrando por id_producto
    public function updateByCantidad()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE producto SET cantidad=cantidad-'$this->cantidad' WHERE id_producto=$this->id_producto");
    }

    // Eliminar en la base de datos filtrando por id_producto
    public function delete()
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM producto WHERE id_producto=$this->id_producto");
    }

    // Eliminar en la base de datos filtrando por género
    public function deleteByGenre()
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM producto WHERE id_genre=$this->id_genre");
    }

    public function findAllWithGenre()
    {
        $db = Database::conectar();
        $findWithGenre = $db->query("Select * from producto as p join genre as g where p.id_genre = g.id_genre;");
        return $findWithGenre;
    }

    public function filterByGenre()
    {
        $db = Database::conectar();
        $findWithGenre = $db->query("Select * from producto as p join genre as g 
        where p.id_genre = g.id_genre and g.id_genre = $this->id_genre;");
        return $findWithGenre;
    }
}
