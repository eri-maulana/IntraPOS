<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
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
                    FileUpload::make('attachment')
                        ->label('Upload Template Produk'),
                ])
                ->action(function (array $data) {
                    $file = public_path('storage/'. $data['attachment']);

                    try {
                        Excel::import(new ProductImport, $file);
                        Notification::make()
                            ->title('Product imported')
                            ->success()
                            ->send();
                    } catch(\Exception $e) {
                        dd($e);
                        Notification::make()
                                ->title('Product failed to import')
                                ->danger()
                                ->send();
                    }
                }),
            Action::make("Download Template")
                ->url(route('download-template'))
                ->color('info'),
            Actions\CreateAction::make(),
        ];
    }
}
