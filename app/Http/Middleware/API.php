<?php
/**
 * Copyright 2024 Son of Binary
 * The Fantasktick Project
 * This middleware is responsible for setting basic contents of an API response.
 */

namespace App\Http\MIddleware;

use Closure;

class API
{
    public function handle($request, Closure $next)
    {
        $request -> jsonContent = json_decode($request -> getContent(), true);
        $response = $next($request);
        $response->header('Access-Control-Allow-Headers', '*');
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}
