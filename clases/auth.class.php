<?php

require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class auth extends conexion{
    // creamos la funcion para el login de los usuarios    
    public function login($json){
        // instanciamos la clase respuestas
        $_respuestas = new respuesta;
        // convertimos el json a un array
        $datos = json_decode($json, true);
        // validamos que existan los datos
        if(!isset($datos['usuario']) || !isset($datos['password'])){
            // si no existen los datos retornamos un error
            return $_respuestas->error_400();
        }else{
            // si existen los datos los asignamos a una variable
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            // encriptamos el password con un metodo encriptar que esta en la clase conexion
            $password = parent::encriptar($password);
            // validamos que el usuario exista
            $datos = $this->obtenerDatosUsuario($usuario);
            // validamos que los datos no esten vacios
            if($datos){
                if($password == $datos[0]['Password']){
                    //aun no hay logica aqui
                }else{
                    // si el password es incorrecto retornamos un error
                    return $_respuestas->error_200("El password es invalido");
                }
                
            }else{
                // si el usuario no existe retornamos un error
                return $_respuestas->error_200("El usuario $usuario no existe");
            }
        }
    }
    // funcion para obtener los datos del usuario
    private function obtenerDatosUsuario($correo){
        // realizamos la consulta a la base de datos
        $query = "SELECT UsuarioId,Password,Estado FROM Usuarios WHERE Usuario = '$correo'";
        // retornamos los datos obtenidos
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]['UsuarioId'])){
            // si existen datos los retornamos 
            return $datos;
        }else{
            // si no existen datos retornamos un false
            return 0;        
        }
    }

}
