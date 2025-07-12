<?php

namespace App\Filament\Resources\IncomingProductResource\Pages;

use App\Filament\Resources\IncomingProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomingProducts extends ListRecords
{
    protected static string $resource = IncomingProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
