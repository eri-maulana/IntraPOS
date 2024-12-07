<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductResource;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importProducts')
                ->label('Import Product')
                ->icon('heroicon-s-arrow-down-tray')
                ->color('gray')
                ->form([
                    FileUpload::make('attachments')
                        ->label('Upload Template Produk'),
                ]),
            Action::make("Download Template")
                ->url(route('download-template'))
                ->color('info'),
            Actions\CreateAction::make(),
        ];
    }
}
