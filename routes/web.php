<?php // routes/web.php

use App\Controller\HomeController;
use App\Controller\PostsController;
use HibouTech\Framework\Http\Response;

return [
  ['GET', '/', [\App\Controller\HomeController::class, 'index']],
  ['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show']],
  ['GET', '/posts', [\App\Controller\PostsController::class, 'create']],
  ['POST', '/posts', [\App\Controller\PostsController::class, 'store']],
  ['GET', '/register', [\App\Controller\RegistrationController::class, 'index']],
  ['POST', '/register', [\App\Controller\RegistrationController::class, 'register']],
  ['GET', '/hello/{name:.+}', function (string $name) {
    return new Response("Hello $name");
  }]
];