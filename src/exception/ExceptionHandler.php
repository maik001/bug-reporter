<?php
declare(strict_types = 1);

namespace App\Exception;

use App\Helpers\App;
use ErrorException, Throwable;

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

    public function convertWarningAndNoticesToException($severity, $message, $file, $line)
    {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }
}