<?php

declare(strict_types=1);

namespace App\Controller;

use HibouTech\Framework\Http\Response;

class HomeController
{
  public function index(): Response
  {
    return new Response('Hello World from HomeController index method');
  }
}
