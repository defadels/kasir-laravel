<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Detail Produk
            </h2>
            <div class="flex space-x-2">
                @can('edit-products')
                    <a href="{{ route('products.edit', $product) }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ✏️ Edit
                    </a>
                @endcan
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Gambar dan Info Dasar -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Gambar Produk -->
                            <div class="mb-6">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-64 object-cover rounded-lg">
                                @else
                                    <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <span class="text-6xl">📦</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Info Dasar -->
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Kategori:</span>
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ $product->category->name }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status:</span>
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full 
                                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? '✅ Aktif' : '❌ Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Tengah: Detail Produk -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Produk</h3>
                            
                            <div class="space-y-4">
                                <!-- Harga -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Harga Jual</h4>
                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                @if($product->cost_price)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Harga Modal</h4>
                                        <p class="text-lg font-semibold text-gray-900">
                                            Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Deskripsi -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Deskripsi</h4>
                                    <p class="text-gray-600 mt-1">
                                        {{ $product->description ?? 'Tidak ada deskripsi' }}
                                    </p>
                                </div>

                                <!-- Tanggal -->
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span class="text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm mt-2">
                                        <span class="text-gray-600">Diupdate:</span>
                                        <span class="text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Stok -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Stok</h3>
                            
                            @if($product->track_stock)
                                <div class="space-y-4">
                                    <!-- Status Stok -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Status Stok</h4>
                                        <div class="mt-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-2xl font-bold 
                                                    {{ $product->stock <= 0 ? 'text-red-600' : 
                                                       ($product->stock <= $product->min_stock ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ $product->stock }}
                                                </span>
                                                <span class="text-sm text-gray-500">{{ $product->unit }}</span>
                                            </div>
                                            @if($product->stock <= $product->min_stock)
                                                <p class="mt-1 text-sm font-medium
                                                    {{ $product->stock <= 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                                    {{ $product->stock <= 0 ? '⚠️ Stok Habis' : '⚠️ Stok Rendah' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Stok Minimum -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Stok Minimum</h4>
                                        <p class="text-lg font-semibold text-gray-900 mt-1">
                                            {{ $product->min_stock }} {{ $product->unit }}
                                        </p>
                                    </div>

                                    @can('manage-stock')
                                        <!-- Tombol Kelola Stok -->
                                        <div class="pt-4 mt-4 border-t border-gray-200">
                                            <button onclick="showStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})"
                                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                📊 Kelola Stok
                                            </button>
                                        </div>
                                    @endcan
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <span class="text-4xl">∞</span>
                                    <p class="mt-2 text-sm text-gray-600">Stok tidak dimonitor</p>
                                </div>
                            @endif

                            <!-- Riwayat Transaksi -->
                            @if($product->transactionDetails->count() > 0)
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Riwayat Transaksi Terakhir</h4>
                                    <div class="space-y-3">
                                        @foreach($product->transactionDetails->take(5) as $detail)
                                            <div class="flex justify-between items-center text-sm">
                                                <div>
                                                    <p class="text-gray-900">{{ $detail->quantity }} {{ $product->unit }}</p>
                                                    <p class="text-gray-500">{{ $detail->transaction->transaction_date->format('d/m/Y H:i') }}</p>
                                                </div>
                                                <span class="font-medium text-gray-900">
                                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 