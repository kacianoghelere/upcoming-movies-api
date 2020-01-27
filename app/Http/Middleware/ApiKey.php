<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class ApiKey {

    public function handle($request, Closure $next) {
        if (env('SECURE_API_TOKEN', '') !== $request->header('Authorization')) {
            return response()->json(
                'Unauthorized API token',
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
