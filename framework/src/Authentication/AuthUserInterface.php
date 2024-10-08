<?php

declare(strict_types=1);

namespace HibouTech\Framework\Authentication;

interface AuthUserInterface
{
  public function getAuthId(): int|string;

  public function getUsername(): string;

  public function getPassword(): string;
}
