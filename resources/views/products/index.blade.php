<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Manajemen Produk
            </h2>
            @can('create-products')
                <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Tambah Produk
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama produk atau SKU..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Category Filter -->
                        <div>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        
                        <!-- Stock Filter -->
                        <div>
                            <select name="low_stock" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Stok</option>
                                <option value="1" {{ request('low_stock') ? 'selected' : '' }}>Stok Rendah</option>
                            </select>
                        </div>
                        
                        <!-- Search Button -->
                        <div class="md:col-span-4 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                🔍 Cari
                            </button>
                            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                🔄 Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produk
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stok
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($products as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($product->image)
                                                            <img class="h-10 w-10 rounded object-cover" 
                                                                 src="{{ asset('storage/' . $product->image) }}" 
                                                                 alt="{{ $product->name }}">
                                                        @else
                                                            <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                                📦
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $product->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            SKU: {{ $product->sku }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $product->category->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-medium">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                                @if($product->cost_price)
                                                    <div class="text-sm text-gray-500">
                                                        Modal: Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($product->track_stock)
                                                    <div class="flex items-center">
                                                        <span class="text-sm font-medium 
                                                            {{ $product->stock <= 0 ? 'text-red-600' : 
                                                               ($product->isLowStock() ? 'text-yellow-600' : 'text-green-600') }}">
                                                            {{ $product->stock }} {{ $product->unit }}
                                                        </span>
                                                        @if($product->isLowStock())
                                                            <span class="ml-2 text-xs px-2 py-1 rounded-full 
                                                                {{ $product->stock <= 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                                {{ $product->stock <= 0 ? 'Habis' : 'Rendah' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Min: {{ $product->min_stock }} {{ $product->unit }}
                                                    </div>
                                                @else
                                                    <span class="text-sm text-blue-600">Unlimited</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    @can('view-products')
                                                        <a href="{{ route('products.show', $product) }}" 
                                                           class="text-blue-600 hover:text-blue-900">
                                                            👁️
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('edit-products')
                                                        <a href="{{ route('products.edit', $product) }}" 
                                                           class="text-indigo-600 hover:text-indigo-900">
                                                            ✏️
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('manage-stock')
                                                        @if($product->track_stock)
                                                            <button onclick="showStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})"
                                                                    class="text-green-600 hover:text-green-900">
                                                                📊
                                                            </button>
                                                        @endif
                                                    @endcan
                                                    
                                                    @can('delete-products')
                                                        <form action="{{ route('products.destroy', $product) }}" 
                                                              method="POST" 
                                                              class="inline"
                                                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                🗑️
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">📦</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk</h3>
                            <p class="text-gray-500 mb-4">
                                @if(request()->hasAny(['search', 'category', 'status', 'low_stock']))
                                    Tidak ada produk yang sesuai dengan filter yang dipilih.
                                @else
                                    Belum ada produk yang ditambahkan.
                                @endif
                            </p>
                            @can('create-products')
                                <a href="{{ route('products.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    ➕ Tambah Produk Pertama
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Management Modal -->
    <div id="stock-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">📊 Kelola Stok</h3>
                <button onclick="closeStockModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="stock-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                    <p id="product-name" class="text-gray-900 font-medium"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Saat Ini</label>
                    <p id="current-stock" class="text-gray-900 font-medium"></p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aksi</label>
                    <select name="action" id="stock-action" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="add">Tambah Stok</option>
                        <option value="subtract">Kurangi Stok</option>
                        <option value="set">Set Stok</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <input type="number" 
                           name="stock" 
                           min="0" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" 
                            onclick="closeStockModal()" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showStockModal(productId, productName, currentStock) {
            document.getElementById('product-name').textContent = productName;
            document.getElementById('current-stock').textContent = currentStock + ' unit';
            document.getElementById('stock-form').action = `/products/${productId}/stock`;
            document.getElementById('stock-modal').classList.remove('hidden');
            document.getElementById('stock-modal').classList.add('flex');
        }

        function closeStockModal() {
            document.getElementById('stock-modal').classList.add('hidden');
            document.getElementById('stock-modal').classList.remove('flex');
            document.getElementById('stock-form').reset();
        }
    </script>
</x-app-layout> 