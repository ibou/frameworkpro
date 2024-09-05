<?php

declare(strict_types=1);

namespace HibouTech\Framework\Routing;

use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\Request;
use Psr\Container\ContainerInterface;

class Router implements RouterInterface
{

  public function dispatch(Request $request, ContainerInterface $container): array
  {
    $routeHandler = $request->getRouteHandler();
    $routeHandlerArgs = $request->getRouteHandlerArgs();

    if (is_array($routeHandler)) {
      [$controllerId, $method] = $routeHandler;
      $controller = $container->get($controllerId);
      if (is_subclass_of($controller, AbstractController::class)) {
        $controller->setRequest($request);
      }
      $routeHandler = [$controller, $method];
    }

    return [$routeHandler, $routeHandlerArgs];
  }
}
