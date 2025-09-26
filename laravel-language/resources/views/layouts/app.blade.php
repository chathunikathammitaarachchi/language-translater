<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - {{ __('Home') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" style="padding: 0.75rem 1rem;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home', ['lang' => app()->getLocale()]) }}" style="font-size: 1.25rem;">
            {{ __('Home') }}
        </a>

        <!-- Nav Links -->
        <div class="navbar-nav gap-2" style="font-size: 0.95rem;">
            <a class="nav-link" href="{{ route('about', ['lang' => app()->getLocale()]) }}">{{ __('About Us') }}</a>
            <a class="nav-link" href="{{ route('contact', ['lang' => app()->getLocale()]) }}">{{ __('Contact Us') }}</a>
            <a class="nav-link" href="{{ route('users.index', ['lang' => app()->getLocale()]) }}">{{ __('Users') }}</a>
            <a class="nav-link" href="{{ route('products.index', ['lang' => app()->getLocale()]) }}">{{ __('Products') }}</a>
            <a class="nav-link" href="{{ route('bills.index', ['lang' => app()->getLocale()]) }}">{{ __('Bills') }}</a>
        </div>

        <!-- Language Switcher -->
        <div class="d-flex align-items-center gap-2">
            @php
                $currentLocale = app()->getLocale();
                $otherLocale = $currentLocale === 'en' ? 'si' : 'en';

                try {
                    $currentRouteName = Route::currentRouteName();
                    $currentParameters = Route::current()->parameters();

                    if (isset($currentParameters['lang'])) {
                        unset($currentParameters['lang']);
                    }
                } catch (Exception $e) {
                    $currentRouteName = 'home';
                    $currentParameters = [];
                }
            @endphp

            <a href="{{ route($currentRouteName, array_merge($currentParameters, ['lang' => 'en'])) }}"
               class="btn btn-sm {{ $currentLocale === 'en' ? 'btn-primary' : 'btn-outline-primary' }}"
               style="min-width: 50px; font-weight: bold;">
                EN
            </a>
            <a href="{{ route($currentRouteName, array_merge($currentParameters, ['lang' => 'si'])) }}"
               class="btn btn-sm {{ $currentLocale === 'si' ? 'btn-primary' : 'btn-outline-secondary' }}"
               style="min-width: 50px; font-weight: bold;">
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
 {{-- Footer --}}
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1 small">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <p class="small text-muted">{{ __('Powered by Laravel & Bootstrap') }}</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')


 
</body>
</html>