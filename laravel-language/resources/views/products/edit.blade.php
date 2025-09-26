@extends('layouts.app')

@section('title', __('Edit Product'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ __('Edit Product') }} - {{ $product->name }}</h4>
            </div>
            <div class="card-body">
                @if(isset($product))
                <form action="{{ route('products.update', ['lang' => app()->getLocale(), 'id' => $product->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('Price') }} (Rs.) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">{{ __('Stock Quantity') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('products.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                            {{ __('Back to Products') }}
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Product') }}
                            </button>
                        </div>
                    </div>
                </form>
                @else
                    <div class="alert alert-danger">
                        {{ __('Product not found.') }}
                    </div>
                    <a href="{{ route('products.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                        {{ __('Back to Products') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection