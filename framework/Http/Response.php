<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http;

class Response
{
  public function __construct(
    public readonly string $content = '',
    public readonly int $status = 200,
    public readonly array $headers = [],
  ) {
    http_response_code($this->status);
  }

  public function send(): void
  {
    foreach ($this->headers as $name => $value) {
      header(sprintf('%s: %s', $name, $value), false, $this->status);
    }

    echo $this->content;
  }
}
