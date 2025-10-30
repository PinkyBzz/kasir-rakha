<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(20);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'pack_size' => 'required|integer|min:1',
            'pack_label' => 'required|string|max:50',
            'initial_packs' => 'nullable|integer|min:0',
            'discount_type' => 'required|in:none,percent,nominal',
            'discount_value' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $stock = (int)($data['initial_packs'] ?? 0) * (int)$data['pack_size'];
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock' => $stock,
            'pack_size' => $data['pack_size'],
            'pack_label' => $data['pack_label'],
            'discount_type' => $data['discount_type'],
            'discount_value' => $data['discount_value'] ?? 0,
            'image_path' => $path,
        ]);

        return redirect()->route('products.index')->with('success','Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,'.$product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'pack_size' => 'required|integer|min:1',
            'pack_label' => 'required|string|max:50',
            'discount_type' => 'required|in:none,percent,nominal',
            'discount_value' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'pack_size' => $data['pack_size'],
            'pack_label' => $data['pack_label'],
            'discount_type' => $data['discount_type'],
            'discount_value' => $data['discount_value'] ?? 0,
        ]);

        return redirect()->route('products.index')->with('success','Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return back()->with('success','Produk dihapus.');
    }
}
