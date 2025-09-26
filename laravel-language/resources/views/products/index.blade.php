@extends('layouts.app')

@section('title', __('Product Management'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('Product Management') }}</h2>
            <a href="{{ route('products.create', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">
                {{ __('Add Product') }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Stock Quantity') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ Str::limit($product->description, 50) }}</td>
                                    <td>Rs. {{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('products.edit', ['lang' => app()->getLocale(), 'id' => $product->id]) }}" 
                                               class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                            <form action="{{ route('products.destroy', ['lang' => app()->getLocale(), 'id' => $product->id]) }}" 
                                                  method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">{{ __('No products found.') }}</p>
                        <a href="{{ route('products.create', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">
                            {{ __('Add Your First Product') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection