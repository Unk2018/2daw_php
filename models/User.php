<?php
require 'config/Database.php';
require 'models/Model.php';
class User implements Model
{
    private $id_usuario;
    private $nombre;
    private $email;
    private $id_rol;
    private $password;

    // Class constructor
    public function __construct()
    {
    }

    function getId_usuario()
    {
        return $this->id_usuario;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getId_rol()
    {
        return $this->id_rol;
    }

    function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, ['cont' => 4]);
    }

    function setId_rol($id_rol)
    {
        $this->id_rol = $id_rol;
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM usuario");
        return $findAll;
    }

    // Me devuelve el elemento filtrado por id
    public function findById()
    {
        $db = Database::conectar();
        $findById = $db->query("SELECT * FROM usuario WHERE id_usuario = " . $this->id_usuario);
        return $findById;
    }

    // Insertar en la base de datos
    public function save()
    {
        $db = Database::conectar();
        // En las dobles comillas, se puede poner lo del $this sin los  ' . ' ya que te lo cogen
        // En las comillas simples no te lo coge
        $save = $db->query("INSERT INTO usuario (nombre, email, password, id_rol) 
        VALUES ('$this->nombre', '$this->apellidos', '$this->email', '$this->password', '$this->id_rol')");
        return $save;
    }

    // Actualizar en la base de datos filtrando por id
    public function update()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE usuario SET nombre='$this->nombre', email='$this->email', password='$this->password', id_rol='$this->id_rol'");
        return $update;
    }

    // Eliminar en la base de datos filtrando por id
    public function delete()
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM usuario WHERE id_usuario=$this->id_usuario");
        return $delete;
    }
}
