<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomingProductResource\Pages;
use App\Filament\Resources\IncomingProductResource\RelationManagers;
use App\Models\IncomingProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomingProductResource extends Resource
{
    protected static ?string $model = IncomingProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    // protected static ?string $navigationLabel = 'Barang Masuk';
    protected static ?string $navigationGroup = 'Manajemen Gudang';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')
                ->label('Produk')
                ->relationship('product', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('supplier_id')
                ->relationship('supplier', 'company_name')
                ->searchable(),

            Forms\Components\TextInput::make('quantity')
                ->label('Qty')
                ->numeric()
                ->minValue(1)
                ->required(),

            Forms\Components\DatePicker::make('date_in')
                ->label('Tanggal Barang Masuk')
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Keterangan')
                ->rows(5)
                ->columnSpanFull()
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('product.name')
                ->label('Produk'),
            Tables\Columns\TextColumn::make('supplier.company_name')
                ->label('Nama Supplier'),
            Tables\Columns\TextColumn::make('quantity')
                ->label('Qty'),
            Tables\Columns\TextColumn::make('date_in')
                ->label('Tanggal Masuk')
                ->date(),
            Tables\Columns\TextColumn::make('description')
                ->label('Keterangan'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomingProducts::route('/'),
            'create' => Pages\CreateIncomingProduct::route('/create'),
            'edit' => Pages\EditIncomingProduct::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();

        if ($locale == 'id') {
            return 'Barang Masuk';
        } else {
            return 'Input Product';
        }
    }
}
