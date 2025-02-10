<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Filament\Forms\Form;

class TransactionReport extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    // Icon dan view untuk menu navigasi Filament
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static string $view = 'filament.pages.transaction-report';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Transaksi';    
    protected static ?string $title = 'Laporan Transaksi';


    // Properti untuk menyimpan tanggal filter dan data transaksi
    public $start_date;
    public $end_date;
    public $orders = [];

    public function mount(): void
    {
        // Inisialisasi filter dengan tanggal awal bulan dan hari ini
        $this->start_date = Carbon::now()->startOfMonth()->toDateString();
        $this->end_date = Carbon::now()->toDateString();

        // Load data transaksi awal
        $this->loadData();
    }

    // Definisikan form filter dengan dua date picker
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start_date')
                    ->label('Tanggal Awal')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Tanggal Akhir')
                    ->required(),
            ])->columns(2);
    }
    // protected function getFormSchema(): array
    // {
    //     return [

    //         DatePicker::make('start_date')
    //             ->label('Tanggal Awal')
    //             ->required(),
    //         DatePicker::make('end_date')
    //             ->label('Tanggal Akhir')
    //             ->required(),

    //     ];
    // }


    // Method untuk memuat data transaksi berdasarkan filter tanggal
    public function loadData()
    {
        $this->orders = Order::query()
            ->whereDate('created_at', '>=', $this->start_date)
            ->whereDate('created_at', '<=', $this->end_date)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Method yang dipanggil saat form disubmit (filter data)
    public function filter()
    {
        $this->loadData();
    }

    // Method untuk mencetak laporan (contoh: meng-generate PDF)
    public function printReport()
    {
        $orders = Order::query()
            ->whereDate('created_at', '>=', $this->start_date)
            ->whereDate('created_at', '<=', $this->end_date)
            ->get();

        // Pastikan package barryvdh/laravel-dompdf sudah terinstall
        $pdf = PDF::loadView('pdf.transaction-report', [
            'orders'     => $orders,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
        ]);

        return response()->streamDownload(fn() => print($pdf->output()), 'laporan-transaksi.pdf');
    }
}
