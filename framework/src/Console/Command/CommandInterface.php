<?php

declare(strict_types=1);

namespace HibouTech\Framework\Console\Command;

interface CommandInterface
{
    public function execute(array $params = []): int;
}