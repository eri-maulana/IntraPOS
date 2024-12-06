<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PosPages extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pos-pages';

    protected static ?string $navigationGroup = 'Data Transaksi';
}
