<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../token.class.php';  // Ajusta la ruta según sea necesario

class TokenTest extends TestCase
{
    protected $token;
    protected $conexionMock;

    protected function setUp(): void
    {
        // Crear un mock para la conexión
        $this->conexionMock = $this->createMock(conexion::class);

        // Instanciar el objeto Token con el mock de conexión
        $this->token = new token();
        $this->token->setConexion($this->conexionMock); // Asegúrate de que puedas establecer la conexión mockeada
    }

    public function testActualizarTokensSuccess()
    {
        $fecha = '2024-01-01';
        $query = "update usuarios_token set Estado = 'Inactivo' WHERE  Fecha < '$fecha'";
        $expectedRecords = 10;

        $this->conexionMock->method('nonQuery')
                           ->with($query)
                           ->willReturn($expectedRecords);

        $this->token->expects($this->once())
                    ->method('escribirEntrada')
                    ->with($expectedRecords);

        $result = $this->token->actualizarTokens($fecha);
        $this->assertEquals($expectedRecords, $result);
    }

    public function testActualizarTokensFailure()
    {
        $fecha = '2024-01-01';
        $query = "update usuarios_token set Estado = 'Inactivo' WHERE  Fecha < '$fecha'";

        $this->conexionMock->method('nonQuery')
                           ->with($query)
                           ->willReturn(0);

        $result = $this->token->actualizarTokens($fecha);
        $this->assertEquals(0, $result);
    }

    public function testCrearTxt()
    {
        $direccion = 'test.txt';

        // Usar un archivo temporal para evitar la creación de archivos innecesarios
        $this->expectOutputRegex('/error al crear el archivo de registros/');
        $this->token->crearTxt($direccion);

        // Verificar que el archivo se creó correctamente
        $this->assertFileExists($direccion);
        unlink($direccion); // Limpiar el archivo temporal
    }

    public function testEscribirEntrada()
    {
        $registros = 5;
        $direccion = 'test.txt';

        // Crear un archivo temporal
        $this->token->crearTxt($direccion);

        $this->token->escribirEntrada($registros);

        // Verificar que el archivo contiene la entrada esperada
        $expectedText = "Se modificaron $registros registro(s) el dia [";
        $content = file_get_contents($direccion);
        $this->assertStringContainsString($expectedText, $content);

        // Limpiar el archivo temporal
        unlink($direccion);
    }

    public function testEscribirTxt()
    {
        $direccion = 'test.txt';
        $registros = 3;

        $this->token->escribirTxt($direccion, $registros);

        // Verificar que el archivo contiene la entrada esperada
        $expectedText = "Se modificaron $registros registro(s) el dia [";
        $content = file_get_contents($direccion);
        $this->assertStringContainsString($expectedText, $content);

        // Limpiar el archivo temporal
        unlink($direccion);
    }
}

?>
