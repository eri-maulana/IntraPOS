<x-filament::page>
    <div class="space-y-6">
        {{-- Form Filter --}}
        <form wire:submit.prevent="filter" class="p-6 rounded-lg shadow-sm w-full space-y-4">
            <div>
                {{ $this->form }}
            </div>

            <div class="flex justify-end">
                <x-filament::button type="submit"
                    class="bg-primary-500 hover:bg-primary-700 font-bold py-2 px-4 rounded center">
                    Tampilkan
                </x-filament::button>
            </div>
        </form>

        {{-- Tabel Transaksi --}}
        <x-filament::card>
            <div class="overflow-x-auto w-full p-4">
                <table class="w-full min-w-full border-collapse text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-center border">#</th>
                            <th class="py-3 px-4 text-center border">ID Transaksi</th>
                            <th class="py-3 px-4 text-center border">Tanggal</th>
                            <th class="py-3 px-4 text-left border">Nama</th>
                            <th class="py-3 px-4 text-left border">Produk Dipesan</th>
                            <th class="py-3 px-4 text-center border">Metode Pembayaran</th>
                            <th class="py-3 px-4 text-center border">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-center border">{{ $no++ }}</td>
                                <td class="py-3 px-4 text-center border">{{ $order->id }}</td>
                                <td class="py-3 px-4 text-center border">
                                    {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3 px-4 text-left border">
                                    {{ $order->name }}
                                </td>
                                <td class="py-3 px-4 text-left border">
                                    @foreach ($order->orderProducts as $orderProduct)
                                        - {{ $orderProduct->product->name }} ({{ $orderProduct->quantity }})<br>
                                    @endforeach
                                </td>
                                <td class="py-3 px-4 text-center border">
                                    {{ $order->paymentMethod->name }}
                                </td>
                                <td class="py-3 px-4 text-center border">
                                    {{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4 px-4 text-center border" colspan="7">
                                    Tidak ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::card>

        {{-- Tombol Cetak Laporan --}}
        <div class="mt-4 text-center">
            <x-filament::button wire:click="printReport"
                class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                Cetak Laporan
            </x-filament::button>
        </div>
    </div>
</x-filament::page>
