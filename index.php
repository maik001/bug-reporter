<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

set_exception_handler([new App\Exception\ExceptionHandler(), 'handle']);

$config = App\Helpers\Config::getFileContent('yeeyey');
var_dump($config);

$app = new App\Helpers\App();

echo $app->getServerTime()->format('Y-m-d H:i:s') . PHP_EOL;
echo $app->getLogPath(). PHP_EOL;
echo $app->getEnviroment(). PHP_EOL;
echo $app->isDebugMode(). PHP_EOL;

if($app->isRunningFromConsole()) {
    echo 'from console';
} else {
    echo 'from browser';
}
