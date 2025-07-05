<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ Edit Produk
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-6">
                            <!-- Nama Produk -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $product->name) }}"
                                       required
                                       class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama produk">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                                    SKU <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="sku" 
                                       name="sku" 
                                       value="{{ old('sku', $product->sku) }}"
                                       required
                                       class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('sku') border-red-500 @enderror"
                                       placeholder="Masukkan SKU produk">
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" 
                                        name="category_id" 
                                        required
                                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Deskripsi
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="4"
                                          class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                          placeholder="Masukkan deskripsi produk">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
                            <!-- Harga -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Harga Jual <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        Rp
                                    </span>
                                    <input type="number" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', $product->price) }}"
                                           required
                                           min="0"
                                           class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Modal -->
                            <div>
                                <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Harga Modal
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        Rp
                                    </span>
                                    <input type="number" 
                                           id="cost_price" 
                                           name="cost_price" 
                                           value="{{ old('cost_price', $product->cost_price) }}"
                                           min="0"
                                           class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('cost_price') border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                @error('cost_price')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock Management -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="track_stock" 
                                           name="track_stock"
                                           value="1"
                                           {{ old('track_stock', $product->track_stock) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="track_stock" class="ml-2 block text-sm text-gray-700">
                                        Monitor Stok
                                    </label>
                                </div>

                                <div id="stock-fields" class="space-y-4 {{ old('track_stock', $product->track_stock) ? '' : 'hidden' }}">
                                    <div>
                                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                                            Stok
                                        </label>
                                        <div class="flex space-x-2">
                                            <input type="number" 
                                                   id="stock" 
                                                   name="stock" 
                                                   value="{{ old('stock', $product->stock) }}"
                                                   min="0"
                                                   class="flex-1 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stock') border-red-500 @enderror">
                                            <input type="text" 
                                                   id="unit" 
                                                   name="unit" 
                                                   value="{{ old('unit', $product->unit) }}"
                                                   class="w-20 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('unit') border-red-500 @enderror"
                                                   placeholder="Unit">
                                        </div>
                                        @error('stock')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                            Stok Minimum
                                        </label>
                                        <input type="number" 
                                               id="min_stock" 
                                               name="min_stock" 
                                               value="{{ old('min_stock', $product->min_stock) }}"
                                               min="0"
                                               class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('min_stock') border-red-500 @enderror">
                                        @error('min_stock')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Gambar -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                    Gambar Produk
                                </label>
                                
                                @if($product->image)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-32 w-32 object-cover rounded-lg border-2 border-gray-300">
                                    </div>
                                @endif

                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>{{ $product->image ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                    </div>
                                </div>
                                <div id="image-preview" class="mt-2 hidden">
                                    <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                                    <img id="preview" class="h-32 w-32 object-cover rounded-lg" alt="Preview">
                                </div>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Produk Aktif
                            </label>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end space-x-3">
                        <a href="{{ route('products.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview gambar
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Toggle stock fields
        document.getElementById('track_stock').addEventListener('change', function() {
            const stockFields = document.getElementById('stock-fields');
            if (this.checked) {
                stockFields.classList.remove('hidden');
            } else {
                stockFields.classList.add('hidden');
            }
        });
    </script>
</x-app-layout> 