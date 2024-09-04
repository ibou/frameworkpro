<?php

declare(strict_types=1);

namespace HibouTech\Framework\Controller;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
  protected ?ContainerInterface $container = null;
  protected ?Request $request = null;

  public function setContainer(ContainerInterface $container): void
  {
    $this->container = $container;
  }

  public function setRequest(Request $request): void
  {
    $this->request = $request;
  }

  public function render(string $template, array $parameters = [], Response $response = null): Response
  { 
    $content = $this->container->get('twig')->render($template, $parameters);
    $response ??= new Response();
    $response->setContent($content);

    return $response;
  }
}