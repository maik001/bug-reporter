<?php

namespace Teste\Unit;

use App\Helpers\App;
use DateTime;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testItCanGetInstanceOfApplication()
    {
        self::assertInstanceOf(App::class, new App());
    }

    public function testItCanGetBasicApplicationDatasetFromAppClass()
    {
        $app = new App();

        // retorno deve ser verdadeiro
        self::assertTrue($app->isRunningFromConsole());

        // retorno deve ser o mesmo valor do argumento 1
        self::assertSame('test', $app->getEnviroment());

        // retorno não pode ser nulo
        self::assertNotNull($app->getLogPath());

        // retorno deve ser uma instância da classe Datetime
        self::assertInstanceOf(DateTime::class, $app->getServerTime());
    }
}