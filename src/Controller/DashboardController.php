<?php

declare(strict_types=1);

namespace App\Controller;

use HibouTech\Framework\Authentication\SessionAuthentication;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\Response;

class DashboardController extends AbstractController
{
  public function __construct(private SessionAuthentication $authComponent) {}

  public function index(): Response
  {
    return $this->render('dashboard.html.twig');
  }
}