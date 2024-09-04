<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;

class Authenticate implements MiddlewareInterface
{
  private bool $authenticated = true;

  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    if (!$this->authenticated) {
      return new Response('Authentication failed', 401);
    }

    return $requestHandler->handle($request);
  }
}