<?php

declare(strict_types=1);

namespace HibouTech\Framework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;


class ConnectionFactory
{
  public function __construct(private string $databaseUrl) {}

  public function create(): Connection
  {

    $dsnParser = new DsnParser([]);
    $connectionParams = $dsnParser->parse($this->databaseUrl);
    $connectionParams = array_merge($connectionParams, [
      'url' => 'sqlite:///' . $connectionParams['path']
      ]); 
    return DriverManager::getConnection($connectionParams);
  }
}
