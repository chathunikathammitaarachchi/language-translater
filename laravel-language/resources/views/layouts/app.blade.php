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
                <a class="nav-link" href="{{ route('users.index', ['lang' => app()->getLocale()]) }}">{{ __('Users') }}</a>
                <a class="nav-link" href="{{ route('products.index', ['lang' => app()->getLocale()]) }}">{{ __('Products') }}</a>
                <a class="nav-link" href="{{ route('bills.index', ['lang' => app()->getLocale()]) }}">{{ __('Bills') }}</a>
            </div>

            {{-- Simple Language Switcher --}}
            <div class="ms-auto">
                @php
                    $currentLocale = app()->getLocale();
                    $otherLocale = $currentLocale === 'en' ? 'si' : 'en';
                    
                    // Get current route name and parameters safely
                    try {
                        $currentRouteName = Route::currentRouteName();
                        $currentParameters = Route::current()->parameters();
                        
                        // Remove lang parameter if exists
                        if (isset($currentParameters['lang'])) {
                            unset($currentParameters['lang']);
                        }
                    } catch (Exception $e) {
                        $currentRouteName = 'home';
                        $currentParameters = [];
                    }
                @endphp

                <a href="{{ route($currentRouteName, array_merge($currentParameters, ['lang' => 'en'])) }}" 
                   class="btn btn-sm {{ $currentLocale === 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
                    EN
                </a>
                <a href="{{ route($currentRouteName, array_merge($currentParameters, ['lang' => 'si'])) }}" 
                   class="btn btn-sm {{ $currentLocale === 'si' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    SI
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>