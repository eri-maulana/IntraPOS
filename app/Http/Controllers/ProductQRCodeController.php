<?php
// app/Http/Controllers/ProductQRCodeController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // alias untuk Barryvdh\DomPDF\Facade\Pdf
use Illuminate\Support\Str;

class ProductQRCodeController extends Controller
{
    /**
     * Menampilkan halaman QR Code produk.
     */
    public function show(Product $product)
    {
        // Contoh data yang ingin diencode ke QR Code (misalnya link produk)
        $data = $product->barcode;

        $harga = $product->price;

        // Generate QR Code base64 agar bisa langsung ditampilkan di view
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($data));

        return view('products.qrcode', compact('product', 'qrCode', 'data', 'harga'));
    }

    /**
     * Meng-generate PDF QR Code produk.
     */
    public function generatePdf($id)
    {
        try {
            // Cari produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Gunakan barcode sebagai data QR code
            $data = $product->barcode;
            $harga = $product->price;

            // Generate QR code dalam format PNG
            $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($data));

            // Load view PDF dengan data yang diperlukan
            $pdf = PDF::loadView('products.qrcode_pdf', compact('product', 'qrCode', 'data', 'harga'));

            // Unduh PDF dengan nama file yang aman
            return $pdf->download('qr-code-product-' . Str::slug($product->name) . '.pdf');
        } catch (\Exception $e) {
            // Tangani error dan kembalikan pesan error
            return redirect()->back()->with('error', 'Gagal menghasilkan PDF: ' . $e->getMessage());
        }
    }
}
