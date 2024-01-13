<?php

namespace Tests\Unit;

use App\Contracts\LoggerInterface;
use App\Exception\InvalidLogLevelArgumentException;
use App\Helpers\App;
use App\Logger\Logger;
use App\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    /** @var Logger $logger */
    private $logger;

    // função que é executada antes dos testes
    public function setUp(): void
    {
        $this->logger = new Logger();
        parent::setUp();
    }

    public function testItImplementsTheLoggerInterface()
    {
        // verifica se o objeto logger é uma instância da interface logger
        self::assertInstanceOf(LoggerInterface::class, new Logger);
    }

    public function testItCanCreateDifferentTypesOfLogLevels()
    {
        // executa os comandos de log
        $this->logger->info('Testing Info logs');
        $this->logger->error('Testing Error logs');
        $this->logger->log(LogLevel::ALERT, 'Testing Alert logs');

        // instancia a classe app para a criação do arquivo no caminho do log com o ambiente definido
        $app = new App;
        $fileName = sprintf("%s/%s-%s.log", $app->getLogPath(), $app->getEnviroment(), date("j.n.Y"));
        self::assertFileExists($fileName);
        
        // verifica se o conteúdo do arquivo de log gerado está de acordo com o esperado
        $contentOfLogFile = file_get_contents($fileName); 
        self::assertStringContainsString('Testing Info logs', $contentOfLogFile);
        self::assertStringContainsString('Testing Error logs', $contentOfLogFile);
        self::assertStringContainsString(LogLevel::ALERT, $contentOfLogFile);

        // exclui o arquivo criado, pois foi criado apenas para o teste e verifica se o arquivo foi excluído
        unlink($fileName);
        self::assertFileDoesNotExist($fileName);
    }

    public function testItThrowsInvalidLogLevelArgumentExceptionWhenGivenAWrongLogLevel()
    {
        self::expectException(InvalidLogLevelArgumentException::class);
        $this->logger->log('invalid', 'Testing Invalid log level');
    }
}