<?php

use App\Exports\TemplateExport;
use App\Http\Controllers\OrderController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductQRCodeController;
// use App\Http\Controllers\ReportController;

Route::get('/download-template', function () {
    return Excel::download(new TemplateExport, 'template.xlsx');
})->name('download-template');

// tampil halaman qr code
Route::get('/products/{product}/qrcode', [ProductQRCodeController::class, 'show'])
    ->name('products.qrcode');

// generate qrcode pdf
Route::get('/products/{id}/generate-pdf', [ProductQRCodeController::class, 'generatePdf'])->name('products.generatePdf');


Route::get('/order/{order}/print', [OrderController::class, 'print'])->name('print.struk');