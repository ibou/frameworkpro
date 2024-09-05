<?php

declare(strict_types=1);

namespace HibouTech\Framework\Dbal;

use Doctrine\DBAL\Connection;

class DataMapper
{
  public function __construct(
    private Connection $connection
  ) {}

  public function getConnection(): Connection
  {
    return $this->connection;
  }

  public function save(Entity $subject): int|string|null
  {
    // Dispatch PostPersist event
    //$this->eventDispatcher->dispatch(new PostPersist($subject));

    // Return lastInsertId
    return $this->connection->lastInsertId();
  }
}
