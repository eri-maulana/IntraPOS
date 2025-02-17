<x-filament::page>
    <div class="space-y-6">
        <form wire:submit.prevent="filter" class="p-6 rounded-lg shadow-sm w-full space-y-4">
            <div class="">
                {{ $this->form }}
            </div>

            <div class="flex justify-end">
                <x-filament::button type="submit"
                    class="bg-primary-500 hover:bg-primary-700  font-bold py-2 px-4 rounded center">
                    Tampilkan
                </x-filament::button>
            </div>
        </form>

        <x-filament::card>
            <div class=" rounded-lg shadow-sm p-6">
                <table class="table w-full border-collapse overflow-hidden">
                    <thead class="bg-slate-400">
                        <tr class=" uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-center border">No. </th>
                            <th class="py-3 px-6 text-center border">IDT</th>
                            <th class="py-3 px-6 text-center border">Tanggal</th>
                            <th class="py-3 px-6 text-left border">Nama </th>
                            <th class="py-3 px-6 text-left border">Produk Dipesan</th>
                            <th class="py-3 px-6 text-center border">Metode Pembayaran </th>
                            <th class="py-3 px-6 text-center border">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @forelse($orders as $order)
                            <tr class=" border">
                                <td class="py-3 text-center px-6 border">{{ $no++ }}</td>
                                <td class="py-3 text-center px-6 border">{{ $order->id }}</td>
                                <td class="py-3 text-center px-6 border">
                                    {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</td>
                                <td class="py-3 text-left px-6 truncate border">{{ $order->name }}</td>
                                <td class="py-3 text-left px-6 border">
                                    @foreach ($order->orderProducts as $orderProduct)
                                        - {{ $orderProduct->product->name }} ({{ $orderProduct->quantity }})<br>
                                    @endforeach
                                </td>
                                <td class="py-3 text-center px-6 border">{{ $order->paymentMethod->name }}</td>
                                <td class="py-3 text-center px-6 border">
                                    {{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4 px-6 text-center" colspan="8">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </x-filament::card>

        <div class="mt-4 text-center">
            <x-filament::button wire:click="printReport"
                class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                Cetak Laporan
            </x-filament::button>
        </div>
    </div>
</x-filament::page>
