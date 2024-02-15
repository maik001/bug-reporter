<?php

namespace Tests\Functional;

use App\Database\QueryBuilder;
use App\Entities\BugReport;
use App\Helpers\DbQueryBuilderFactory;
use App\Helpers\HttpClient;
use App\Repositories\BugReportRepository;
use PHPUnit\Framework\TestCase;

class CrudTest extends TestCase
{
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;

    /** @var BugReportRepository $repository */
    private $repository;

    /** @var HttpClient $client */
    private $client;

    public function setUp(): void
    {
        $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_reporter_testing']);
        $this->queryBuilder->beginTransaction();
        $this->repository = new BugReportRepository($this->queryBuilder);
        $this->client =  new HttpClient();
        parent::setUp();
    }

    public function testItCanCreateReportUsingPostRequest()
    {
        $postData = $this->getPostData(['add' => true]);
        $response = $this->client->post("http://localhost/PHP-OOP-TDD/bug-reporter/api/add.php", $postData);
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);

        $result = $this->repository->findBy([
            ['report_type', '=', 'Video Issue'],
            ['link', '=', 'http://localhost/'],
            ['email', '=', 'email@example.com']
        ]);

        /** @var BugReport $bugReport */
        $bugReport = $result[0] ?? [];
        
        self::assertInstanceOf(BugReport::class, $bugReport);
        self::assertSame('Video Issue', $bugReport->getReportType());
        self::assertSame('http://localhost/', $bugReport->getLink());
        self::assertSame('email@example.com', $bugReport->getEmail());

        return $bugReport;
    }

    /** @depends testItCanCreateReportUsingPostRequest */
    public function testItCanUpdateReportUsingPostRequest(BugReport $bugReport)
    {
        $postData = $this->getPostData([
            'update' => true,
            'message' => 'The video PHP OOP has issues, please report them',
            'link' => 'http://updated/',
            'reportId' => $bugReport->getId()
        ]);
        $response = $this->client->post("http://localhost/PHP-OOP-TDD/bug-reporter/api/update.php", $postData);
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);

        /** @var BugReport $result */
        $result = $this->repository->find($bugReport->getId());

        self::assertInstanceOf(BugReport::class, $result);
        self::assertSame('The video PHP OOP has issues, please report them', $result->getMessage());
        self::assertSame('http://updated/', $result->getLink());

        return $result;
    }

    /** @depends testItCanUpdateReportUsingPostRequest */
    public function testItCanDeleteReportUsingPostRequest(BugReport $bugReport)
    {
        $postData = $this->getPostData([
            'delete' => true,
            'reportId' => $bugReport->getId()
        ]);
        $this->client->post("http://localhost/PHP-OOP-TDD/bug-reporter/api/delete.php", $postData);

        /** @var BugReport $result */
        $result = $this->repository->find($bugReport->getId());
        self::assertNull($result);
    }

    private function getPostData(array $options = []): array
    {
        return array_merge([
            'report_type' => 'Video Issue',
            'message' => 'The video xxxxxx has issues, please report them',
            'email' => 'email@example.com',
            'link' => 'http://localhost/'
        ], $options);
    }
}