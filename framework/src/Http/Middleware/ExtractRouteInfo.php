<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use HibouTech\Framework\Http\HttpException;
use HibouTech\Framework\Http\HttpRequestMethodException;
use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;

use function FastRoute\simpleDispatcher;

class ExtractRouteInfo implements MiddlewareInterface
{
  public function __construct(private array $routes) {}

  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

      foreach ($this->routes as $route) {
        $routeCollector->addRoute(...$route);
      }
    });

    // Dispatch a URI, to obtain the route info
    $routeInfo = $dispatcher->dispatch(
      $request->getMethod(),
      $request->getPathInfo()
    );

    switch ($routeInfo[0]) {
      case Dispatcher::FOUND:
        // Set $request->routeHandler
        $request->setRouteHandler($routeInfo[1]);
        // Set $request->routeHandlerArgs
        $request->setRouteHandlerArgs($routeInfo[2]);
        // Inject route middleware on handler
        if (is_array($routeInfo[1]) && isset($routeInfo[1][2])) {
          $requestHandler->injectMiddleware($routeInfo[1][2]);
        }
        break;
      case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = implode(', ', $routeInfo[1]);
        $e = new HttpRequestMethodException("The allowed methods are $allowedMethods");
        $e->setStatusCode(405);
        throw $e;
      default:
        $e = new HttpException('Not found');
        $e->setStatusCode(404);
        throw $e;
    }

    return $requestHandler->handle($request);

    return $requestHandler->handle($request);
  }
}
