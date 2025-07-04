<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Riwayat Transaksi
            </h2>
            <div class="flex space-x-2">
                @can('access-pos')
                    <a href="{{ route('pos.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        🛒 Kasir POS
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $summary['total_transactions'] }}</p>
                            </div>
                            <div class="text-blue-500 text-2xl">📊</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Total Penjualan</h3>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-green-500 text-2xl">💰</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-500">Total Item Terjual</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $summary['total_items'] }}</p>
                            </div>
                            <div class="text-purple-500 text-2xl">📦</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari kode transaksi atau customer..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Date From -->
                        <div>
                            <input type="date" 
                                   name="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Date To -->
                        <div>
                            <input type="date" 
                                   name="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Payment Method -->
                        <div>
                            <select name="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Metode Bayar</option>
                                <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>💵 Tunai</option>
                                <option value="card" {{ request('payment_method') === 'card' ? 'selected' : '' }}>💳 Kartu</option>
                                <option value="qris" {{ request('payment_method') === 'qris' ? 'selected' : '' }}>📱 QRIS</option>
                                <option value="transfer" {{ request('payment_method') === 'transfer' ? 'selected' : '' }}>🏦 Transfer</option>
                            </select>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="md:col-span-5 flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                🔍 Filter
                            </button>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                🔄 Reset
                            </a>
                            <button type="button" onclick="setDateToday()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                📅 Hari Ini
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Transaksi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Items
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pembayaran
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
                                    @foreach($transactions as $transaction)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $transaction->transaction_code }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $transaction->transaction_date->format('d/m/Y H:i') }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    Kasir: {{ $transaction->user->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($transaction->customer_name)
                                                    <div class="text-sm text-gray-900">{{ $transaction->customer_name }}</div>
                                                    @if($transaction->customer_phone)
                                                        <div class="text-sm text-gray-500">{{ $transaction->customer_phone }}</div>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-gray-400 italic">Customer umum</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-medium">
                                                    {{ $transaction->details->sum('quantity') }} item
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $transaction->details->count() }} produk berbeda
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-bold">
                                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                                </div>
                                                @if($transaction->discount_amount > 0)
                                                    <div class="text-sm text-red-600">
                                                        Diskon: Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                                @if($transaction->tax_amount > 0)
                                                    <div class="text-sm text-gray-500">
                                                        Pajak: Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-800' : 
                                                           ($transaction->payment_method === 'card' ? 'bg-blue-100 text-blue-800' :
                                                           ($transaction->payment_method === 'qris' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                                                        {{ $transaction->formatted_payment_method }}
                                                    </span>
                                                </div>
                                                <div class="text-sm text-gray-500 mt-1">
                                                    Bayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}
                                                </div>
                                                @if($transaction->change_amount > 0)
                                                    <div class="text-sm text-green-600">
                                                        Kembalian: Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    @if($transaction->status === 'completed')
                                                        ✅ Selesai
                                                    @elseif($transaction->status === 'pending')
                                                        ⏳ Pending
                                                    @else
                                                        ❌ Dibatalkan
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('transactions.show', $transaction) }}" 
                                                       class="text-blue-600 hover:text-blue-900" 
                                                       title="Lihat Detail">
                                                        👁️
                                                    </a>
                                                    
                                                    @if($transaction->status === 'completed')
                                                        <button onclick="printReceipt('{{ $transaction->transaction_code }}')" 
                                                                class="text-green-600 hover:text-green-900"
                                                                title="Print Struk">
                                                            🖨️
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $transactions->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">📊</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada transaksi</h3>
                            <p class="text-gray-500 mb-4">
                                @if(request()->hasAny(['search', 'date_from', 'date_to', 'payment_method', 'status']))
                                    Tidak ada transaksi yang sesuai dengan filter yang dipilih.
                                @else
                                    Belum ada transaksi yang tercatat.
                                @endif
                            </p>
                            @can('access-pos')
                                <a href="{{ route('pos.index') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    🛒 Mulai Transaksi
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDateToday() {
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="date_from"]').value = today;
            document.querySelector('input[name="date_to"]').value = today;
        }

        function printReceipt(transactionCode) {
            // Here you can implement receipt printing functionality
            // For now, we'll just show a notification
            alert('🖨️ Fitur print struk untuk transaksi ' + transactionCode + ' akan segera tersedia!');
            
            // Example implementation for future use:
            // window.open('/transactions/' + transactionCode + '/receipt', '_blank', 'width=400,height=600');
        }
    </script>
</x-app-layout> 