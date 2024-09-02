<?php

declare(strict_types=1);

namespace HibouTech\Framework\Routing;

use HibouTech\Framework\Http\Request;

interface RoutingInterface
{
    public function dispatch(Request $request);
}