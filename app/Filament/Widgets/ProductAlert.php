<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Product;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductAlert extends BaseWidget
{
    protected static ?string $heading = 'Produk Hampir Habis';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()->where('stock', '<=', '10')->orderBy('stock', 'asc')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\BadgeColumn::make('stock')
                    ->label('Stok')
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->color(static function ($state): string {
                        if($state < 5){
                            return 'danger';
                        } elseif ($state <= 10){
                            return 'warning';
                        }
                    })
                    ->sortable(),
            ])
            ->defaultPaginationPageOption(5);
    }
}
