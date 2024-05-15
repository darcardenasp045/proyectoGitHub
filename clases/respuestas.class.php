<?php

class respuesta{
    public $response =[
        'status' => "ok",
        "result" => array()
    ];

    public function error_405(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        $response = $this->response;
        return $response;
        
    }

    public function error_200($string = "Datos incorrectos"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => "$string"
        );
        $response = $this->response;
        return $response;
        
    }

    public function error_400(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviaddos incompletos o con formato incorrecto"
        );
        $response = $this->response;
        return $response;
        
    }
    public function error_500($string = "Error interno del servidor"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => "$string"
        );
        $response = $this->response;
        return $response;
        
    }
}