<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http;

use FastRoute\RouteCollector;
use HibouTech\Framework\Routing\RoutingInterface;

use function FastRoute\simpleDispatcher;

class Kernel
{

  public function __construct(private RoutingInterface $router) {}

  public function handle(Request $request): Response
  {
    try {

      [$routeHandler, $vars] = $this->router->dispatch($request);

      $response = call_user_func_array($routeHandler, $vars);
    } catch (HttpRequestMethodException $exception) {
      $response = new Response($exception->getMessage(), $exception->getStatusCode());
    } catch (HttpException $exception) {
      $response = new Response($exception->getMessage(), $exception->getStatusCode());
    } catch (\Exception $exception) {
      $response = new Response($exception->getMessage(), $exception->getCode());
    }

    return $response;
  }
}
