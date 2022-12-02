<?php
class Database
{
    public static function conectar(){
        //mysql('localhost', usuario, password, base_de_datos)
        $conexion = "";

        try {
            $conexion = new mysqli("localhost:3306", "root", "1234", "tienda_dwes");
            $conexion -> query("SET NAMES 'utf8'");
        } catch (\Throwable $th) {
            echo $th;
        }
        return $conexion;
    }
}

?>