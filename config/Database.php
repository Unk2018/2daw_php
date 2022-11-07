<?php
class Database
{
    public static function conectar(){
        //mysql('localhost', usuario, password, base_de_datos)
        $conexion = new mysqli("localhost:3306", "root", "1234", "tienda_dwes");
        $conexion -> query("SET NAMES 'utf8'");

        return $conexion;
    }
}

?>