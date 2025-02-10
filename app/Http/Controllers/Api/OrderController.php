<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderProducts', 'paymentMethod')->get();

        $orders->transform(function ($order) {
            $order->payment_method = $order->payment_method->name ?? '-';
            $order->orderProducts->transform(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name ?? '-',
                    'quantity' => $item->quantity ?? 0,
                    'price' => $item->unit_price ?? 0,
                ];
            });

            return $order;
        });

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|string',
            'gender' => 'nullable|string',
            'birthday' => 'nullable|date',
            'phone' => 'nullable|string',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|integer|min:0',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan validasi',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek stok produk
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk :' . $product->name . ' tidak mencukupi'
                ], 422);
            }
        }

        // Buat pesanan
        $order = Order::create($request->only([
            'name',
            'email',
            'gender',
            'birthday',
            'phone',
            'total_price',
            'notes',
            'payment_method_id',
            'paid_amount',
            'change_amount',
        ]));

        // Simpan item pesanan
        foreach ($request->items as $item) {
            $order->orderProducts()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil disimpan',
            'data' => $order
        ], 200);
    }

}
