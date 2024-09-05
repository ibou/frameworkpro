<?php

declare(strict_types=1);

namespace HibouTech\Framework\Routing;

use HibouTech\Framework\Http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;
}
