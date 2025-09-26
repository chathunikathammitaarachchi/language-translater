@extends('layouts.app')

@section('title', __('Bill Management'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('Bill Management') }}</h2>
            <a href="{{ route('bills.create', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">
                {{ __('Create Bill') }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                @if($bills->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Bill Number') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Bill Date') }}</th>
                                <th>{{ __('Total Amount') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                            <tr>
                                <td>{{ $bill->bill_number }}</td>
                                <td>{{ $bill->user->name }}</td>
                                <td>
                                    @if($bill->bill_date instanceof \Carbon\Carbon)
                                        {{ $bill->bill_date->format('Y-m-d') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($bill->bill_date)->format('Y-m-d') }}
                                    @endif
                                </td>
                                <td>Rs. {{ number_format($bill->total_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('bills.show', ['lang' => app()->getLocale(), 'bill' => $bill->id]) }}" 
                                       class="btn btn-sm btn-info">{{ __('View') }}</a>
                                    <form action="{{ route('bills.destroy', ['lang' => app()->getLocale(), 'bill' => $bill->id]) }}" 
                                          method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('{{ __('Are you sure you want to delete this bill?') }}')">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">{{ __('No bills found.') }}</p>
                        <a href="{{ route('bills.create', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">
                            {{ __('Create Your First Bill') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection