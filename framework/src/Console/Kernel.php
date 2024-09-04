<?php

declare(strict_types=1);

namespace HibouTech\Framework\Console;

use HibouTech\Framework\Console\Command\CommandInterface;
use Psr\Container\ContainerInterface;

class Kernel
{

  public function __construct(
    private ContainerInterface $container,
    private Application $application
    ) {}

  public function handle(): int
  {
    $this->registerCommands();
    $status = $this->application->run();
    return $status;
  }

  private function registerCommands(): void
  {
    $commandFiles = new \DirectoryIterator(__DIR__ . '/Command');

    $namespace = $this->container->get('base-commands-namespace');

    foreach ($commandFiles as $commandFile) {

      if (!$commandFile->isFile()) {
        continue;
      }

      // Get the Command class name..using psr4 this will be same as filename
      $command = $namespace . pathinfo($commandFile->getFilename(), PATHINFO_FILENAME);

      // If it is a subclass of CommandInterface
      if (is_subclass_of($command, CommandInterface::class)) {
        // Add to the container, using the name as the ID e.g. $container->add('database:migrations:migrate', MigrateDatabase::class)
        $commandName = (new \ReflectionClass($command))->getProperty('name')->getDefaultValue();
        
        $this->container->add($commandName, $command);
      }
    }
  }
}
