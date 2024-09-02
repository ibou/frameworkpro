<?php

declare(strict_types=1);

use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$kernel = new Kernel($router);
$request = Request::createFromGlobals(); 

$response = $kernel->handle($request);
$response->send();
