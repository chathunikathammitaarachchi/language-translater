<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Product;
use App\Models\BillItem;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('user')->get();
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::where('stock_quantity', '>', 0)->get(); // Only products with stock
        return view('bills.create', compact('users', 'products'));
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'bill_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    // Check stock availability
    foreach ($request->items as $item) {
        $product = Product::find($item['product_id']);
        if ($product->stock_quantity < $item['quantity']) {
            return back()->withErrors([
                'items' => __('Insufficient stock for product: ') . $product->name
            ])->withInput();
        }
    }

    $bill = Bill::create([
        'user_id' => $request->user_id,
        'bill_number' => 'BL' . time(),
        'bill_date' => $request->bill_date, 
        'total_amount' => 0,
        'notes' => $request->notes,
    ]);

    $totalAmount = 0;

    foreach ($request->items as $item) {
        $product = Product::find($item['product_id']);
        $subtotal = $product->price * $item['quantity'];
        $totalAmount += $subtotal;

        BillItem::create([
            'bill_id' => $bill->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'unit_price' => $product->price,
            'total_price' => $subtotal,
        ]);

        // Update stock
        $product->decrement('stock_quantity', $item['quantity']);
    }

    $bill->update(['total_amount' => $totalAmount]);

    return redirect()->route('bills.show', ['lang' => app()->getLocale(), 'bill' => $bill->id])
        ->with('success', __('Bill created successfully.'));
}

    public function show($lang, Bill $bill)
    {
        $bill->load('user', 'items.product');
        return view('bills.show', compact('bill'));
    }

    public function destroy($lang, Bill $bill)
    {
        $bill->delete();
        return redirect()->route('bills.index', ['lang' => app()->getLocale()])
            ->with('success', __('Bill deleted successfully.'));
    }
}