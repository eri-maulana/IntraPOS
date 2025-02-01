<?php

use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductQRCodeController;

Route::get('/download-template', function () {
    return Excel::download(new TemplateExport, 'template.xlsx');
})->name('download-template');


Route::get('/products/{product}/qrcode', [ProductQRCodeController::class, 'show'])
    ->name('products.qrcode');

Route::get('/products/{id}/generate-pdf', [ProductQRCodeController::class, 'generatePdf'])->name('products.generatePdf');
