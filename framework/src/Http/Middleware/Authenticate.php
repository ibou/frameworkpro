<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Authentication\SessionAuthentication;
use HibouTech\Framework\Http\RedirectResponse;
use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;
use HibouTech\Framework\Session\Session;
use HibouTech\Framework\Session\SessionInterface;

class Authenticate implements MiddlewareInterface
{
  public function __construct(private SessionInterface $session) {}

  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    $this->session->start();

    // $this->session->remove(Session::AUTH_KEY);
    if (!$this->session->has(Session::AUTH_KEY)) {
      $this->session->setFlash('error', 'Please sign in');
      return new RedirectResponse('/login');
    }

    return $requestHandler->handle($request);
  }
}
