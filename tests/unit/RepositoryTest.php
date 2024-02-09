<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Entities\BugReport;
use App\Helpers\DbQueryBuilderFactory;
use App\Repositories\BugReportRepository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;

    /** @var BugReportRepository $bugReportRepository */
    private $bugReportRepository;

    public function setUp(): void
    {
        $this->queryBuilder = DbQueryBuilderFactory::make(
            'database', 'pdo', ['db_name' => 'bug_reporter_testing']
        );

        $this->queryBuilder->beginTransaction();

        $this->bugReportRepository = new BugReportRepository($this->queryBuilder);
        parent::setUp();
    }
    
    public function testItCanCreateRecordWithEntity()
    { 
        $newBugReport = $this->createBugReport();
        self::assertInstanceOf(BugReport::class, $newBugReport);
        self::assertNotNull($newBugReport->getId());
        self::assertSame('Type 2', $newBugReport->getReportType());
        self::assertSame('http://localhost/', $newBugReport->getLink());
        self::assertSame('This is a dummy message', $newBugReport->getMessage());
        self::assertSame('email@example.com', $newBugReport->getEmail());
    }

    public function testItCanUpdateAGivenEntity()
    {
        $newBugReport = $this->createBugReport();
        $bugReport = $this->bugReportRepository->find($newBugReport->getId());
        $bugReport->setMessage('This is an update')
                ->setLink('http://newlocalhost/');

        $updateReport = $this->bugReportRepository->update($bugReport);
        self::assertInstanceOf(BugReport::class, $updateReport);
        self::assertSame('http://newlocalhost/', $updateReport->getLink());
        self::assertSame('This is an update', $updateReport->getMessage());
    }

    public function testItCanDeleteAGivenEntity()
    {
        $newBugReport = $this->createBugReport();
        $this->bugReportRepository->delete($newBugReport);
        
        $bugReport = $this->bugReportRepository->find($newBugReport->getId());
        self::assertNull($bugReport);
    }

    public function testItCanFindByCriteria()
    {
        $newBugReport = $this->createBugReport();
        $report = $this->bugReportRepository->findBy([
            ['report_type', '=', 'Type 2'],
            ['email', '=', 'email@example.com']
            ]);
        self::assertIsArray($report);
        
        /** @var BugReport $bugReport */
        $bugReport = $report[0];
        self::assertSame('Type 2', $bugReport->getReportType());
        self::assertSame('email@example.com', $bugReport->getEmail());
    }

    private function createBugReport(): BugReport
    {
        $bugReport = new BugReport();
        $bugReport->setReportType('Type 2')
                ->setLink('http://localhost/')
                ->setMessage('This is a dummy message')
                ->setEmail('email@example.com');
        return $this->bugReportRepository->create($bugReport);
    }
    public function tearDown(): void
    {
        $this->queryBuilder->rollback();
        parent::tearDown();
    }
}