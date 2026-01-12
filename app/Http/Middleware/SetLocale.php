<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = session('locale') ?? request()->cookie('locale') ?? 'en';
        app()->setLocale($locale);

        return $next($request);
    }
}
