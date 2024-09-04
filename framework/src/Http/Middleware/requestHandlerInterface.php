<?php

declare(strict_types=1);

namespace HibouTech\Framework\Http\Middleware;

use HibouTech\Framework\Http\Request;
use HibouTech\Framework\Http\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;  
}