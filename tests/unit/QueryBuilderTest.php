<?php

namespace Tests\Unit;

use App\Database\MySQLiConnection;
use App\Database\MySQLiQueryBuilder;
use App\Database\PDOConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;
use App\Helpers\DbQueryBuilderFactory;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class QueryBuilderTest extends TestCase
{
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;

    public function setUp(): void
    {
        $this->queryBuilder = DbQueryBuilderFactory::make(
            'database', 'pdo', ['db_name' => 'bug_reporter_testing']
        );

        $this->queryBuilder->beginTransaction();
        parent::setUp();
    }

    public function insertData()
    {
        $data = ['report_type' => 'ReportType 1', 
        'message' => 'Testing Create Records',
        'link' => 'http://localhost',
        'email' => 'maik@teste.com',
        'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->queryBuilder->table('reports')->create($data);
    }

    public function testItCanCreateRecords()
    {
        $id = $this->insertData();
        self::assertNotNull($id);
    }

    public function testItCanPerformRawQuery()
    {
        $result = $this->queryBuilder->raw("SELECT * FROM reports;")->get();
        self::assertNotNull($result);
    }

    public function testItCanPerformSelectQuery()
    {
        $id = $this->insertData();
        $result = $this->queryBuilder
                    ->table('reports')
                    ->select('*')
                    ->where('id', $id)
                    ->runQuery()
                    ->first();

        self::assertNotNull($result);
        self::assertSame((int) $id, $result->id);
    }

    public function testItCanPerformSelectQueryWithMultipleWhereClause()
    {
        $id = $this->insertData();
        $result = $this->queryBuilder
                    ->table('reports')
                    ->select('*')
                    ->where('id', $id)
                    ->where('report_type', 'ReportType 1')
                    ->runQuery()
                    ->first();
        
        self::assertNotNull($result);
        self::assertSame((int) $id, $result->id);
        self::assertSame('ReportType 1', $result->report_type);
    }

    public function testItCanFindById()
    {
        $id = $this->insertData();
        $result = $this->queryBuilder->table('reports')->select('*')->findById($id);

        self::assertNotNull($result);
        self::assertSame((int) $id, $result->id);
        self::assertSame('ReportType 1', $result->report_type);
    }

    public function testItCanFindOneByGivenValue()
    {
        $id = $this->insertData();
        $result = $this->queryBuilder->table('reports')->select('*')->findOneBy('report_type', 'ReportType 1');
        self::assertNotNull($result);
        self::assertSame((int) $id, $result->id);
        self::assertSame('ReportType 1', $result->report_type);
    }

    public function testItCanUpdateGivenRecord()
    {
        $id = $this->insertData();
        $count = $this->queryBuilder->table('reports')->update([
            'report_type' => 'Report Type 1 Updated'
        ])->where('id', $id)->runQuery()->affected();
        self::assertEquals(1, $count);

        $result = $this->queryBuilder->select('*')->findOneBy('report_type', 'Report Type 1 Updated');
        self::assertNotNull($result);
        self::assertSame((int) $id, $result->id);
        self::assertSame('Report Type 1 Updated', $result->report_type);
        
    }

    public function testItCanDeleteGivenId()
    {
        $id = $this->insertData();
        $count = $this->queryBuilder->table('reports')->delete()
                ->where('id', $id)->runQuery()->affected();

        $result = $this->queryBuilder->select('*')->findById($id);
        self::assertNull($result);
    }

    public function tearDown(): void
    {
        $this->queryBuilder->rollback();
        parent::tearDown();
    }
}