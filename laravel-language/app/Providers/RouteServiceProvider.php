<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\User;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        // Call the parent's boot method
        parent::boot();

        // Explicit binding to make sure it works with {lang} prefix
        Route::bind('user', function ($value) {
            return User::findOrFail($value);
        });
    }
}
