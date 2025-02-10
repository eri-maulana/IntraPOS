<div class="space-y-6">
    <!-- Filter Form -->
    <form wire:submit.prevent="filter" class=" rounded-lg p-6 shadow">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex-1">
                {{ $this->form }}
            </div>
            
            <div class="flex space-x-2">
                <!-- Tombol Filter -->
                <button
                  type="submit"
                  class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                    />
                  </svg>
                  Filter
                </button>
              
                <!-- Tombol Cetak -->
                <button
                  type="button"
                  wire:click="print"
                  class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 border border-transparent rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-400 transition"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 17h-5a2 2 0 01-2-2V5a2 2 0 012-2h5a2 2 0 012 2v10a2 2 0 01-2 2z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 21h6"
                    />
                  </svg>
                  Cetak
                </button>
              </div>
              
        </div>
    </form>

    <!-- Tabel Order -->
    <div class=" rounded-lg shadow overflow-hidden">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Nama Pelanggan</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Telepon</th>
                        <th class="px-6 py-3">Total Harga</th>
                        <th class="px-6 py-3">Dibayar</th>
                        <th class="px-6 py-3">Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class=" border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $order->name }}</td>
                            <td class="px-6 py-4">{{ $order->email }}</td>
                            <td class="px-6 py-4">{{ $order->phone }}</td>
                            <td class="px-6 py-4">@money($order->total_price)</td>
                            <td class="px-6 py-4">@money($order->paid_amount)</td>
                            <td class="px-6 py-4">@money($order->change_amount)</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data untuk ditampilkan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>