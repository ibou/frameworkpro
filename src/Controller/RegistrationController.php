<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\User\RegistrationForm;
use App\Repository\UserMapper;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\RedirectResponse;
use HibouTech\Framework\Http\Response;

class RegistrationController extends AbstractController
{
  public function __construct(
    private UserMapper $userMapper
  ) {}
  public function index(): Response
  {
    return $this->render('register.html.twig');
  }

  public function register(): Response
  { 

    // $user = User::create($username, $password);
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
  
    $user = $form->save();
    $this->request->getSession()->setFlash(
      'success', 
      sprintf('User with username "%s" was created...', $user->getUsername())
      );

    return new RedirectResponse('/');
  }
}
