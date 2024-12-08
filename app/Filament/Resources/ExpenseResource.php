<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Expense;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\ExpenseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ExpenseResource\RelationManagers;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-down';

    protected static ?string $navigationGroup = 'Lainnya';

    // protected static ?string $navigationLabel = 'Pengeluaran';

    // protected ?string $heading = 'Pengeluaran';

    // protected static ?string $title = 'Pengeluaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->label('Nama'),
                Forms\Components\Textarea::make('note')
                    ->required()
                    ->columnSpanFull()
                    ->label('Catatan'),
                Forms\Components\DatePicker::make('date_expense')
                    ->required()
                    ->label('Tanggal Pengeluaran'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->label('Jumlah Pengeluaran')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->label('Jumlah Pengeluaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_expense')
                    ->date()
                    ->label('Tanggal Pengeluaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal dibuat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diubah pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->label('Dihapus pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {

        $locale = app()->getLocale();

        if ($locale == 'id') {
            return 'Pengeluaran';
        } else {
            return 'Expense';
        }
    }
}
