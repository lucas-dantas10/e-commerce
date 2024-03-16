<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        return response([
            'message' => 'Você não tem permissão para executar esta ação',
        ], 403);
    }
}
