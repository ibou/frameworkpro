<?php

declare(strict_types=1);

use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

$container = include BASE_PATH . '/config/services.php';
 
$kernel = $container->get(Kernel::class); 
$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();
