<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\User\RegistrationForm;
use App\Repository\UserMapper;
use HibouTech\Framework\Authentication\SessionAuthentication;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\RedirectResponse;
use HibouTech\Framework\Http\Response;

class RegistrationController extends AbstractController
{
  public function __construct(
    private UserMapper $userMapper,
    private SessionAuthentication $authComponent,
  ) {}
  public function index(): Response
  {
    return $this->render('register.html.twig');
  }

  public function register(): Response
  {

    $form = new RegistrationForm($this->userMapper);
    $form->setFields(
      $this->request->input('username'),
      $this->request->input('password')
    );

    // Validate
    // If validation errors,
    if ($form->hasValidationErrors()) {
      // add to session, redirect to form
      foreach ($form->getValidationErrors() as $error) {
        $this->request->getSession()->setFlash('error', $error);
      }
      return new RedirectResponse('/register');
    }

    // register the user by calling $form->save()
    $user = $form->save();

    // Add a session success message
    $this->request->getSession()->setFlash(
      'success',
      sprintf('User %s created', $user->getUsername())
    );

    // Log the user in
    $this->authComponent->login($user);

    // Redirect to somewhere useful
    return new RedirectResponse('/dashboard');
  }
}
