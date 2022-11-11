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
        $findById = $db->query("SELECT * FROM usuario WHERE id_usuario = " .$id_usuario);
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
        $update = $db->query("UPDATE usuario SET nombre='$this->nombre', email='$this->email', id_rol='$this->id_rol', password='$this->password' WHERE id_usuario=' . $this->id_usuario'");
        var_dump($update);
        exit();
        return $update;
    }

    // Eliminar en la base de datos filtrando por id
    public function delete($id_usuario)
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM usuario WHERE id_usuario=$id_usuario");
        return $delete;
    }

    /* Comprueba los datos introducido. En caso correcto, devuelve usuario. Si no, devuelve false */
    public function login()
    {
        $db = Database::conectar();

        // Mete a una variable usuario el resultado de la query
        $user = $db->query("SELECT * FROM usuario WHERE email = '$this->email'");

        // Si el usuario existe y solo hay 1, entonces verificará la password
        if ($user && $user->num_rows == 1) {
            /* Método fetch_object() me devuelve los valores recogidos de mi base de datos en un 
            formato objeto */
            $user = $user->fetch_object();

            /* Verifica un string con otro encriptado. En este caso se comprueba la password
            introducida con la de la base de datos. Devuelve un booleano */
            $verify = password_verify($this->password, $user->password);
        }

        var_dump($this->password);
        var_dump("<br/>");
        var_dump("<br/>");
        var_dump($user->password);
        var_dump("<br/>");
        var_dump("<br/>");
        var_dump(password_hash($this->password, PASSWORD_BCRYPT, ['cont' => 4]));
        var_dump("<br/>");
        var_dump("<br/>");
        var_dump(password_verify(password_hash($this->password, PASSWORD_BCRYPT, ['cont' => 4]), password_hash($this->password, PASSWORD_BCRYPT, ['cont' => 4])));
        
        var_dump($verify);
        exit();
        if ($verify) {
            // Password coincide y debe hacer login
            return $user;
        } else {
            return false;
        }
    }
}
