<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;

interface MiddlewareInterface
{
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response;
}
