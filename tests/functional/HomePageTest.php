<?php declare(strict_types=1);

namespace Tests\Functional;

use App\Helpers\HttpClient;
use PHPUnit\Framework\TestCase;

class HomePageTest extends TestCase
{
    public function testItCanVisitHomePageAndSeeRelevantData()
    {
        $client = new HttpClient;
        $response = $client->get("http://localhost/PHP-OOP-TDD/bug-reporter/index.php");
        $response = json_decode($response, true);
        self::assertEquals(200, $response['statusCode']);
        self::assertStringContainsString('Bug Reporter App', $response['content']);
        self::assertStringContainsString('<link rel="stylesheet" type="text/css" href="/resources/css/styles.css">', $response['content']);
    }
}