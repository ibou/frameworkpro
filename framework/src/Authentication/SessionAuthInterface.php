<?php

declare(strict_types=1);

namespace HibouTech\Framework\Authentication;

interface SessionAuthInterface
{
  public function authenticate(string $username, string $password): bool;

  public function login(AuthUserInterface $user);

  public function logout();

  public function getUser(): AuthUserInterface;
}
