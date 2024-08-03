<?php

use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    protected $token;

    protected function setUp(): void
    {
        $this->token = $this->getMockBuilder(token::class)
            ->setMethods(['nonQuery'])
            ->getMock();
    }

    public function testActualizarTokensWithUpdates()
    {
        // Arrange
        $this->token->method('nonQuery')->willReturn(5);
        
        // Act
        $result = $this->token->actualizarTokens('2024-08-01');

        // Assert
        $this->assertEquals(5, $result);
    }

    public function testActualizarTokensWithoutUpdates()
    {
        // Arrange
        $this->token->method('nonQuery')->willReturn(0);
        
        // Act
        $result = $this->token->actualizarTokens('2024-08-01');

        // Assert
        $this->assertEquals(0, $result);
    }

    public function testCrearTxt()
    {
        // Arrange
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');

        // Act
        $this->token->crearTxt($tempFile);

        // Assert
        $this->assertFileExists($tempFile);
        $this->assertStringEqualsFile($tempFile, "--- Registros del CRON JOB --------- \n");

        // Cleanup
        unlink($tempFile);
    }

    public function testEscribirEntradaWhenFileDoesNotExist()
    {
        // Arrange
        $mockToken = $this->getMockBuilder(token::class)
            ->setMethods(['crearTxt', 'escribirTxt'])
            ->getMock();

        $mockToken->expects($this->once())->method('crearTxt');
        $mockToken->expects($this->once())->method('escribirTxt');

        // Act
        $mockToken->escribirEntrada(5);
    }

    public function testEscribirEntradaWhenFileExists()
    {
        // Arrange
        $mockToken = $this->getMockBuilder(token::class)
            ->setMethods(['escribirTxt'])
            ->getMock();

        $mockToken->expects($this->once())->method('escribirTxt');

        // Act
        $mockToken->escribirEntrada(5);
    }

    public function testEscribirTxt()
    {
        // Arrange
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        $date = date("Y-m-d H:i");
        $expectedText = "Se modificaron 5 registro(s) el dia [$date] \n";

        // Act
        $this->token->escribirTxt($tempFile, 5);

        // Assert
        $this->assertStringEqualsFile($tempFile, $expectedText);

        // Cleanup
        unlink($tempFile);
    }
}
