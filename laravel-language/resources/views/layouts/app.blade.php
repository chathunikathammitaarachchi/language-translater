<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - {{ __('Home') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home', ['lang' => app()->getLocale()]) }}">{{ __('Home') }}</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('about', ['lang' => app()->getLocale()]) }}">{{ __('About Us') }}</a>
                <a class="nav-link" href="{{ route('contact', ['lang' => app()->getLocale()]) }}">{{ __('Contact Us') }}</a>
            </div>
            <div class="ms-auto">
<a href="{{ route(Route::currentRouteName(), ['lang' => 'en']) }}" class="btn btn-sm btn-outline-primary">EN</a>
<a href="{{ route(Route::currentRouteName(), ['lang' => 'si']) }}" class="btn btn-sm btn-outline-secondary">SI</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
