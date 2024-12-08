<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $product_count = Product::count();
        $order_count = Order::count();
        $omset = Order::sum('total_price');
        $expenset = Expense::sum('amount');
        return [
            Stat::make('Produk', $product_count),
            Stat::make('Order', $order_count),
            Stat::make('Omset', 'Rp ' . number_format($omset,0, ',' , '.')),
            Stat::make('Pengeluaran', 'Rp ' . number_format($expenset,0, ',' , '.')),
            
        ];
    }
}
