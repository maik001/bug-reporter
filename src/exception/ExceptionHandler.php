<?php
namespace App\Exception;

use App\Helpers\App;
use Throwable;

class ExceptionHandler
{
    public function handle(Throwable $exception): void
    {
        $app = new App;
        if($app->isDebugMode()){
            var_dump($exception);
        } else {
            echo "The app is running without debug mode, feature not available";
        }
        exit;
    }
}