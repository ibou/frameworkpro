<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http;

use Doctrine\DBAL\Connection;
use HibouTech\Framework\Http\Middleware\RequestHandlerInterface;
use HibouTech\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

class Kernel
{

  private string $appEnv;

  public function __construct(
    private RouterInterface $router,
    private ContainerInterface $container,
    private RequestHandlerInterface $requestHandler
  ) {
    $this->appEnv = $this->container->get('APP_ENV');
  }

  public function handle(Request $request): Response
  {
    try {
      $response = $this->requestHandler->handle($request);
    } catch (\Exception $exception) {
      $response = $this->createExceptionResponse($exception);
    }

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
