<div class="grid grid-cols-1 dark:bg-gray-900 md:grid-cols-3 gap-4">
    <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <!-- Input Pencarian dan Tombol Scan QR -->
        <div class="mb-4 flex gap-2 relative">
            <input wire:model.live.debounce.100ms='search' type="text" placeholder="Cari produk..."
                class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 pr-10"
                id="searchInput">
            <!-- Tombol "x" untuk menghapus teks -->
            @if ($search)
                <button type="button" wire:click="$set('search', '')"
                    class=" left-12 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @endif
            <!-- Tombol Scan QR -->
            <button type="button" id="startScan" class="p-2 border rounded-lg  transition-colors">
                Scan QR
            </button>
        </div>

        <!-- Modal Scanner -->
        <div id="qr-reader" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <!-- Tombol Close untuk modal -->
                <button type="button" id="closeScan"
                    class=" top-2 right-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <!-- Tempat untuk menampilkan scanner -->
                <div id="qr-reader-container" class="w-full"></div>
            </div>
        </div>

        <!-- Bagian produk tetap sama -->
        <div class="flex-grow">
            <div class="grid grid-cols-8 sm:grid-cols-3 md:grid-cols-8 lg:grid-cols- gap-4">
                @foreach ($products as $item)
                    <div wire:click="addToOrder({{ $item->id }})"
                        class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow cursor-pointer">
                        <img src="{{ $item->image_url }}" alt="Product Image"
                            class="w-full h-16 object-cover rounded-lg mb-2">
                        <h3 class="text-sm font-semibold">{{ $item->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Rp.
                            {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Stok: {{ $item->stock }}</p>
                    </div>
                @endforeach
            </div>
            <div class="py-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Bagian keranjang dan checkout tetap sama -->
    <div class="md:col-span-1 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        @if (count($order_items) > 0)
            <div class="py-4">
                <h3 class="text-lg font-semibold text-center">Total: Rp
                    {{ number_format($this->calculateTotal(), 0, ',', '.') }}</h3>
            </div>
        @endif
        @foreach ($order_items as $item)
            <div class="mb-4">
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <img src="{{ $item['image_url'] }}" alt="Product Image"
                            class="w-10 h-10 object-cover rounded-lg mr-2">
                        <div class="px-2">
                            <h3 class="text-sm font-semibold">{{ $item['name'] }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-xs">Rp
                                {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <x-filament::button color="warning"
                            wire:click="decreaseQuantity({{ $item['product_id'] }})">-</x-filament::button>
                        <span class="px-4">{{ $item['quantity'] }}</span>
                        <x-filament::button color="success"
                            wire:click="increaseQuantity({{ $item['product_id'] }})">+</x-filament::button>
                    </div>
                </div>
            </div>
        @endforeach
        <form wire:submit="checkout">
            {{ $this->form }}
            <x-filament::button type="submit" class="w-full mt-3 text-white py-2 rounded">Checkout</x-filament::button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const startScanBtn = document.getElementById('startScan');
        const qrReaderModal = document.getElementById('qr-reader');
        const closeScanBtn = document.getElementById('closeScan');
        const searchInput = document.getElementById('searchInput');
        let html5QrCode = null;

        // Fungsi untuk membuka modal scanner
        startScanBtn.addEventListener('click', () => {
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("qr-reader-container");
            }

            qrReaderModal.classList.remove('hidden');

            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };

            html5QrCode.start({
                    facingMode: "environment"
                }, // Gunakan kamera belakang
                config,
                (decodedText) => {
                    // Set nilai hasil scan ke input pencarian
                    searchInput.value = decodedText;
                    // Trigger Livewire untuk update pencarian
                    searchInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));

                    // Stop scanner dan tutup modal
                    html5QrCode.stop();
                    qrReaderModal.classList.add('hidden');
                },
                (errorMessage) => {
                    console.log(errorMessage);
                }
            ).catch((err) => {
                console.error("Error starting scanner:", err);
                qrReaderModal.classList.add('hidden');
                alert('Gagal mengakses kamera. Pastikan izin kamera diberikan.');
            });
        });

        // Fungsi untuk menutup modal scanner
        closeScanBtn.addEventListener('click', () => {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop();
            }
            qrReaderModal.classList.add('hidden');
        });
    });
</script>
