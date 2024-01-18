<?php

namespace Tests\Unit;

use App\Contracts\DatabaseConnectionInterface;
use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;
use App\Helpers\Config;
use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testItThrowsMissingArgumentExceptionWithWrongCredentialKeys()
    {
        self::expectException(MissingArgumentException::class);
        $credentials = [];
        $pdoHandler = (new PDOConnection($credentials))->connect();
    }

    public function testItCanConnectToDatabaseWithPdoApi()
    {
        $credentials = $this->getCredentials('pdo');
        $pdoHandler = (new PDOConnection($credentials))->connect();
        self::assertInstanceOf(DatabaseConnectionInterface::class, $pdoHandler);
        return $pdoHandler;
    }

    /** @depends testItCanConnectToDatabaseWithPdoApi */
    public function testItIsAValidPdoConnection(DatabaseConnectionInterface $handler)
    {
        self::assertInstanceOf(PDO::class, $handler->getConnection());
    }

    private function getCredentials(string $connectionType)
    {
        return array_merge(
            Config::get('database', $connectionType),
            ['db_name' => 'bug_reporter_testing']
        );
    }
}