<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Product;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductFavorite extends BaseWidget
{
    protected static ?string $heading = 'Produk Terlaris';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        $productQuery = Product::query()
            ->withCount('orderProducts')
            ->orderByDesc('order_products_count')
            ->take(10);
        return $table
            ->query($productQuery)
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('order_products_count')
                    ->label('Pesanan')
                    ->alignment(Alignment::Center),
            ])
            ->defaultPaginationPageOption(5);
    }
}
