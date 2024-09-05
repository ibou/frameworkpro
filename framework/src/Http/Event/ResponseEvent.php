<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Event;

use HibouTech\Framework\EventDispatcher\Event;
use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;

class ResponseEvent extends Event
{
  public function __construct(
    private Request $request,
    private Response $response
  ) {}

  public function getRequest(): Request
  {
    return $this->request;
  }

  public function getResponse(): Response
  {
    return $this->response;
  }
}