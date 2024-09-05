<?php

declare(strict_types=1);

namespace HibouTech\Framework\ServiceProvider;

interface ServiceProviderInterface
{
    public function register(): void;
}