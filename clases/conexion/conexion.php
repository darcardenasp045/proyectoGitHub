<?php
//creamos la clase para la conexion de la basse de datos
class conexion{
    //creamos las variables que nos van a servir para instanciar la conexion
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;
    //creamos una funcion que es la que nos sirve para recorrer los datos de la conexion y asignar sus valores a las variables
    function __construct(){
        $listaDatos = $this->datosConexion();
        foreach($listaDatos as $key => $value){
            $this->server = $value["server"];
            $this->user = $value["user"];
            $this->password = $value["password"];
            $this->database = $value["database"];
            $this->port = $value["port"];
        
        }
        //creamos la conexion
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        //validamos si la conexion es correcta
        if($this->conexion->connect_errno){
            echo "algo va mal con la conexion";
            die();
        }

    }
    //creamos una funcion que nos va a retornar la conexion
    private function datosConexion(){
        //obtenemos la direccion del archivo
        $direccion = dirname(__FILE__);
        //obtenemos el contenido del archivo
        $jsondata = file_get_contents($direccion . "/" . "config");
        //retornamos el contenido del archivo
        return json_decode($jsondata, true);

    }
    //creamos una funcion para convertir los datos a utf8
    private function convertirUTF8($array){
        array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }
    //creamos una funcion para obtener los datos de la base de datos ya parseados a utf8
    public function obtenerDatos($sqlString){
        $results = $this->conexion->query($sqlString);
        $resultArray = array();
        foreach($results as $key){
            $resultArray[] = $key;
        }
        return $this->convertirUTF8($resultArray);
    }
    //creamos una funcion donde nos devuelve el numero de registros que se guardaron en la base de datos
    public function nonQuery($sqlString){
        $results = $this->conexion->query($sqlString);
        return $this->conexion->affected_rows;
    }

    public function nonQueryId($sqlString){
        $results = $this->conexion->query($sqlString);
        $filas = $this->conexion->affected_rows;
        if($filas >= 1){
            return $this->conexion->insert_id;
        }else{
            return 0;
        }
    }


} 

