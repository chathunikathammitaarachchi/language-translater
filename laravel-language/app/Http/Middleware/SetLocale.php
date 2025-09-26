<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Get language from route parameter
        $lang = $request->route('lang');
        
        // Validate and set locale
        if ($lang && in_array($lang, ['en', 'si'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);
        } else {
            // Fallback to session or config
            $fallbackLang = Session::get('locale', config('app.locale'));
            App::setLocale($fallbackLang);
        }

        return $next($request);
    }
}