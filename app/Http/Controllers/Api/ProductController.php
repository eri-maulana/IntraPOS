<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index()
    {
        $product = Product::all();

        return response()->json([
            "success" => true,
            "message" => "Sukses",
            "data" => $product,
        ]);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    public function showByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => "Produk dengan barcode " . $barcode . " tidak ditemukan",
                "data" => null,
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Sukses",
            "data" => $product
        ]);
    }
}
