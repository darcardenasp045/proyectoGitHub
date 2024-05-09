<?php
//hacermos el require para la li
require_once "clases/conexion/conexion.php";

$conexion = new conexion();

// creamos la consulta
// $query = "SELECT * FROM pacientes";
//print_r($conexion->obtenerDatos($query));

///////////////////////////////////////////////////////////////

//creamos el script para la insercion de un registro solo con el dni
// $query = "INSERT INTO pacientes(dni) VALUES('12345678')";
// print_r($conexion->nonQuery($query));

//////////////////////////////////////////////////////////////

//creamos el script para que nos devuleva la posicion en la que se guardo el registro
// $query = "INSERT INTO pacientes(dni) VALUES('12345678')";
// print_r($conexion->nonQueryId($query));