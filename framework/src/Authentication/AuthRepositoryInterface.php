<?php

declare(strict_types=1);

namespace HibouTech\Framework\Authentication;

interface AuthRepositoryInterface
{
  public function findByUsername(string $username): ?AuthUserInterface;
}