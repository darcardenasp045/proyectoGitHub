<?php

use PHPUnit\Framework\TestCase;

// Importar la clase respuestas que queremos probar.
require_once __DIR__ . '/../respuestas.class.php'; 

class RespuestasTest extends TestCase
{
    protected $respuestas;

    protected function setUp(): void
    {
        $this->respuestas = new respuestas();
    }

    public function testError405()
    {
        // Ejecutar el método error_405
        $response = $this->respuestas->error_405();

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('405', $response['result']['error_id']);

        // Verificar el mensaje de error
        $this->assertEquals('Metodo no permitido', $response['result']['error_msg']);
    }

    public function testError200()
    {
        // Ejecutar el método error_200 con valor por defecto
        $response = $this->respuestas->error_200();

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('200', $response['result']['error_id']);

        // Verificar el mensaje de error por defecto
        $this->assertEquals('Datos incorrectos', $response['result']['error_msg']);
    }

    public function testError200WithCustomMessage()
    {
        $customMessage = "Custom error message";

        // Ejecutar el método error_200 con un mensaje personalizado
        $response = $this->respuestas->error_200($customMessage);

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('200', $response['result']['error_id']);

        // Verificar el mensaje de error personalizado
        $this->assertEquals($customMessage, $response['result']['error_msg']);
    }

    public function testError400()
    {
        // Ejecutar el método error_400
        $response = $this->respuestas->error_400();

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('400', $response['result']['error_id']);

        // Verificar el mensaje de error
        $this->assertEquals('Datos enviados incompletos o con formato incorrecto', $response['result']['error_msg']);
    }

    public function testError500()
    {
        // Ejecutar el método error_500 con valor por defecto
        $response = $this->respuestas->error_500();

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('500', $response['result']['error_id']);

        // Verificar el mensaje de error por defecto
        $this->assertEquals('Error interno del servidor', $response['result']['error_msg']);
    }

    public function testError500WithCustomMessage()
    {
        $customMessage = "Server error occurred";

        // Ejecutar el método error_500 con un mensaje personalizado
        $response = $this->respuestas->error_500($customMessage);

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('500', $response['result']['error_id']);

        // Verificar el mensaje de error personalizado
        $this->assertEquals($customMessage, $response['result']['error_msg']);
    }

    public function testError401()
    {
        // Ejecutar el método error_401 con valor por defecto
        $response = $this->respuestas->error_401();

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('401', $response['result']['error_id']);

        // Verificar el mensaje de error por defecto
        $this->assertEquals('No autorizado', $response['result']['error_msg']);
    }

    public function testError401WithCustomMessage()
    {
        $customMessage = "Unauthorized access";

        // Ejecutar el método error_401 con un mensaje personalizado
        $response = $this->respuestas->error_401($customMessage);

        // Verificar que el estado sea 'error'
        $this->assertEquals('error', $response['status']);

        // Verificar el código de error
        $this->assertEquals('401', $response['result']['error_id']);

        // Verificar el mensaje de error personalizado
        $this->assertEquals($customMessage, $response['result']['error_msg']);
    }
}
?>
