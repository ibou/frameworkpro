<?php

declare(strict_types=1);

namespace HibouTech\Framework\Dbal\Event;

use HibouTech\Framework\Dbal\Entity;

class PostPersist
{
  public function __construct(private Entity $subject) {}
}