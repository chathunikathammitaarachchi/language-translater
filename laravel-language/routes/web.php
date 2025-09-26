<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // redirect to default language, e.g. en
    return redirect()->route('home', ['lang' => config('app.locale')]);
});

// Group routes with lang prefix
Route::group(['prefix' => '{lang}', 'middleware' => ['web', \App\Http\Middleware\SetLocale::class]], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
});
