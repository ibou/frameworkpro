<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http;

use FastRoute\RouteCollector;
use HibouTech\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

class Kernel
{

  private string $appEnv;

  public function __construct(
    private RouterInterface $router,
    private ContainerInterface $container
  ) {
    $this->appEnv = $this->container->get('APP_ENV');
  }

  public function handle(Request $request): Response
  {
    try {

      [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

      $response = call_user_func_array($routeHandler, $vars);
    } catch (\Exception $exception) {
      $response = $this->createExceptionResponse($exception);
    }
    // catch (\Exception $exception) {
    //   $response = new Response($exception->getMessage(), $exception->getCode());
    // }

    return $response;
  }

  private function createExceptionResponse(\Exception $exception): Response
  {
    if (in_array($this->appEnv, ['dev', 'test'])) {
      throw $exception;
    }

    if ($exception instanceof HttpException) {
      return new Response($exception->getMessage(), $exception->getStatusCode());
    }

    return new Response('Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
