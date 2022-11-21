<?php
class Genre implements Model
{

    private $id_genre;
    private $nombre;

    /**
     * Class constructor.
     */
    public function __construct()
    {
    }

    function getId_genre()
    {
        return $this->id_genre;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM genre;");
        return $findAll;
    }

    // Me devuelve el elemento filtrado por id_genre
    public function findById()
    {
        $db = Database::conectar();
        return $db->query("SELECT * FROM genre WHERE id_genre=$this->id_genre")->fetch_object();
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        $save = $db->query("INSERT INTO genre (nombre) VALUES ('$this->nombre')");
    }

    // Actualizar en la base de datos filtrando por id_genre
    public function update()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE genre SET nombre='$this->nombre' WHERE id_genre=$this->id_genre");
    }

    // Eliminar en la base de datos filtrando por id_genre
    public function delete()
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM genre WHERE id_genre=$this->id_genre");
    }
}

?>