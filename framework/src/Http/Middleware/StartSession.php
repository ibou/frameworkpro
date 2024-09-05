<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;


use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;
use HibouTech\Framework\Session\SessionInterface;

class StartSession implements MiddlewareInterface
{

  public function __construct(
    private SessionInterface $session,
    private string $apiPrefix = '/api/'
    ) {}

  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    if (!str_starts_with($request->getPathInfo(), $this->apiPrefix)) {
      $this->session->start(); 

      $request->setSession($this->session);
    }
    return $requestHandler->handle($request);
  }
}
