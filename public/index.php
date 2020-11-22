<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'], $_ENV['APP_ENV']) && false === getenv('APP_ENV')) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__.'/../.env');
}

$env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? getenv('APP_ENV');

// $env = filter_input(INPUT_SERVER, 'APP_ENV') ?? 'dev';
$debug = (bool) (filter_input(INPUT_SERVER, 'APP_DEBUG') ?? ('prod' !== $env));

if ($debug) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = filter_input(INPUT_SERVER, 'TRUSTED_PROXIES') ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = filter_input(INPUT_SERVER, 'TRUSTED_HOSTS') ?? false) {
    Request::setTrustedHosts(explode(',', $trustedHosts));
}

$kernel = new Kernel($env, $debug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
