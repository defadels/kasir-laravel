<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏷️ Manajemen Kategori
            </h2>
            @can('create-categories')
                <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Tambah Kategori
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Total Kategori</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $categories->total() }}</p>
                            </div>
                            <div class="text-blue-500 text-2xl">🏷️</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $categories->sum(function($category) { return $category->products->count(); }) }}</p>
                            </div>
                            <div class="text-green-500 text-2xl">📦</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Kategori Aktif</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                            </div>
                            <div class="text-purple-500 text-2xl">✅</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('categories.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama kategori..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Buttons -->
                        <div class="md:col-span-2 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                🔍 Cari
                            </button>
                            <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                🔄 Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Deskripsi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Produk
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dibuat
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($categories as $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-12 w-12">
                                                        @if($category->image)
                                                            <img class="h-12 w-12 rounded-lg object-cover" 
                                                                 src="{{ asset('storage/' . $category->image) }}" 
                                                                 alt="{{ $category->name }}">
                                                        @else
                                                            <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                                🏷️
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $category->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $category->description ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $category->products->count() }} produk
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $category->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    @can('view-categories')
                                                        <a href="{{ route('categories.show', $category) }}" 
                                                           class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                            👁️
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('edit-categories')
                                                        <a href="{{ route('categories.edit', $category) }}" 
                                                           class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                            ✏️
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('delete-categories')
                                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" 
                                                              class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
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
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">🏷️</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada kategori</h3>
                            <p class="text-gray-500 mb-6">Belum ada kategori yang dibuat.</p>
                            @can('create-categories')
                                <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    ➕ Tambah Kategori Pertama
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 