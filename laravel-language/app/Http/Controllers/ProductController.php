<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index', ['lang' => app()->getLocale()])
            ->with('success', __('Product created successfully.'));
    }

    public function edit($lang, $id) // lang parameter එක එකතු කරන්න
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.edit', compact('product'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, __('Product not found.'));
        }
    }

    public function update(Request $request, $lang, $id) // lang parameter එක එකතු කරන්න
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());

            return redirect()->route('products.index', ['lang' => app()->getLocale()])
                ->with('success', __('Product updated successfully.'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, __('Product not found.'));
        }
    }

    public function destroy($lang, $id) // lang parameter එක එකතු කරන්න
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index', ['lang' => app()->getLocale()])
                ->with('success', __('Product deleted successfully.'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, __('Product not found.'));
        }
    }
}