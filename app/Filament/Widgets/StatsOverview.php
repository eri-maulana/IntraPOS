<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;
use App\Models\IncomingProduct;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;
    protected int | array $columns = [
        'default' => 7,
        'sm' => 7,
        'md' => 7,
        'lg' => 7,
        'xl' => 7, // tampil sejajar 1 baris
    ];

    protected function getStats(): array
    {
        $product_count = Product::count();
        $order_count = Order::count();
        $omset = Order::sum('total_price');
        $expenset = Expense::sum('amount');
        $incoming_product = IncomingProduct::count();
        $supplier = Supplier::count();
        $customer = Customer::count();
        $category = Category::count();
        $pengguna = User::count();

        $user = auth()->user();

        if ($user && $user->hasAnyRole(['super_admin', 'kasir'])) {
            return [
                Stat::make('Produk', $product_count),
                Stat::make('Pesanan', $order_count),
                Stat::make('Omset', 'Rp ' . number_format($omset, 0, ',', '.')),
                Stat::make('Pengeluaran', 'Rp ' . number_format($expenset, 0, ',', '.')),

            ];
        } else {
            return [
                Stat::make('Produk', $product_count),
                Stat::make('Barang Keluar', $order_count),
                Stat::make('Suplier', $supplier),
                Stat::make('Kategori Produk', $category),
                Stat::make('Barang Masuk', $incoming_product),
                Stat::make('Customer', $customer),
            ];
        }
    }
}
