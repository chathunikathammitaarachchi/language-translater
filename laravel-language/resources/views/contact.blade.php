@extends('layouts.app')

@section('title', __('Contact Us'))

@section('content')
    <div class="container py-5">
        <h1 class="mb-4 text-center text-primary">{{ __('Contact Us') }}</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="fs-5 text-muted text-justify">
                    {{ __('Feel free to contact us.') }}
                </p>

                <form>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Your Name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter your name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email Address') }}</label>
                        <input type="email" class="form-control" placeholder="{{ __('Enter your email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Message') }}</label>
                        <textarea class="form-control" rows="4" placeholder="{{ __('Write your message here') }}"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Send Message') }}</button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('home', ['lang' => app()->getLocale()]) }}" class="btn btn-outline-secondary">
                        {{ __('Back to Home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
