<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;
use Psr\Container\ContainerInterface;

class RequestHandler implements RequestHandlerInterface
{
  private array $middleware = [
    ExtractRouteInfo::class,
    StartSession::class,
    VerifyCsrfToken::class,
    RouterDispatch::class
  ];

  public function __construct(
    private ContainerInterface $container
  ) {}

  public function handle(Request $request): Response
  {
    
    if (empty($this->middleware)) {
      return new Response("It's totally borked, mate. Contact support", 500);
    }

    // Get the next middleware class to execute
    $middlewareClass = array_shift($this->middleware);

    $middleware = $this->container->get($middlewareClass);

    // Create a new instance of the middleware call process on it
    $response = $middleware->process($request, $this);

    return $response;
  }

  public function injectMiddleware(array $middleware): void
  {
    array_splice($this->middleware, 0, 0, $middleware); 
  }
}
