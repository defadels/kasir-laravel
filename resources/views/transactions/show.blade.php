<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Detail Transaksi: {{ $transaction->transaction_code }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Kembali
                </a>
                @if($transaction->status === 'completed')
                    @can('print-receipts')
                        <button onclick="printReceipt()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            🖨️ Print Struk
                        </button>
                    @endcan
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Transaction Info -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Transaksi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kode Transaksi</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $transaction->transaction_code }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <p class="mt-1">
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
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal & Waktu</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $transaction->transaction_date->format('d/m/Y H:i:s') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kasir</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $transaction->user->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($transaction->customer_name)
                                            {{ $transaction->customer_name }}
                                            @if($transaction->customer_phone)
                                                <br><span class="text-gray-500">{{ $transaction->customer_phone }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-500 italic">Customer umum</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-800' : 
                                               ($transaction->payment_method === 'card' ? 'bg-blue-100 text-blue-800' :
                                               ($transaction->payment_method === 'qris' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $transaction->formatted_payment_method }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            @if($transaction->notes)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $transaction->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Produk</h3>
                            
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
                                                Qty
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Subtotal
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($transaction->details as $detail)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if($detail->product && $detail->product->image)
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded object-cover" 
                                                                     src="{{ asset('storage/' . $detail->product->image) }}" 
                                                                     alt="{{ $detail->product_name }}">
                                                            </div>
                                                        @else
                                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                                📦
                                                            </div>
                                                        @endif
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $detail->product_name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                SKU: {{ $detail->product_sku }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $detail->product->category->name ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        Rp {{ number_format($detail->unit_price, 0, ',', '.') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $detail->quantity }} {{ $detail->unit }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-4">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-medium">
                                        Rp {{ number_format($transaction->details->sum('subtotal'), 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                @if($transaction->discount_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Diskon:</span>
                                        <span class="font-medium text-red-600">
                                            - Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                                
                                @if($transaction->tax_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Pajak:</span>
                                        <span class="font-medium">
                                            Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="border-t pt-3">
                                    <div class="flex justify-between text-lg">
                                        <span class="font-semibold">Total:</span>
                                        <span class="font-bold text-blue-600">
                                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="border-t pt-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Dibayar:</span>
                                        <span class="font-medium">
                                            Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    @if($transaction->change_amount > 0)
                                        <div class="flex justify-between text-sm mt-1">
                                            <span class="text-gray-600">Kembalian:</span>
                                            <span class="font-medium text-green-600">
                                                Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Transaction Stats -->
                            <div class="mt-6 pt-6 border-t">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Statistik</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Total Item:</span>
                                        <span>{{ $transaction->details->sum('quantity') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jenis Produk:</span>
                                        <span>{{ $transaction->details->count() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if($transaction->updated_at != $transaction->created_at)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Diupdate:</span>
                                            <span>{{ $transaction->updated_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            window.showNotification('info', 'Print Struk', 'Fitur print struk untuk transaksi {{ $transaction->transaction_code }} akan segera tersedia!');
        }
    </script>
</x-app-layout> 