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
    public $name_customer = '';
    public $payment_methods;
    public $order_items = [];
    public $total_price;

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
                            ->default(fn() => $this->name_customer),
                        Select::make('gender')
                            ->options([
                                'male' => 'Laki - laki',
                                'female' => 'Perempuan'
                            ]),
                        TextInput::make('total_price'),
                        Select::make('payment_method_id')
                            ->required()
                            ->label('Metode Pemabayaran')
                            ->options($this->payment_methods->pluck('name', 'id'))
                    ])
            ]);
    }
    public function mount()
    {
        $this->payment_methods = PaymentMethod::all();
        $this->form->fill(['payment_methods', $this->payment_methods]);
    }

    public function addToOrder($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            if ($product->stock <= 0) {
                Notification::make()
                    ->title('Stok Habis')
                    ->danger()
                    ->send();
                return;
            }

            $existingItemKey = null;
            foreach ($this->order_items as $key => $item) {
                if ($item['product_id'] == $productId) {
                    $existingItemKey = $key;
                    break;
                }
            }

            if($existingItemKey !== null){
                $this->order_items[$existingItemKey]['quantity']++;
            } else {
                $this->order_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image_url' => $product->image_url,
                    'quantity' => 1,
                ];
            }

            session()->put('orderItems', $this->order_items);
            Notification::make()
                    ->title('Produk ditambahkan ke keranjang')
                    ->success()
                    ->send();
        }
    }

    public function loadOrderItems($orderItems)
    {
        $this->order_items = $orderItems;
        session()->put('orderItems', $orderItems);
    }
}
