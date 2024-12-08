<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Products;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-m-tag';



    protected static ?string $cluster = Products::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->maxLength(50)
                    ->afterStateUpdated(function (Set $set, $state){
                        $set('slug', Product::generateUniqueSlug($state));
                    })
                    ->live(onBlur: true),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->readOnly()
                    ->maxLength(100),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->label('Stok')
                    ->default(1),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->label('Harga')
                    ->prefix('Rp'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Status Aktif'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label('Gambar'),
                Forms\Components\TextInput::make('barcode')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                ->label('Gambar'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable()
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->label('Stok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status Aktif'),
                
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string 
    {

        $locale = app()->getLocale();

        if($locale == 'id'){
            return 'Produk';
        } else {
            return 'Product';
        }
    }
}
