<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function print(Order $order)
    {
        $pdf = PDF::loadView('pdf.struk', compact('order'));
        return $pdf->download('struk_belanja_' . $order->id . '.pdf');
    }
}