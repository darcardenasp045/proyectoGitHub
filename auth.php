<?php

require_once "clases/auth.class.php";
require_once "clases/respuestas.class.php";

$_auth = new auth();

$_respuestas = new respuestas();

//validamos que el metodo que se este utilizando sea POST

if($_SERVER['REQUEST_METHOD'] == "POST"){ 
    //recibimos los datos enviados 
    $postbody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_auth->login($postbody);
    //delvovemos una respuesta
    header('Content-Type: application/json');
    //si en la respuesta que nos devolvio el manejador existe un error lo mostramos
    if(isset($datosArray["result"]["error_id"])){
        //si existe un error le colocamos el codigo de error correspondiente
        $responseCode = $datosArray["result"]["error_id"];
        //colocamos el codigo de error
        http_response_code($responseCode);
    }else{
        //si no hay errores le colocamos el codigo 200 que es de OK
        http_response_code(200);
    }
    //mostramos la respuesta en formato json
    echo json_encode($datosArray);

    

}else{
    //si no es metodo POST mostramos un error
    header('Content-Type: application/json');
    //mostramos una respuesta de metodo no permitido
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
