<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

//Esta clase se encarga de manejar los pacientes
//Extiende de la clase conexion
class pacientes extends conexion{
    private $table = "pacientes";
    //esta funcion se encarga de mostrar los pacientes de la base de datos

    public function listaPacientes($pagina = 1){
        $inicio = 0;
        $cantidad = 100;
        //validamos la cantidad de registros que se van a mostrar por hoja
        if($pagina>1){
            //aqui mostramos los registros que se van a mostrar por pagina de 100 en 100
            $inicio = ($cantidad * ($pagina-1))+1;
            $cantidad = $cantidad * $pagina;

        }
        //esta query es para obtener los datos de la base de datos
        $query = "SELECT PacienteId,DNI,Nombre,Telefono,Correo FROM " . 
        $this->table . " LIMIT $inicio, $cantidad";
        //obtenemos los datos de la base de datos
        $datos = parent::obtenerDatos($query);
        //retornamos los datos
        return ($datos);

        //la url que usamos es esta 
        //localhost/Proyectos/proyectoGitHub/pacientes?page=1

        
    }
    
    //esta funcion se encarga de obtener un paciente en especifico
    public function obtenerPaciente($id){
        $query = "SELECT * FROM " . 
        $this->table . " WHERE PacienteId = '$id'";
        return parent::obtenerDatos($query);

        //la url que usamos es esta
        //localhost/Proyectos/proyectoGitHub/pacientes?id=1
    }


}