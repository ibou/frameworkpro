<?php

declare(strict_types=1);

use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Routing\Router;
use HibouTech\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new \League\Container\Container();
$container->delegate(new \League\Container\ReflectionContainer(true));

# parameters for application configuration
$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));


$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
  ->addMethodCall(
    'setRoutes',
    [new ArrayArgument($routes)]
  );
$container->add(Kernel::class)
          ->addArgument(RouterInterface::class)
          ->addArgument($container);

return $container;
