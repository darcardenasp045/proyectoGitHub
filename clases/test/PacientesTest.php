<?php

use PHPUnit\Framework\TestCase;

// Asegúrate de incluir el archivo de la clase pacientes de la clase
require_once __DIR__ . '/../pacientes.class.php';

class PacientesTest extends TestCase
{
    protected $pacientes;
    protected $conexionMock;
    protected $respuestasMock;

    protected function setUp(): void
    {
        // Crear un mock para la clase conexion
        $this->conexionMock = $this->createMock(conexion::class);

        // Crear un mock para la clase respuestas
        $this->respuestasMock = $this->createMock(respuestas::class);

        // Instanciar el objeto Pacientes con los mocks
        $this->pacientes = new pacientes();
        $this->pacientes->setConexion($this->conexionMock); // Asegúrate de poder establecer la conexión mockeada
    }

    public function testListaPacientes()
    {
        $pagina = 1;
        $query = "SELECT PacienteId,Nombre,DNI,Telefono,Correo FROM pacientes limit 0,100";
        $datos = [
            ['PacienteId' => 1, 'Nombre' => 'Juan', 'DNI' => '123456', 'Telefono' => '5551234', 'Correo' => 'juan@example.com']
        ];

        $this->conexionMock->method('obtenerDatos')
                           ->with($query)
                           ->willReturn($datos);

        $result = $this->pacientes->listaPacientes($pagina);
        $this->assertEquals($datos, $result);
    }

    public function testObtenerPaciente()
    {
        $id = 1;
        $query = "SELECT * FROM pacientes WHERE PacienteId = '$id'";
        $datos = ['PacienteId' => 1, 'Nombre' => 'Juan', 'DNI' => '123456', 'Telefono' => '5551234', 'Correo' => 'juan@example.com'];

        $this->conexionMock->method('obtenerDatos')
                           ->with($query)
                           ->willReturn($datos);

        $result = $this->pacientes->obtenerPaciente($id);
        $this->assertEquals($datos, $result);
    }

    public function testPostSuccess()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'nombre' => 'Juan',
            'dni' => '123456',
            'correo' => 'juan@example.com'
        ]);

        // Configurar el mock para buscarToken
        $this->pacientes->method('buscarToken')
                        ->willReturn(['TokenId' => 1, 'UsuarioId' => 1, 'Estado' => 'Activo']);

        // Configurar el mock para insertarPaciente
        $this->pacientes->method('insertarPaciente')
                        ->willReturn(1);

        // Configurar el mock para la respuesta de éxito
        $this->respuestasMock->response = [
            'status' => 'success',
            'result' => [
                'pacienteId' => 1
            ]
        ];
        $this->pacientes->method('response')
                        ->willReturn($this->respuestasMock->response);

        // Llamar al método post
        $result = $this->pacientes->post($json);
        $expected = [
            'status' => 'success',
            'result' => [
                'pacienteId' => 1
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testPostFailure()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'nombre' => 'Juan',
            'dni' => '123456',
            'correo' => 'juan@example.com'
        ]);

        // Configurar el mock para buscarToken
        $this->pacientes->method('buscarToken')
                        ->willReturn(false);

        // Configurar el mock para la respuesta de error
        $this->respuestasMock->response = [
            'status' => 'error',
            'result' => [
                'error_id' => '401',
                'error_msg' => 'El Token que envio es invalido o ha caducado'
            ]
        ];
        $this->pacientes->method('response')
                        ->willReturn($this->respuestasMock->response);

        // Llamar al método post
        $result = $this->pacientes->post($json);
        $expected = [
            'status' => 'error',
            'result' => [
                'error_id' => '401',
                'error_msg' => 'El Token que envio es invalido o ha caducado'
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testPutSuccess()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'pacienteId' => 1,
            'nombre' => 'Juan',
            'dni' => '123456',
            'correo' => 'juan@example.com'
        ]);

        // Configurar el mock para buscarToken
        $this->pacientes->method('buscarToken')
                        ->willReturn(['TokenId' => 1, 'UsuarioId' => 1, 'Estado' => 'Activo']);

        // Configurar el mock para modificarPaciente
        $this->pacientes->method('modificarPaciente')
                        ->willReturn(1);

        // Configurar el mock para la respuesta de éxito
        $this->respuestasMock->response = [
            'status' => 'success',
            'result' => [
                'pacienteId' => 1
            ]
        ];
        $this->pacientes->method('response')
                        ->willReturn($this->respuestasMock->response);

        // Llamar al método put
        $result = $this->pacientes->put($json);
        $expected = [
            'status' => 'success',
            'result' => [
                'pacienteId' => 1
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testPutFailure()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'pacienteId' => 1
        ]);

        // Configurar el mock para buscarToken
        $this->pacientes->method('buscarToken')
                        ->willReturn(false);

        // Configurar el mock para la respuesta de error
        $this->respuestasMock->response = [
            'status' => 'error',
            'result' => [
                'error_id' => '401',
                'error_msg' => 'El Token que envio es invalido o ha caducado'
            ]
        ];
        $this->pacientes->method('response')
                        ->willReturn($this->respuestasMock->response);

        // Llamar al método put
        $result = $this->pacientes->put($json);
        $expected = [
            'status' => 'error',
            'result' => [
                'error_id' => '401',
                'error_msg' => 'El Token que envio es invalido o ha caducado'
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testDeleteSuccess()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'pacienteId' => 1
        ]);

        // Configurar el mock para buscarToken
        $this->pacientes->method('buscarToken')
                        ->willReturn(['TokenId' => 1, 'UsuarioId' => 1, 'Estado' => 'Activo']);

        // Configurar el mock para eliminarPaciente
        $this->pacientes->method('eliminarPaciente')
                        ->willReturn(1);

        // Configurar el mock para la respuesta de éxito
        $this->respuestasMock->response = [
            'status' => 'success',
            'result' => [
                'pacienteId' => 1
            ]
        ];
        $this->pacientes->method('response')
                        ->willReturn($this->respuestasMock->response);

        // Llamar al método delete
        $result = $this->pacientes->delete($json);
        $expected = [
            'status' => 'success',
            'result' => [
                'pacienteId' => 1
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testDeleteFailure()
    {
        $json = json_encode([
            'token' => 'valid_token',
            'pacienteId' => 1
        ]);

        // Configurar el mock para buscarToken
        $this->pacientes->method('buscarToken')
                        ->willReturn(false);

        // Configurar el mock para la respuesta de error
        $this->respuestasMock->response = [
            'status' => 'error',
            'result' => [
                'error_id' => '401',
                'error_msg' => 'El Token que envio es invalido o ha caducado'
            ]
        ];
        $this->pacientes->method('response')
                        ->willReturn($this->respuestasMock->response);

        // Llamar al método delete
        $result = $this->pacientes->delete($json);
        $expected = [
            'status' => 'error',
            'result' => [
                'error_id' => '401',
                'error_msg' => 'El Token que envio es invalido o ha caducado'
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}
?>
