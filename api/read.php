<?php declare(strict_types=1);

use App\Database\QueryBuilder;
use App\Helpers\DbQueryBuilderFactory;
use App\Repositories\BugReportRepository;

/** @var QueryBuilder $queryBuilder */
$queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_reporter_testing']);

$repository = new BugReportRepository($queryBuilder);

$bugReports = $repository->findAll();
