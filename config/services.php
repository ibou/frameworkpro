<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use HibouTech\Framework\Authentication\SessionAuthInterface;
use HibouTech\Framework\Console\Application;
use HibouTech\Framework\Console\Command\MigrateDatabase;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Dbal\ConnectionFactory;
use HibouTech\Framework\Http\Kernel;
use HibouTech\Framework\Http\Middleware\RequestHandler;
use HibouTech\Framework\Routing\Router;
use HibouTech\Framework\Routing\RouterInterface;
use HibouTech\Framework\Session\Session;
use HibouTech\Framework\Session\SessionInterface;
use HibouTech\Framework\Template\TwigFactory;

use League\Container\Argument\Literal\StringArgument;

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new \League\Container\Container();
$container->delegate(new \League\Container\ReflectionContainer(true));

$basePath = dirname(__DIR__);
$container->add('basePath', new \League\Container\Argument\Literal\StringArgument($basePath));
# parameters for application configuration
$routes = include $basePath . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$templatesPath = $basePath . '/templates';

$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));
$databaseUrl = 'pdo-sqlite:///' . $basePath . '/var/db.sqlite';

$container->add(
  'base-commands-namespace',
  new StringArgument('HibouTech\Framework\Console\Command\\')
);

$container->add(RouterInterface::class, Router::class);

$container->add(
  \HibouTech\Framework\Http\Middleware\RequestHandlerInterface::class,
   RequestHandler::class
   )
  ->addArgument($container);

$container->add(Kernel::class)
  ->addArguments([
    $container,
    \HibouTech\Framework\Http\Middleware\RequestHandlerInterface::class,
    \HibouTech\Framework\EventDispatcher\EventDispatcher::class
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
  ->addArgument(new StringArgument($basePath . '/migrations'))
;
//RouterDispatcher
$container->add(\HibouTech\Framework\Http\Middleware\RouterDispatch::class)
  ->addArguments([
    RouterInterface::class,
    $container
  ]);

$container->add(\HibouTech\Framework\Authentication\SessionAuthentication::class)
  ->addArguments([
    \App\Repository\UserRepository::class,
    \HibouTech\Framework\Session\SessionInterface::class
  ]);

$container->add(\HibouTech\Framework\Http\Middleware\ExtractRouteInfo::class)
  ->addArgument(new \League\Container\Argument\Literal\ArrayArgument($routes));

return $container;
