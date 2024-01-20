<?php

namespace Tests\Unit;

use App\Contracts\DatabaseConnectionInterface;
use App\Database\MysqliConnection;
use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;
use App\Helpers\Config;
use mysqli;
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

    public function testItCanConnectToDatabaseWithMysqliApi()
    {
        $credentials = $this->getCredentials('pdo');
        $handler = (new MysqliConnection($credentials))->connect();
        self::assertInstanceOf(DatabaseConnectionInterface::class, $handler);
        return $handler;
    }

    /** @depends testItCanConnectToDatabaseWithMysqliApi */
    public function testItIsAValidMysqliConnection(DatabaseConnectionInterface $handler)
    {
        self::assertInstanceOf(mysqli::class, $handler->getConnection());
    }

    private function getCredentials(string $connectionType)
    {
        return array_merge(
            Config::get('database', $connectionType),
            ['db_name' => 'bug_reporter_testing']
        );
    }
}