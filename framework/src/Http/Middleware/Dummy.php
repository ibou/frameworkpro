<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;

class Dummy implements MiddlewareInterface
{
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    return $requestHandler->handle($request);
  }
}