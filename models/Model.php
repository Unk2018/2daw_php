<?php
// Interfaz de mis modelos 
interface Model
{
    // Me va a devolver todos los elementos
    public function findAll();

    // Me devuelve el elemento filtrado por id
    public function findById($id);

    // Insertar en la base de datos
    public function save();

    // Actualizar en la base de datos filtrando por id
    public function update();

    // Eliminar en la base de datos filtrando por id
    public function delete($id);
}

?>