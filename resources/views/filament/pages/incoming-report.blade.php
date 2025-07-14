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
                            <th class="py-3 px-4 text-center border">ID Barang Masuk</th>
                            <th class="py-3 px-4 text-center border">Tanggal Masuk</th>
                            <th class="py-3 px-4 text-left border">Nama Produk</th>
                            <th class="py-3 px-4 text-left border">Qty</th>
                            <th class="py-3 px-4 text-left border">Nama Suplier</th>
                            <th class="py-3 px-4 text-center border">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($incomings as $incoming)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-center border">{{ $no++ }}</td>
                                <td class="py-3 px-4 text-center border">{{ $incoming->id }}</td>
                                <td class="py-3 px-4 text-center border">
                                    {{ \Carbon\Carbon::parse($incoming->date_in)->translatedFormat('d/m/Y') }}
                                </td>
                                <td class="py-3 px-4 text-left border">
                                    {{ $incoming->product->name }}
                                </td>
                                <td class="py-3 px-4 text-left border">
                                    {{ $incoming->quantity }}
                                </td>
                                <td class="py-3 px-4 text-left border">
                                    {{ $incoming->supplier->company_name }}
                                </td>
                                <td class="py-3 px-4 text-center border">
                                    {{ $incoming->description }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4 px-4 text-center border" colspan="7">
                                    Tidak ada data barang masuk.
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
