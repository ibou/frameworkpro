<?php

declare(strict_types=1);

namespace App\Controller;

use HibouTech\Framework\Authentication\SessionAuthentication;
use HibouTech\Framework\Authentication\SessionAuthInterface;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\RedirectResponse;
use HibouTech\Framework\Http\Response;

class LoginController extends AbstractController
{

  public function __construct(private SessionAuthentication $authComponent) {}


  public function index(): Response
  {
    return $this->render('login.html.twig');
  }

  public function login(): Response
  {

    $userIsAuthenticated = $this->authComponent->authenticate(
      $this->request->input('username'),
      $this->request->input('password')
    );

    if (!$userIsAuthenticated) {
      $this->request->getSession()->setFlash('error', 'Bad creds');
      return new RedirectResponse('/login');
    }

    $user = $this->authComponent->getUser();


    $this->request->getSession()->setFlash('success', 'You are now logged in');

    // Redirect the user to intended location
    return new RedirectResponse('/dashboard');
  }

  public function logout(): Response
  {
    $this->authComponent->logout();
    $this->request->getSession()->setFlash('success', 'You are now logged out');
    return new RedirectResponse('/login');
  }
}
