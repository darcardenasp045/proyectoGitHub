<?php

require_once "clases/auth.class.php";
require_once "clases/respuestas.class.php";

//$_auth = new auth();

$_respuestas = new respuesta();

if($_SERVER['REQUEST_METHOD'] == "POST"){

}else{
    echo "Metodo no permitido";
}
