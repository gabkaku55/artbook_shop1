<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', 'uk');
        App::setLocale($locale);

        $currency = match ($locale) {
            'en' => 'USD',
            'de' => 'EUR',
            default => 'UAH',
        };
        Session::put('currency', $currency);

        return $next($request);
    }
}
