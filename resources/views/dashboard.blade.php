<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }} - {{ auth()->user()->hasRole('owner') ? 'Owner' : 'Kasir' }}
            </h2>
            <div class="flex space-x-2">
                @can('access-pos')
                    <a href="{{ route('pos.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        🛒 Kasir POS
                    </a>
                @endcan
                @can('view-products')
                    <a href="{{ route('products.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        📦 Produk
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Today Sales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Penjualan Hari Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="today-sales">
                                    Rp {{ number_format($salesSummary['today']['sales'], 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $salesSummary['today']['transactions'] }} transaksi</p>
                            </div>
                            <div class="text-blue-500">
                                💰
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Week Sales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Penjualan Minggu Ini</h3>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($salesSummary['this_week']['sales'], 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $salesSummary['this_week']['transactions'] }} transaksi</p>
                            </div>
                            <div class="text-green-500">
                                📈
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
                                <p class="text-2xl font-bold text-gray-900" id="total-products">
                                    {{ $stockOverview['total_products'] }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $stockOverview['categories'] }} kategori</p>
                            </div>
                            <div class="text-purple-500">
                                📦
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Alert -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Stok Rendah/Habis</h3>
                                <p class="text-2xl font-bold text-gray-900" id="low-stock-count">
                                    {{ $stockOverview['low_stock'] + $stockOverview['out_of_stock'] }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $stockOverview['out_of_stock'] }} habis, {{ $stockOverview['low_stock'] }} rendah
                                </p>
                            </div>
                            <div class="text-red-500">
                                ⚠️
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                            @can('view-transactions')
                                <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Lihat Semua →
                                </a>
                            @endcan
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($recentTransactions as $transaction)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-sm text-gray-900">
                                                {{ $transaction->transaction_code }}
                                            </span>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ $transaction->transaction_date->format('d/m/Y H:i') }} - 
                                            {{ $transaction->user->name }}
                                        </p>
                                        @if($transaction->customer_name)
                                            <p class="text-xs text-gray-500">Customer: {{ $transaction->customer_name }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">
                                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $transaction->details->sum('quantity') }} item
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada transaksi hari ini</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Peringatan Stok</h3>
                            @can('view-products')
                                <a href="{{ route('products.index') }}?low_stock=1" class="text-red-600 hover:text-red-800 text-sm">
                                    Lihat Semua →
                                </a>
                            @endcan
                        </div>
                        
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @forelse($lowStockProducts as $product)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-sm text-gray-900">
                                                {{ $product->name }}
                                            </span>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                {{ $product->stock === 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $product->stock === 0 ? 'Habis' : 'Rendah' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            SKU: {{ $product->sku }} | {{ $product->category->name }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium {{ $product->stock === 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                            {{ $product->stock }} / {{ $product->min_stock }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $product->unit }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-green-600 text-center py-4">✅ Semua produk stok aman</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products & Sales Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Selling Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terlaris (Bulan Ini)</h3>
                        
                        <div class="space-y-3">
                            @forelse($topProducts as $index => $product)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-bold text-blue-600">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $product->product_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->total_sold }} terjual</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada data penjualan bulan ini</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sales Trend -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tren Penjualan (7 Hari Terakhir)</h3>
                        
                        <div class="space-y-2">
                            @php $maxSales = collect($salesTrend)->max('sales') @endphp
                            @foreach($salesTrend as $day)
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 text-xs text-gray-500">{{ $day['date'] }}</div>
                                    <div class="flex-1">
                                        <div class="bg-gray-200 rounded-full h-4 relative">
                                            <div class="bg-blue-500 h-4 rounded-full" 
                                                 style="width: {{ $maxSales > 0 ? ($day['sales'] / $maxSales) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="w-20 text-xs text-gray-900 text-right">
                                        Rp {{ number_format($day['sales'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Akses Cepat</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @can('access-pos')
                            <a href="{{ route('pos.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <div class="text-2xl mb-2">🛒</div>
                                <span class="text-sm font-medium text-blue-700">Kasir POS</span>
                            </a>
                        @endcan
                        
                        @can('view-products')
                            <a href="{{ route('products.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <div class="text-2xl mb-2">📦</div>
                                <span class="text-sm font-medium text-green-700">Produk</span>
                            </a>
                        @endcan
                        
                        @can('view-transactions')
                            <a href="{{ route('transactions.index') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                <div class="text-2xl mb-2">📊</div>
                                <span class="text-sm font-medium text-purple-700">Transaksi</span>
                            </a>
                        @endcan
                        
                        @can('view-categories')
                            <a href="{{ route('categories.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                <div class="text-2xl mb-2">🏷️</div>
                                <span class="text-sm font-medium text-yellow-700">Kategori</span>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh dashboard data every 30 seconds
        setInterval(function() {
            fetch('{{ route("dashboard.data") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('today-sales').textContent = 
                        'Rp ' + new Intl.NumberFormat('id-ID').format(data.today_sales);
                    document.getElementById('total-products').textContent = data.total_products || '0';
                    document.getElementById('low-stock-count').textContent = 
                        (data.low_stock_count + data.out_of_stock_count);
                })
                .catch(error => console.log('Error refreshing dashboard:', error));
        }, 30000);
    </script>
</x-app-layout>
