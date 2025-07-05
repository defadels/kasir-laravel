<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏷️ Detail Kategori
            </h2>
            <div class="flex space-x-2">
                @can('edit-categories')
                    <a href="{{ route('categories.edit', $category) }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ✏️ Edit
                    </a>
                @endcan
                <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Category Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <!-- Category Image -->
                        <div class="md:w-1/3 mb-4 md:mb-0">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-full h-48 object-cover rounded-lg border-2 border-gray-300">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-6xl">🏷️</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Category Details -->
                        <div class="md:w-2/3 md:pl-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h3>
                                <div class="flex space-x-2">
                                    @can('delete-categories')
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" 
                                              class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Deskripsi:</span>
                                    <p class="text-gray-800">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Jumlah Produk:</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $category->products->count() }} produk
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Dibuat:</span>
                                    <span class="text-gray-800">{{ $category->created_at->format('d F Y H:i') }}</span>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Terakhir diupdate:</span>
                                    <span class="text-gray-800">{{ $category->updated_at->format('d F Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products in this Category -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Produk dalam Kategori ini</h3>
                        @can('create-products')
                            <a href="{{ route('products.create', ['category' => $category->id]) }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                ➕ Tambah Produk
                            </a>
                        @endcan
                    </div>

                    @if($category->products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($category->products as $product)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition duration-200">
                                    <div class="flex items-center mb-3">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg mr-3">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                                📦
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $product->sku }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Harga:</span>
                                            <span class="font-semibold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Stok:</span>
                                            <span class="font-semibold {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-blue-600' }}">
                                                {{ $product->stock }} {{ $product->unit }}
                                            </span>
                                        </div>
                                        
                                        @if($product->stock <= $product->min_stock)
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-1 rounded text-xs">
                                                ⚠️ Stok rendah!
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-4 flex justify-end space-x-2">
                                        @can('view-products')
                                            <a href="{{ route('products.show', $product) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                👁️
                                            </a>
                                        @endcan
                                        @can('edit-products')
                                            <a href="{{ route('products.edit', $product) }}" 
                                               class="text-indigo-600 hover:text-indigo-800 text-sm">
                                                ✏️
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">📦</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                            <p class="text-gray-500 mb-6">Belum ada produk dalam kategori ini.</p>
                            @can('create-products')
                                <a href="{{ route('products.create', ['category' => $category->id]) }}" 
                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    ➕ Tambah Produk Pertama
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 