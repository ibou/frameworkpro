<?php

declare(strict_types=1);

use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Routing\Router;
use HibouTech\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new \League\Container\Container();
$container->delegate(new \League\Container\ReflectionContainer(true));

# parameters for application configuration
$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$templatesPath = BASE_PATH . '/templates';

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


$container->addShared('filesystem-loader', FilesystemLoader::class)
  ->addArgument(new StringArgument($templatesPath));

$container->addShared('twig', Environment::class)
  ->addArgument('filesystem-loader');

$container->add(AbstractController::class);

$container->inflector(\HibouTech\Framework\Controller\AbstractController::class)
  ->invokeMethod('setContainer', [$container]);

return $container;
