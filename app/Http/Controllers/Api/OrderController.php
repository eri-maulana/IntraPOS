<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderProducts', 'paymentMethod')->get();

        $orders->transform(function ($order){
            $order->payment_method = $order->payment_method->name ?? '-';
            $order->orderProducts->transform(function ($item){
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
}
