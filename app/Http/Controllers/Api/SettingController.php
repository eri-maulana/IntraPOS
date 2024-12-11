<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        if($setting){
            return response()->json([
                "success" => true,
                "message" => "Sukses Menampilkan Data",
                "data" => $setting,
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Pengaturan toko tidak ditemukan",
            "data" => null,
        ], 404);
    }
}
