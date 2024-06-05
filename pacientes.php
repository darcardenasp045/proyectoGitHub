<?php

require_once 'clases/respuestas.class.php';
require_once 'clases/pacientes.class.php';

$_respuestas = new respuesta;
$_pacientes = new pacientes;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $ListaPacientes = $_pacientes->listaPacientes($pagina);
        
        echo json_encode($ListaPacientes);
    }else if(isset($_GET['id'])){
        $pacienteId = $_GET['id'];
        $datosPaciente = $_pacientes->obtenerPaciente($pacienteId);
        echo json_encode($datosPaciente);
    }
    
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo 'hola post';
}else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    echo 'hola put';
}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    echo 'hola delete';
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
