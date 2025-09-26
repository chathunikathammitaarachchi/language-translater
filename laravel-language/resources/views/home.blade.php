@extends('layouts.app')

@section('title', __('Home'))

@section('content')
    <div style="
        background-image: url('https://thumbs.dreamstime.com/b/add-to-cart-internet-web-store-buy-online-e-commerce-concept-153472985.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    " class="text-white">

        <div class="bg-dark bg-opacity-50 p-5 rounded">
            <h1 class="display-4">{{ __('Welcome to our website!') }}</h1>
            <p class="lead">{{ __('Explore our features and services.') }}</p>

            <div class="mt-4">
                <a href="{{ route('about', ['lang' => app()->getLocale()]) }}" class="btn btn-outline-light me-2">
                    {{ __('About Us') }}
                </a>
                <a href="{{ route('contact', ['lang' => app()->getLocale()]) }}" class="btn btn-outline-light">
                    {{ __('Contact Us') }}
                </a>
            </div>
        </div>
    </div>
@endsection
