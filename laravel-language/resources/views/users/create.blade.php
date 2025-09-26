@extends('layouts.app')

@section('title', isset($user) ? __('Edit User') : __('Add User'))

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>{{ isset($user) ? __('Edit User') : __('Add User') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($user) ? route('users.update', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('users.store', ['lang' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $user->name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $user->email ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Phone') }}</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', $user->phone ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <a href="{{ route('users.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection