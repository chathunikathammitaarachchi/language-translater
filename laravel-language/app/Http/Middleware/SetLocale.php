<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if ($request->route('lang')) {
            $locale = $request->route('lang');
            if (in_array($locale, ['en', 'si'])) {
                Session::put('locale', $locale);
            }
        }

        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}
