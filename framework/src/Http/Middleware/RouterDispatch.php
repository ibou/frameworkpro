<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;
use HibouTech\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class RouterDispatch implements MiddlewareInterface
{
  public function __construct(
    private RouterInterface $router,
    private ContainerInterface $container
  ) {}

  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

    $response = call_user_func_array($routeHandler, $vars);

    return $response;
  }
}
