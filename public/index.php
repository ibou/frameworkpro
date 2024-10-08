<?php

declare(strict_types=1);

use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

$container = include BASE_PATH . '/config/services.php';

//load bootrap file
require BASE_PATH . '/bootstrap/bootstrap.php';

$request = Request::createFromGlobals();
$kernel = $container->get(Kernel::class); 

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
