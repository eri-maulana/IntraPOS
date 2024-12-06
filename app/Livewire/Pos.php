<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\Product;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\PaymentMethod;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class Pos extends Component implements HasForms
{
    use InteractsWithForms;
    public $search = '';
    public $nameCustomer = '';
    public $paymentMethods;

    public function render()
    {
        return view('livewire.pos', [
            'products' => Product::where('stock', '>', 0)
                                ->search($this->search)
                                ->paginate(9)
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Checkout')
                    ->schema([
                        TextInput::make('nameCustomer')
                            ->required()
                            ->maxLength(255)
                            ->default(fn () => $this->nameCustomer),
                        Select::make('gender')
                            ->options([
                                'male' => 'Laki - laki',
                                'female' => 'Perempuan'
                            ]),
                        TextInput::make('total_price'),
                        Select::make('payment_method_id')
                            ->required()
                            ->label('Metode Pemabayaran')
                            ->options($this->paymentMethods->pluck('name', 'id'))
                    ])
            ]);
    }
    public function mount()
    {
        $this->paymentMethods = PaymentMethod::all();
        $this->form->fill(['payment_methods', $this->paymentMethods]);
    }

}
