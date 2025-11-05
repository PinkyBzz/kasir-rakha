<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function catalog()
    {
        $products = Product::orderBy('name')->paginate(24);
        return view('orders.catalog', compact('products'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $qty = max(1, (int)$request->input('qty', 1));
        $cart = session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;
        session(['cart' => $cart]);
        return back()->with('success', 'Ditambahkan ke keranjang.');
    }

    public function cart()
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id', array_keys($cart ?: [0]))->get();
        return view('orders.cart', compact('products','cart'));
    }

    public function updateCart(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => 'required|integer|min:0'
        ]);
        $cart = session('cart', []);
        if (!array_key_exists($product->id, $cart)) {
            return back()->with('warning', 'Produk tidak ada di keranjang.');
        }
        $qty = (int)$data['qty'];
        if ($qty === 0) {
            unset($cart[$product->id]);
        } else {
            // Optional: clamp to current stock
            $max = max(0, (int)$product->stock);
            if ($max > 0 && $qty > $max) {
                $qty = $max;
                $msg = 'Jumlah melebihi stok, disesuaikan ke '.$max.'.';
            }
            $cart[$product->id] = $qty;
        }
        session(['cart' => $cart]);
        return back()->with(isset($msg)?'warning':'success', isset($msg)?$msg:'Keranjang diperbarui.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success','Keranjang dikosongkan.');
    }

    public function checkoutForm()
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('orders.catalog')->with('warning','Keranjang kosong.');
        return view('orders.checkout');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:in_store,pickup_later',
            'pickup_at' => 'nullable|date|after:now',
            'payment_method' => 'required|in:cash,transfer,qris',
        ]);
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('orders.catalog');

        $userId = Auth::id();
        DB::transaction(function () use ($request, $cart, $userId, &$order) {
            $order = Order::create([
                'user_id' => $userId,
                'order_type' => $request->order_type,
                'pickup_at' => $request->order_type === 'pickup_later' ? $request->pickup_at : null,
                'status' => $request->order_type === 'in_store' ? 'paid' : 'pending',
                'payment_status' => $request->order_type === 'in_store' ? 'paid' : 'unpaid',
                'payment_method' => $request->payment_method,
                'subtotal' => 0,
                'discount_total' => 0,
                'grand_total' => 0,
                'paid_at' => $request->order_type === 'in_store' ? now() : null,
            ]);

            $subtotal = 0; $discountTotal = 0; $grand = 0;

            foreach ($cart as $productId => $qty) {
                $product = Product::lockForUpdate()->findOrFail($productId);
                if ($product->stock < $qty) {
                    abort(400, 'Stok tidak cukup untuk '.$product->name);
                }
                $unit = (float)$product->price;
                $disc = 0.0;
                if ($product->discount_type === 'percent') {
                    $disc = $unit * ($product->discount_value/100);
                } elseif ($product->discount_type === 'nominal') {
                    $disc = min($unit, (float)$product->discount_value);
                }
                $lineTotal = ($unit - $disc) * $qty;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'unit_price' => $unit,
                    'discount_type' => $product->discount_type,
                    'discount_value' => $product->discount_value,
                    'total' => $lineTotal,
                ]);
                $product->decrement('stock', $qty);
                $subtotal += $unit * $qty;
                $discountTotal += $disc * $qty;
                $grand += $lineTotal;
            }

            $order->update([
                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'grand_total' => $grand,
            ]);
        });

        session()->forget('cart');

        return redirect()->route('orders.receipt', $order->id);
    }

    public function receipt(Order $order)
    {
        $this->authorizeOrder($order);
        $order->load('items.product','user');
        return view('orders.receipt', compact('order'));
    }

    public function markPaid(Request $request, Order $order)
    {
        if (!in_array(auth()->user()->role, ['admin','cashier'], true)) abort(403);
        if ($order->payment_status !== 'paid') {
            $method = $request->input('payment_method');
            $update = [
                'status' => 'paid',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ];
            if ($method && in_array($method, ['cash','transfer','qris'], true)) {
                $update['payment_method'] = $method;
            }
            $order->update($update);
        }
        return back()->with('success','Order ditandai sudah dibayar.');
    }

    private function authorizeOrder(Order $order): void
    {
        $user = auth()->user();
        if ($user->role === 'user' && $order->user_id !== $user->id) {
            abort(403);
        }
    }
}
