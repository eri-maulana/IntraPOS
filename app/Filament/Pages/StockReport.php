<?php

namespace App\Filament\Pages;

use App\Models\Product;
use Filament\Pages\Page;
use Filament\Pages\Actions\Action;

class StockReport extends Page
{
    // Ikon sidebar (ubah sesuai preferensi)
    protected static ?string $navigationIcon = 'heroicon-o-document';
    
    // View yang digunakan untuk menampilkan halaman
    protected static string $view = 'filament.pages.stock-report';
    // protected static ?string $maxContentWidth = 'full';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Stok Produk';    
    protected static ?string $title = 'Laporan Stok Produk';
    protected static ?int $navigationSort = 1;

    public $products;

    public function mount(): void
    {
        // Mengambil data produk beserta relasi kategori dan mengurutkannya berdasarkan stok (ascending)
        $this->products = Product::with('category')->orderBy('stock', 'asc')->get();
    }

    protected function getActions(): array
    {
        return [
            Action::make('Export PDF')
                ->label('Download PDF')
                ->url(route('report.stock')) // Pastikan route ini mengarah ke controller yang meng-generate PDF
                ->openUrlInNewTab(), // Membuka di tab baru
        ];
    }
}
