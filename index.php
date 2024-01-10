<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/exception/Exception.php';

$logger = new \App\Logger\Logger();

$logger->log(
    \App\Logger\LogLevel::EMERGENCY,
    'there is a emergency situation',
    ['exception' => 'exception occured']);

$logger->info("User account created successfully", ['id' => 5]);