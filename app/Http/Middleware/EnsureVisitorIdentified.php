<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureVisitorIdentified
{
    /**
     * Redirige al visitante a la página de identificación si no se ha presentado.
     * Los administradores autenticados pasan directamente sin restricción.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si es admin autenticado, dejarlo pasar siempre
        if (Auth::check()) {
            return $next($request);
        }

        // Si el visitante ya se identificó con su nombre, dejarlo pasar
        if ($request->session()->has('visitor_name')) {
            return $next($request);
        }

        // En caso contrario, redirigir a identificarse
        return redirect()->route('identificar');
    }
}
