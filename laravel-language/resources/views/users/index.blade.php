@extends('layouts.app')

@section('title', __('User Management'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('User Management') }}</h2>
            <a href="{{ route('users.create', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">
                {{ __('Add User') }}
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <a href="{{ route('users.edit', ['lang' => app()->getLocale(), 'user' => $user->id]) }}" 
                                   class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                <form action="{{ route('users.destroy', ['lang' => app()->getLocale(), 'user' => $user->id]) }}" 
                                      method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('{{ __('Are you sure?') }}')">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection