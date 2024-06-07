<?php

require_once "conexion/conexion.php";
require_once "respuestas.class.php";

class auth extends conexion{
    // creamos la funcion para el login de los usuarios    
    public function login($json){
        // instanciamos la clase respuestas
        $_respuestas = new respuestas;
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
                    if($datos[0]['Estado'] == "Activo"){
                        $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                        if($verificar){
                            $result = $_respuestas->response;
                            $result['result'] = array(
                                "token" => $verificar
                            );
                            return $result;

                        }else{
                            return $_respuestas->error_500("
                            No hemos podido iniciar sesion, por favor intente nuevamente");

                        }
                        
                    }else{
                        // si el usuario esta inactivo retornamos un error
                        return $_respuestas->error_200("El usuario esta inactivo");

                    }
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
        $query = "SELECT UsuarioId,Password,Estado FROM usuarios WHERE Usuario = '$correo'";
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

    private function insertarToken($UsuarioId){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $date = date("Y-m-d H:i");
        $estado = "Activo";
        $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha) VALUES ('$UsuarioId','$token','$estado','$date')"; 
        $verifica = parent::nonQuery($query);
        if($verifica){
            return $token;
        }else{
            return 0;
        }   
    }

}
