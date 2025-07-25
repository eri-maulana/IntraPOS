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
    protected static ?string $navigationLabel = null;    
    // protected static ?string $title = 'Laporan Barang Keluar';
    protected static ?int $navigationSort = 3;


    // Properti untuk menyimpan tanggal filter dan data transaksi
    public $start_date ;
    public $end_date;
    public $orders = [];
    public $no = 1;

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

    public function getTableQuery()
    {
        $start = $this->form->getState('start_date');
        $end   = $this->form->getState('end_date');

        return Order::query()
            ->with('orderProducts.product')
            ->with('paymentMethod.name')
            ->when($start, fn($query, $start) => $query->whereDate('created_at', '>=', $start))
            ->when($end, fn($query, $end) => $query->whereDate('created_at', '<=', $end));
    }

    // Method untuk memuat data transaksi berdasarkan filter tanggal
    public function loadData()
    {
        $this->orders = Order::query()
            ->with('orderProducts.product')
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

    //function label sesuai role
    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();
        $user = auth()->user();

        // Default label
        $labelId = 'Laporan Barang Keluar';
        $labelEn = 'Output Product Report';

        // Cek jika user memiliki role super_admin
        if ($user && $user->hasRole('super_admin')) {
            $labelId = 'Laporan Pesanan';
            $labelEn = 'Order Report';
        }

        return $locale === 'id' ? $labelId : $labelEn;
    }

    //function navigasi label sesuai role
    public static function getNavigationLabel(): string
    {
        $locale = app()->getLocale();
        $user = auth()->user();

        if ($user && $user->hasRole(['super_admin', 'kasir'])) {
            return $locale === 'id' ? 'Laporan Pesanan' : 'Order Report';
        }

        return $locale === 'id' ? 'Laporan Barang Keluar' : 'Output Product Report';
    }
}
