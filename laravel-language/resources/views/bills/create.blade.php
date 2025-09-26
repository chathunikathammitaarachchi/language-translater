@extends('layouts.app')

@section('title', __('Create Bill'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Create Bill') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bills.store', ['lang' => app()->getLocale()]) }}" method="POST" id="billForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="user_id" class="form-label">{{ __('Select Customer') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">{{ __('Select Customer') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="bill_date" class="form-label">{{ __('Bill Date') }} <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('bill_date') is-invalid @enderror" 
                                   id="bill_date" name="bill_date" value="{{ old('bill_date', date('Y-m-d')) }}" required>
                            @error('bill_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">{{ __('Notes') }}</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="mb-3">{{ __('Bill Items') }} <span class="text-danger">*</span></h5>
                    
                    <div id="billItems">
                        <div class="bill-item mb-3 p-3 border rounded">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">{{ __('Select Product') }}</label>
                                    <select class="form-select product-select @error('items.0.product_id') is-invalid @enderror" 
                                            name="items[0][product_id]" required onchange="updatePriceAndStock(this)">
                                        <option value="">{{ __('Select Product') }}</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                    data-price="{{ $product->price }}" 
                                                    data-stock="{{ $product->stock_quantity }}"
                                                    data-name="{{ $product->name }}">
                                                {{ $product->name }} - Rs. {{ number_format($product->price, 2) }} 
                                                ({{ __('Stock') }}: {{ $product->stock_quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('items.0.product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('Quantity') }}</label>
                                    <input type="number" class="form-control quantity @error('items.0.quantity') is-invalid @enderror" 
                                           name="items[0][quantity]" value="{{ old('items.0.quantity', 1) }}" min="1" 
                                           oninput="calculateItemTotal(this)" required>
                                    @error('items.0.quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted stock-info"></small>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('Unit Price') }}</label>
                                    <input type="text" class="form-control unit-price" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('Subtotal') }}</label>
                                    <input type="text" class="form-control subtotal" readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-danger remove-item w-100" style="display: none;">×</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('items')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="button" class="btn btn-secondary mt-2" id="addItem">
                        {{ __('Add Item') }}
                    </button>

                    <div class="row mt-4">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <strong class="fs-5">{{ __('Total Amount') }}:</strong>
                                <strong class="fs-5 text-primary" id="totalAmount">Rs. 0.00</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Create Bill') }}
                        </button>
                        <a href="{{ route('bills.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@push('scripts')
<script>
let itemCount = 1;

// Update price and stock when product is selected
function updatePriceAndStock(selectElement) {
    const item = selectElement.closest('.bill-item');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
    
    // Update unit price
    item.querySelector('.unit-price').value = 'Rs. ' + price.toFixed(2);
    
    // Update stock info
    const stockInfo = item.querySelector('.stock-info');
    stockInfo.textContent = `{{ __('Available') }}: ${stock}`;
    
    // Enable/disable quantity input based on stock
    const quantityInput = item.querySelector('.quantity');
    if (stock === 0) {
        quantityInput.disabled = true;
        quantityInput.value = 0;
        stockInfo.classList.add('text-danger');
    } else {
        quantityInput.disabled = false;
        quantityInput.setAttribute('max', stock);
        quantityInput.value = 1;
        stockInfo.classList.remove('text-danger');
    }
    
    // Calculate item total
    calculateItemTotal(quantityInput);
}

// Calculate item total
function calculateItemTotal(inputElement) {
    const item = inputElement.closest('.bill-item');
    const quantity = parseFloat(inputElement.value) || 0;
    const select = item.querySelector('.product-select');
    const selectedOption = select.options[select.selectedIndex];
    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
    const subtotal = quantity * price;
    
    item.querySelector('.subtotal').value = 'Rs. ' + subtotal.toFixed(2);
    calculateTotal();
}

// Calculate total amount
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.bill-item').forEach(function(item) {
        const subtotalText = item.querySelector('.subtotal').value;
        const subtotal = parseFloat(subtotalText.replace('Rs. ', '')) || 0;
        total += subtotal;
    });
    document.getElementById('totalAmount').textContent = 'Rs. ' + total.toFixed(2);
}

// Add new item
document.getElementById('addItem').addEventListener('click', function() {
    const newItem = document.createElement('div');
    newItem.className = 'bill-item mb-3 p-3 border rounded';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-5">
                <label class="form-label">{{ __('Select Product') }}</label>
                <select class="form-select product-select" name="items[${itemCount}][product_id]" required onchange="updatePriceAndStock(this)">
                    <option value="">{{ __('Select Product') }}</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" 
                                data-price="{{ $product->price }}" 
                                data-stock="{{ $product->stock_quantity }}"
                                data-name="{{ $product->name }}">
                            {{ $product->name }} - Rs. {{ number_format($product->price, 2) }} 
                            ({{ __('Stock') }}: {{ $product->stock_quantity }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('Quantity') }}</label>
                <input type="number" class="form-control quantity" name="items[${itemCount}][quantity]" value="1" min="1" oninput="calculateItemTotal(this)" required>
                <small class="text-muted stock-info"></small>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('Unit Price') }}</label>
                <input type="text" class="form-control unit-price" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('Subtotal') }}</label>
                <input type="text" class="form-control subtotal" readonly>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger remove-item w-100" onclick="removeItem(this)">×</button>
            </div>
        </div>
    `;
    
    document.getElementById('billItems').appendChild(newItem);
    itemCount++;
    document.querySelectorAll('.remove-item').forEach(btn => btn.style.display = 'block');
});

// Remove item
function removeItem(button) {
    const items = document.querySelectorAll('.bill-item');
    if (items.length > 1) {
        button.closest('.bill-item').remove();
        calculateTotal();
    }
}

// Form validation
document.getElementById('billForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    document.querySelectorAll('.bill-item').forEach(function(item, index) {
        const productSelect = item.querySelector('.product-select');
        const quantityInput = item.querySelector('.quantity');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        
        if (!productSelect.value) {
            isValid = false;
            productSelect.classList.add('is-invalid');
        } else {
            productSelect.classList.remove('is-invalid');
        }
        
        if (quantity < 1 || quantity > stock) {
            isValid = false;
            quantityInput.classList.add('is-invalid');
            const stockInfo = item.querySelector('.stock-info');
            stockInfo.classList.add('text-danger');
            stockInfo.textContent = '{{ __('Invalid quantity') }}';
        } else {
            quantityInput.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('{{ __('Please check the form for errors. Make sure all products are selected and quantities are valid.') }}');
    }
});

// Initialize first item
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
    // Show remove button if there are multiple items
    if (document.querySelectorAll('.bill-item').length > 1) {
        document.querySelectorAll('.remove-item').forEach(btn => btn.style.display = 'block');
    }
});
</script>
@endpush
