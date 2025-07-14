<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class PosPages extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-m-qr-code';

    protected static string $view = 'filament.pages.pos-pages';

    protected static ?string $navigationGroup = 'Data Transaksi';

    protected static ?string $navigationLabel = 'POS';
    
    protected static ?string $title = 'POS';

    protected function getShieldRedirectPath(): string {
        return '/'; // redirect to the root index...
    }
}
