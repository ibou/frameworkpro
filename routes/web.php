<?php
 

return [
  ['GET', '/', [\App\Controller\HomeController::class, 'index']],
  ['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show',
    [
      \HibouTech\Framework\Http\Middleware\Authenticate::class, 
    ]]],
  ['GET', '/posts', [\App\Controller\PostsController::class, 'create']],
  ['POST', '/posts', [\App\Controller\PostsController::class, 'store']],
  ['GET', '/register', [\App\Controller\RegistrationController::class, 'index',
  [
      \HibouTech\Framework\Http\Middleware\Guest::class
  ]]],
  ['POST', '/register', [\App\Controller\RegistrationController::class, 'register']],
  ['GET', '/login', [\App\Controller\LoginController::class, 'index',
  [
      \HibouTech\Framework\Http\Middleware\Guest::class
  ]]],
  ['POST', '/login', [\App\Controller\LoginController::class, 'login']],
  ['GET', '/logout', [\App\Controller\LoginController::class,'logout',
    [\HibouTech\Framework\Http\Middleware\Authenticate::class]
  ]],
  ['GET', '/dashboard', [\App\Controller\DashboardController::class, 'index',
  [
      \HibouTech\Framework\Http\Middleware\Authenticate::class,
      \HibouTech\Framework\Http\Middleware\Dummy::class
  ]]],
  ['GET', '/hello/{name:.+}', function (string $name) {
    return new HibouTech\Framework\Http\Response("Hello $name");
  }]
];