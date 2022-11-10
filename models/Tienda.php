<?php
require 'config/Database.php';
require 'models/Model.php';

class Tienda implements Model
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

    function getId_rol()
    {
        return $this->id_rol;
    }

    function getPassword()
    {
        return $this->password;
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

    function setId_rol($id_rol)
    {
        $this->id_rol = $id_rol;
    }

    function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, ['cont' => 4]);
    }

    // Me va a devolver todos los elementos
    public function findAll()
    {
        $db = Database::conectar();
        $findAll = $db->query("SELECT * FROM usuario");
        return $findAll;
    }

    // Me devuelve el elemento filtrado por id
    public function findById($id_usuario)
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
        $save = $db->query("INSERT INTO usuario (nombre, email, id_rol, password) 
        VALUES ('$this->nombre', '$this->email', '$this->id_rol', '$this->password')");
        return $save;
    }

    // Actualizar en la base de datos filtrando por id
    public function update()
    {
        $db = Database::conectar();
        $update = $db->query("UPDATE usuario SET nombre='$this->nombre', email='$this->email', id_rol='$this->id_rol', password='$this->password'");
        return $update;
    }

    // Eliminar en la base de datos filtrando por id
    public function delete($id_usuario)
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM usuario WHERE id_usuario=$this->id_usuario");
        return $delete;
    }
}
