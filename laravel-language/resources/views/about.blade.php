@extends('layouts.app')

@section('title', __('About Us'))

@section('content')
    <div style="
        background-image: url('https://static.vecteezy.com/system/resources/thumbnails/051/166/488/small/businessman-showing-business-growth-and-success-graph-concept-of-progress-in-development-financial-efficiency-and-investment-with-business-strategy-for-goals-and-opportunities-in-the-industry-future-free-photo.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    ">

        {{-- Dark overlay for readability --}}
        <div style="
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        "></div>

        <div class="container text-white position-relative z-2">
            <h1 class="text-center mb-4" style="font-size: 3rem; font-weight: bold;">
                {{ __('About Us') }}
            </h1>

            <div class="row justify-content-center">
                <div class="col-md-8 bg-white text-dark p-4 rounded shadow" style="background-color: rgba(161, 167, 228, 0.9);">
                    <p class="fs-5" style="line-height: 1.8;">
{{ __('We are a passionate team committed to delivering innovative solutions that drive success and growth. With a strong focus on quality, customer satisfaction, and continuous improvement, we strive to empower businesses and individuals through technology and creativity. Our mission is to create value, build lasting relationships, and contribute positively to the communities we serve.') }}
                    </p>

                    <div class="text-center mt-4">
                        <a href="{{ route('home', ['lang' => app()->getLocale()]) }}"
                           class="btn btn-primary px-4 py-2"
                           style="font-weight: 500;"
                        >
                            {{ __('Back to Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
