<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FournisseurMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'fournisseur') {
            if (Auth::user()->status !== 'accepté') {
                return redirect()->back()->with('error', 'Votre compte est en attente de validation par l\'administrateur.');
            }
            return $next($request);
        }    

        abort(403, 'Forbidden');
    }
}

