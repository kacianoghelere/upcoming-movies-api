<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Api {

    public function handle($request, Closure $next) {
        if (env('SECURE_API_TOKEN', '') !== $request->header('Authorization')) {
            return response()->json(
                'Unauthorized api token ' . $request->header('Authorization'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
