<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ProductReportController extends Controller
{
    public function pdf()
    {
        // Ambil data produk, bisa disesuaikan filter atau sorting sesuai kebutuhan
        $products = Product::with('category')->orderBy('stock', 'asc')->get();

        // Muat view laporan dan convert ke PDF
        $pdf = PDF::loadView('pdf.product-report', compact('products'));

        // Kembalikan file PDF untuk didownload
        return $pdf->download('laporan_stok_barang.pdf');
    }
}
