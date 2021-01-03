<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require \dirname(__DIR__) . '/vendor/autoload.php';

if (!\class_exists(Dotenv::class)) {
    $message = 'Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.';

    throw new RuntimeException($message);
}

// load all the .env files
(new Dotenv())->loadEnv(\dirname(__DIR__) . '/.env');
