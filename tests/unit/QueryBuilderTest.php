<?php

namespace Tests\Unit;

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Database\PDOConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;
use App\Helpers\DbQueryBuilderFactory;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;

    public function setUp(): void
    {
        $this->queryBuilder = DbQueryBuilderFactory::make(
                        'database', 'pdo', ['db_name' => 'bug_reporter_testing']
        );

        $this->queryBuilder->getConnection()->beginTransaction();
        parent::setUp();
    }

    public function testItCanCreateRecords()
    {
        $data = ['report_type' => 'ReportType 1', 
                'message' => 'Testing Create Records',
                'link' => 'http://localhost',
                'email' => 'maik@teste.com',
                'created_at' => date('Y-m-d H:i:s')
            ];

        $id = $this->queryBuilder->table('reports')->create($data);
        self::assertNotNull($id);
    }

    public function testItCanPerformRawQuery()
    {
        $result = $this->queryBuilder->raw("SELECT * FROM reports;");
        self::assertNotNull($result);
    }

    public function testItCanPerformSelectQuery()
    {
        $result = $this->queryBuilder
                    ->table('reports')
                    ->select('*')
                    ->where('id', 1)
                    ->first();


        self::assertNotNull($result);
        self::assertSame(1, (int) $result->id);
    }

    public function testItCanPerformSelectQueryWithMultipleWhereClause()
    {
        $result = $this->queryBuilder
                    ->table('reports')
                    ->select('*')
                    ->where('id', 1)
                    ->where('report_type', 'ReportType 1')
                    ->first();
        
        self::assertNotNull($result);
        self::assertSame(1, (int) $result->id);
        self::assertSame('ReportType 1', $result->report_type);
    }

    public function tearDown(): void
    {
        $this->queryBuilder->getConnection()->rollback();
        parent::tearDown();
    }
}