<?php

use PHPUnit\Framework\TestCase;

require_once 'pacientes.class.php'

class PacientesTest extends TestCase
{
    protected $pacientes;
    protected $conexionMock;
    protected $respuestasMock;

    protected function setUp(): void
    {
        $this->conexionMock = $this->createMock(conexion::class);
        $this->respuestasMock = $this->createMock(respuestas::class);

        // Instanciar el objeto Pacientes y pasar los mocks como dependencias
        $this->pacientes = $this->getMockBuilder(pacientes::class)
                                ->setConstructorArgs([$this->conexionMock])
                                ->setMethods(['buscarToken', 'insertarPaciente', 'modificarPaciente', 'eliminarPaciente'])
                                ->getMock();
    }

    public function testListaPacientes()
    {
        $query = "SELECT PacienteId,Nombre,DNI,Telefono,Correo FROM pacientes limit 0,100";
        $expectedData = [['PacienteId' => 1, 'Nombre' => 'John Doe', 'DNI' => '12345678', 'Telefono' => '123456789', 'Correo' => 'john@example.com']];
        
        $this->conexionMock->method('obtenerDatos')
                           ->with($query)
                           ->willReturn($expectedData);
        
        $result = $this->pacientes->listaPacientes();
        $this->assertEquals($expectedData, $result);
    }

    public function testObtenerPaciente()
    {
        $id = 1;
        $query = "SELECT * FROM pacientes WHERE PacienteId = '$id'";
        $expectedData = ['PacienteId' => 1, 'Nombre' => 'John Doe'];
        
        $this->conexionMock->method('obtenerDatos')
                           ->with($query)
                           ->willReturn($expectedData);
        
        $result = $this->pacientes->obtenerPaciente($id);
        $this->assertEquals($expectedData, $result);
    }

    public function testPostSuccess()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'nombre' => 'John Doe',
            'dni' => '12345678',
            'correo' => 'john@example.com'
        ]);

        $this->pacientes->method('buscarToken')
                         ->willReturn([['TokenId' => 1, 'UsuarioId' => 1, 'Estado' => 'Activo']]);
        $this->pacientes->method('insertarPaciente')
                         ->willReturn(1);

        $expectedResponse = [
            'status' => 200,
            'result' => ['pacienteId' => 1]
        ];

        $this->respuestasMock->method('response')
                             ->willReturn($expectedResponse);
        $this->pacientes->method('insertarPaciente')
                         ->willReturn(1);

        $this->pacientes->method('error_401')
                         ->willReturn($this->respuestasMock->error_401());

        $result = $this->pacientes->post($json);
        $this->assertEquals($expectedResponse, $result);
    }

    public function testPutSuccess()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'pacienteId' => 1,
            'nombre' => 'John Doe Updated',
            'dni' => '87654321'
        ]);

        $this->pacientes->method('buscarToken')
                         ->willReturn([['TokenId' => 1, 'UsuarioId' => 1, 'Estado' => 'Activo']]);
        $this->pacientes->method('modificarPaciente')
                         ->willReturn(1);

        $expectedResponse = [
            'status' => 200,
            'result' => ['pacienteId' => 1]
        ];

        $this->respuestasMock->method('response')
                             ->willReturn($expectedResponse);

        $this->pacientes->method('error_401')
                         ->willReturn($this->respuestasMock->error_401());

        $result = $this->pacientes->put($json);
        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteSuccess()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'pacienteId' => 1
        ]);

        $this->pacientes->method('buscarToken')
                         ->willReturn([['TokenId' => 1, 'UsuarioId' => 1, 'Estado' => 'Activo']]);
        $this->pacientes->method('eliminarPaciente')
                         ->willReturn(1);

        $expectedResponse = [
            'status' => 200,
            'result' => ['pacienteId' => 1]
        ];

        $this->respuestasMock->method('response')
                             ->willReturn($expectedResponse);

        $this->pacientes->method('error_401')
                         ->willReturn($this->respuestasMock->error_401());

        $result = $this->pacientes->delete($json);
        $this->assertEquals($expectedResponse, $result);
    }
}
