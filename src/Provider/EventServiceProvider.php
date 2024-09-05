<?php

declare(strict_types=1);

namespace App\Provider;

use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;
use HibouTech\Framework\Dbal\Event\PostPersist;
use HibouTech\Framework\EventDispatcher\EventDispatcher;
use HibouTech\Framework\Http\Event\ResponseEvent;
use HibouTech\Framework\ServiceProvider\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{

  private array $listen = [
    ResponseEvent::class => [
      InternalErrorListener::class,
      ContentLengthListener::class
    ],
    PostPersist::class => []
  ];
  public function __construct(private EventDispatcher $eventDispatcher) {}

  public function register(): void
  {
    foreach ($this->listen as $eventName => $listeners) {
      // loop over each listener
      foreach (array_unique($listeners) as $listener) {
        // call eventDispatcher->addListener
        $this->eventDispatcher->addListener($eventName, new $listener());
      }
    }
  }
}
