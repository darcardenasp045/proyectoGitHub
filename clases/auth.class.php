<?php

require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class auth extends conexion{
    public function login($json){
        $_respuestas = new respuesta;
        $datos = json_decode($json, true);
        if(!isset($datos['usuario']) || !isset($datos['password'])){
            return $_respuestas->error_400();
        }else{
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $datos = $this->obtenerDatosUsuario($usuario);
            if($datos){
                
            }else{
                return $_respuestas->error_200("El usuario $usuario no existe");
            }
        }
    }
    private function obtenerDatosUsuario($correo){
        $query = "SELECT UsuarioId,Password,Estado FROM Usuarios WHERE Usuario = '$correo'";
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]['UsuarioId'])){
            return $datos;
        }else{
            return 0;        
        }
    }

}
