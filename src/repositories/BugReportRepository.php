<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entities\BugReport;

class BugReportRepository extends Repository
{
    protected static $table = 'reports';
    protected static $entity = BugReport::class;
}