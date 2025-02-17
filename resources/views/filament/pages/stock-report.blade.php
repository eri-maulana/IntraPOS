<x-filament::page>
    <div class="space-y-6">

        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-2 text-center">#</th>
                        <th class="px-4 py-2 text-start">Nama Produk</th>
                        <th class="px-4 py-2 text-start">Kategori</th>
                        <th class="px-4 py-2 text-center">Stok</th>
                        <th class="px-4 py-2 text-start">Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($products as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-start">{{ $product->name }}</td>
                            <td class="px-4 py-2 text-start">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-center">{{ $product->stock }}</td>
                            <td class="px-4 py-2 text-start">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>
