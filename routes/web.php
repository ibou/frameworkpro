<?php // routes/web.php

use App\Controller\HomeController;
use App\Controller\PostsController;
use HibouTech\Framework\Http\Response;

return [
  ['POST', '/', [\App\Controller\HomeController::class, 'index']],
  ['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show']],
  ['GET', '/hello/{name:.+}', function (string $name) {
    return new Response("Hello $name");
  }]
];