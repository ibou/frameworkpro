<?php

declare(strict_types=1);

namespace App\Controller;

use App\Widget;
use HibouTech\Framework\Controller\AbstractController;
use HibouTech\Framework\Http\Response;

class HomeController extends AbstractController
{

  public function __construct(private Widget $widget) {}


  public function index(): Response
  {
    return $this->render("home.html.twig");
  }
}
