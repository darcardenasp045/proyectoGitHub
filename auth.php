<?php

require_once "clases/auth.class.php";
require_once "clases/respuestas.class.php";

$_auth = new auth();

$_respuestas = new respuesta();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $postbody = file_get_contents("php://input");
    $datosArray = $_auth->login($postbody);
    print_r(json_encode($datosArray));

    

}else{
    echo "Metodo no permitido";
}
