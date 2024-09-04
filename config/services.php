<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use HibouTech\Framework\Console\Application;
use HibouTech\Framework\Console\Command\MigrateDatabase;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Dbal\ConnectionFactory;
use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Http\Middleware\RequestHandler;
use HibouTech\Framework\Http\Middleware\RequestHandlerInterface;
use HibouTech\Framework\Routing\Router;
use HibouTech\Framework\Routing\RouterInterface;
use HibouTech\Framework\Session\Session;
use HibouTech\Framework\Session\SessionInterface;
use HibouTech\Framework\Template\TwigFactory;
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
$databaseUrl = 'pdo-sqlite:///' . BASE_PATH . '/var/db.sqlite';

$container->add(
  'base-commands-namespace',
  new StringArgument('HibouTech\Framework\Console\Command\\')
);

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
  ->addMethodCall(
    'setRoutes',
    [new ArrayArgument($routes)]
  );

$container->add(RequestHandlerInterface::class, RequestHandler::class)
  ->addArgument($container);

$container->add(Kernel::class)
  ->addArguments([
    RouterInterface::class,
    $container,
    RequestHandlerInterface::class
  ]);

//add Application to the container
$container->add(Application::class)
  ->addArgument($container);


$container->add(\HibouTech\Framework\Console\Kernel::class)
  ->addArguments([
    $container,
    Application::class
  ]);

$container->addShared(SessionInterface::class, Session::class);
$container->add('template-renderer-factory', TwigFactory::class)
  ->addArguments([
    SessionInterface::class,
    new StringArgument($templatesPath)
  ]);

$container->addShared('twig', function () use ($container) {
  return $container->get('template-renderer-factory')->create();
});

$container->add(AbstractController::class);

$container->inflector(AbstractController::class)
  ->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
  ->addArguments([
    new \League\Container\Argument\Literal\StringArgument($databaseUrl)
  ]);

$container->addShared(Connection::class, function () use ($container): Connection {
  return $container->get(ConnectionFactory::class)->create();
});

$container->add(
  'database:migrations:migrate',
  MigrateDatabase::class
)->addArgument(\Doctrine\DBAL\Connection::class)
  ->addArgument(new StringArgument(BASE_PATH . '/migrations'))
;

return $container;
