@extends('layouts.app')

@section('title', __('Bill Details'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('Bill Details') }}</h2>
            <div>
                <a href="{{ route('bills.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                    {{ __('Back to Bills') }}
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    {{ __('Print Bill') }}
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                   
                    <div class="col-md-6 text-end">
                        <h4>{{ __('Bill') }} #{{ $bill->bill_number }}</h4>
                        <p class="mb-1"><strong>{{ __('Bill Date') }}:</strong> 
                            @if($bill->bill_date instanceof \Carbon\Carbon)
                                {{ $bill->bill_date->format('Y-m-d') }}
                            @else
                                {{ \Carbon\Carbon::parse($bill->bill_date)->format('Y-m-d') }}
                            @endif
                        </p>
                        <p class="mb-1"><strong>{{ __('Created At') }}:</strong> {{ $bill->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>{{ __('Customer Information') }}</h5>
                        <p class="mb-1"><strong>{{ __('Name') }}:</strong> {{ $bill->user->name }}</p>
                        <p class="mb-1"><strong>{{ __('Email') }}:</strong> {{ $bill->user->email }}</p>
                        <p class="mb-1"><strong>{{ __('Phone') }}:</strong> {{ $bill->user->phone ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>{{ __('Address') }}:</strong> {{ $bill->user->address ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($bill->notes)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>{{ __('Notes') }}</h5>
                        <p>{{ $bill->notes }}</p>
                    </div>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Unit Price') }}</th>
                                <th>{{ __('Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                                <td>Rs. {{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>{{ __('Total Amount') }}:</strong></td>
                                <td><strong>Rs. {{ number_format($bill->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <p class="text-muted">{{ __('Thank you for your business!') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .navbar, .btn, .alert, .d-flex.justify-content-between {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection