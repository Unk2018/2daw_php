<?php
require 'models/Model.php';
require 'config/Database.php';

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
        $this->password = $password;
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
        $findById = $db->query("SELECT * FROM usuario WHERE id_usuario =$this->id_usuario");
        return $findById->fetch_object();
    }

    // Insertar en la base de datos
    public function save()
    {
        $save = "";
        $db = Database::conectar();
        // En las dobles comillas, se puede poner lo del $this sin los  ' . ' ya que te lo cogen
        // En las comillas simples no te lo coge
        // Mira si hay datos antes de introducirlo a la base de datos
        if ($this->password != null && $this->email != null && $this->nombre != null && $this->id_rol != null) {
            $save = $db->query("INSERT INTO usuario (nombre, email, id_rol, password) 
            VALUES ('$this->nombre', '$this->email', '$this->id_rol', '$this->password')");
        }
        return $save;
    }

    // Actualizar en la base de datos filtrando por id
    public function update()
    {
        $update = "";
        $db = Database::conectar();
        // Mira que los datos relevantes no estén vacíos antes de actualizar los datos
        if ($this->password != null && $this->email != null) {
            $update = $db->query("UPDATE usuario SET nombre='$this->nombre', email='$this->email', id_rol='$this->id_rol', password='$this->password' WHERE id_usuario='$this->id_usuario'");
        } else {
            $update = $db->query("UPDATE usuario SET nombre='$this->nombre', email='$this->email', id_rol='$this->id_rol' WHERE id_usuario='$this->id_usuario'");
        }
        return $update;
    }

    // Eliminar en la base de datos filtrando por id
    public function delete()
    {
        $db = Database::conectar();
        $delete = $db->query("DELETE FROM usuario WHERE id_usuario=$this->id_usuario");
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
        
        if ($verify) {
            if($this->isAdmin($user->id_usuario)){
                $_SESSION['admin'] = true;
            }
            // Password coincide y debe hacer login
            return $user;
        } else {
            return false;
        }
    }

    public static function isAdmin($id_usuario){
        $db = Database::conectar();
        $tipo = $db->query("SELECT id_rol FROM usuario WHERE id_usuario = $id_usuario") ->fetch_object();
        
        if($tipo->id_rol == 1){
            return true;
        } else {
            return false;
        }
    }
}

?>