<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('welcome') }}</title>
</head>
<body>
    <h1>{{ __('welcome') }}</h1>
    <p>{{ __('about_us') }}</p>
    <p>{{ __('contact_us') }}</p>

    <a href="{{ url('/lang/en') }}">English</a> |
    <a href="{{ url('/lang/si') }}">සිංහල</a>
</body>
</html>
