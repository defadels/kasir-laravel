<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🛒 Point of Sale (POS) - {{ auth()->user()->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Dashboard
                </a>
                <button onclick="clearCart()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="clear-cart-btn">
                    🗑️ Kosongkan Keranjang
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Panel: Product Selection -->
                <div class="lg:col-span-2">
                    <!-- Search Bar -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <input type="text" 
                                           id="product-search" 
                                           placeholder="Cari produk berdasarkan nama atau SKU..."
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <select id="category-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Produk</h3>
                            <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($products as $product)
                                    <div class="product-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer"
                                         data-product="{{ json_encode($product) }}">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-24 object-cover rounded mb-2">
                                        @else
                                            <div class="w-full h-24 bg-gray-100 rounded mb-2 flex items-center justify-center">
                                                <span class="text-2xl">📦</span>
                                            </div>
                                        @endif
                                        
                                        <h4 class="font-medium text-sm text-gray-900 mb-1">{{ $product->name }}</h4>
                                        <p class="text-xs text-gray-500 mb-1">SKU: {{ $product->sku }}</p>
                                        <p class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</p>
                                        
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-bold text-blue-600">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                            @if($product->track_stock)
                                                <span class="text-xs px-2 py-1 rounded-full
                                                    {{ $product->stock > $product->min_stock ? 'bg-green-100 text-green-800' : 
                                                       ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $product->stock }} {{ $product->unit }}
                                                </span>
                                            @else
                                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                                    Unlimited
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <button onclick="addToCart({{ $product->id }})" 
                                                class="w-full bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded
                                                {{ $product->track_stock && $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $product->track_stock && $product->stock <= 0 ? 'disabled' : '' }}>
                                            + Tambah ke Keranjang
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Cart & Checkout -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-4">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keranjang Belanja</h3>
                            
                            <!-- Cart Items -->
                            <div id="cart-items" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                                @if(empty($cart))
                                    <div id="empty-cart" class="text-center text-gray-500 py-8">
                                        🛒 Keranjang kosong<br>
                                        <span class="text-sm">Tambahkan produk dari panel kiri</span>
                                    </div>
                                @else
                                    @foreach($cart as $item)
                                        <div class="cart-item border-b border-gray-100 pb-3" data-product-id="{{ $item['id'] }}">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <h4 class="font-medium text-sm text-gray-900">{{ $item['name'] }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $item['sku'] }}</p>
                                                    <p class="text-sm text-blue-600 font-medium">
                                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <button onclick="removeFromCart({{ $item['id'] }})" 
                                                        class="text-red-500 hover:text-red-700 ml-2">
                                                    ❌
                                                </button>
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <button onclick="updateQuantity({{ $item['id'] }}, -1)" 
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-2 rounded-l">
                                                    -
                                                </button>
                                                <input type="number" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1"
                                                       onchange="updateCartQuantity({{ $item['id'] }}, this.value)"
                                                       class="w-16 text-center border-t border-b border-gray-200 py-1">
                                                <button onclick="updateQuantity({{ $item['id'] }}, 1)" 
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-2 rounded-r">
                                                    +
                                                </button>
                                                <span class="ml-2 text-sm text-gray-500">{{ $item['unit'] }}</span>
                                            </div>
                                            <div class="text-right mt-1">
                                                <span class="font-bold text-gray-900">
                                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Cart Summary -->
                            <div class="border-t border-gray-200 pt-4" id="cart-summary">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span>Subtotal:</span>
                                        <span id="cart-subtotal">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span>Diskon:</span>
                                        <input type="number" 
                                               id="discount-amount" 
                                               value="0" 
                                               min="0"
                                               placeholder="0"
                                               class="w-20 text-right text-sm border border-gray-300 rounded px-2 py-1">
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span>Pajak:</span>
                                        <input type="number" 
                                               id="tax-amount" 
                                               value="0" 
                                               min="0"
                                               placeholder="0"
                                               class="w-20 text-right text-sm border border-gray-300 rounded px-2 py-1">
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>Total:</span>
                                        <span id="cart-total">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="mt-4 space-y-3">
                                <input type="text" 
                                       id="customer-name" 
                                       placeholder="Nama Customer (Opsional)"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                <input type="text" 
                                       id="customer-phone" 
                                       placeholder="No. HP Customer (Opsional)"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Payment Method -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                                <select id="payment-method" class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                    <option value="cash">💵 Tunai</option>
                                    <option value="card">💳 Kartu</option>
                                    <option value="qris">📱 QRIS</option>
                                    <option value="transfer">🏦 Transfer</option>
                                </select>
                            </div>

                            <!-- Payment Amount -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Bayar</label>
                                <input type="number" 
                                       id="paid-amount" 
                                       placeholder="0"
                                       min="0"
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                <div class="mt-2 text-sm">
                                    <span class="text-gray-600">Kembalian: </span>
                                    <span id="change-amount" class="font-bold text-green-600">Rp 0</span>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mt-4">
                                <textarea id="notes" 
                                          placeholder="Catatan (Opsional)"
                                          rows="2"
                                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>

                            <!-- Checkout Button -->
                            <button onclick="processCheckout()" 
                                    id="checkout-btn"
                                    class="w-full mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                💳 Proses Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <div class="text-center">
                <div class="text-6xl mb-4">✅</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Transaksi Berhasil!</h3>
                <div id="transaction-details" class="text-sm text-gray-600 space-y-1">
                    <!-- Details will be filled by JavaScript -->
                </div>
                <button onclick="closeSuccessModal()" 
                        class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        // Initialize variables
        let currentCart = @json($cart);
        
        // Product search functionality
        document.getElementById('product-search').addEventListener('input', function() {
            searchProducts();
        });

        document.getElementById('category-filter').addEventListener('change', function() {
            searchProducts();
        });

        function searchProducts() {
            const search = document.getElementById('product-search').value;
            const category = document.getElementById('category-filter').value;
            
            let url = new URL(window.location.href);
            url.searchParams.set('search', search);
            url.searchParams.set('category_id', category);
            
            window.location.href = url.toString();
        }

        // Add to cart function
        function addToCart(productId) {
            fetch('{{ route("pos.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentCart = data.cart;
                    updateCartDisplay();
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            });
        }

        // Update cart quantity
        function updateQuantity(productId, change) {
            const currentItem = currentCart[productId];
            if (!currentItem) return;
            
            const newQuantity = currentItem.quantity + change;
            if (newQuantity <= 0) {
                removeFromCart(productId);
                return;
            }
            
            updateCartQuantity(productId, newQuantity);
        }

        function updateCartQuantity(productId, quantity) {
            fetch('{{ route("pos.cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentCart = data.cart;
                    updateCartDisplay();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            });
        }

        // Remove from cart
        function removeFromCart(productId) {
            fetch('{{ route("pos.cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentCart = data.cart;
                    updateCartDisplay();
                    showNotification('Produk dihapus dari keranjang', 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            });
        }

        // Clear cart
        function clearCart() {
            showConfirmDialog(
                'Konfirmasi',
                'Yakin ingin mengosongkan keranjang?',
                function() {
                    fetch('{{ route("pos.cart.clear") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            currentCart = {};
                            updateCartDisplay();
                            window.showNotification('success', 'Berhasil!', data.message);
                        } else {
                            window.showNotification('error', 'Gagal!', data.message);
                        }
                    });
                }
            );
        }

        // Update cart display
        function updateCartDisplay() {
            const cartItems = document.getElementById('cart-items');
            const emptyCart = document.getElementById('empty-cart');
            
            if (Object.keys(currentCart).length === 0) {
                cartItems.innerHTML = '<div id="empty-cart" class="text-center text-gray-500 py-8">🛒 Keranjang kosong<br><span class="text-sm">Tambahkan produk dari panel kiri</span></div>';
                updateCartSummary(0);
                return;
            }
            
            let html = '';
            let total = 0;
            
            Object.values(currentCart).forEach(item => {
                total += item.subtotal;
                html += `
                    <div class="cart-item border-b border-gray-100 pb-3" data-product-id="${item.id}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-sm text-gray-900">${item.name}</h4>
                                <p class="text-xs text-gray-500">${item.sku}</p>
                                <p class="text-sm text-blue-600 font-medium">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 ml-2">❌</button>
                        </div>
                        <div class="flex items-center mt-2">
                            <button onclick="updateQuantity(${item.id}, -1)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-2 rounded-l">-</button>
                            <input type="number" value="${item.quantity}" min="1" onchange="updateCartQuantity(${item.id}, this.value)" class="w-16 text-center border-t border-b border-gray-200 py-1">
                            <button onclick="updateQuantity(${item.id}, 1)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-1 px-2 rounded-r">+</button>
                            <span class="ml-2 text-sm text-gray-500">${item.unit}</span>
                        </div>
                        <div class="text-right mt-1">
                            <span class="font-bold text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</span>
                        </div>
                    </div>
                `;
            });
            
            cartItems.innerHTML = html;
            updateCartSummary(total);
        }

        // Update cart summary
        function updateCartSummary(subtotal) {
            document.getElementById('cart-subtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            calculateTotal();
        }

        // Calculate total with discount and tax
        function calculateTotal() {
            const subtotal = Object.values(currentCart).reduce((sum, item) => sum + item.subtotal, 0);
            const discount = parseFloat(document.getElementById('discount-amount').value) || 0;
            const tax = parseFloat(document.getElementById('tax-amount').value) || 0;
            const total = subtotal - discount + tax;
            
            document.getElementById('cart-total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            
            // Update change amount
            const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;
            const change = Math.max(0, paidAmount - total);
            document.getElementById('change-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
            
            // Enable/disable checkout button
            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.disabled = Object.keys(currentCart).length === 0;
        }

        // Event listeners for calculation
        document.getElementById('discount-amount').addEventListener('input', calculateTotal);
        document.getElementById('tax-amount').addEventListener('input', calculateTotal);
        document.getElementById('paid-amount').addEventListener('input', calculateTotal);

        // Process checkout
        function processCheckout() {
            if (Object.keys(currentCart).length === 0) {
                showNotification('Keranjang kosong', 'error');
                return;
            }
            
            const subtotal = Object.values(currentCart).reduce((sum, item) => sum + item.subtotal, 0);
            const discount = parseFloat(document.getElementById('discount-amount').value) || 0;
            const tax = parseFloat(document.getElementById('tax-amount').value) || 0;
            const total = subtotal - discount + tax;
            const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;
            
            if (paidAmount < total) {
                showNotification('Jumlah pembayaran kurang dari total', 'error');
                return;
            }
            
            const checkoutData = {
                customer_name: document.getElementById('customer-name').value,
                customer_phone: document.getElementById('customer-phone').value,
                payment_method: document.getElementById('payment-method').value,
                paid_amount: paidAmount,
                discount_amount: discount,
                tax_amount: tax,
                notes: document.getElementById('notes').value
            };
            
            // Disable checkout button
            document.getElementById('checkout-btn').disabled = true;
            document.getElementById('checkout-btn').textContent = 'Memproses...';
            
            fetch('{{ route("pos.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(checkoutData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessModal(data);
                    resetForm();
                    currentCart = {};
                    updateCartDisplay();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat memproses transaksi', 'error');
            })
            .finally(() => {
                document.getElementById('checkout-btn').disabled = false;
                document.getElementById('checkout-btn').textContent = '💳 Proses Pembayaran';
            });
        }

        // Show success modal
        function showSuccessModal(data) {
            const modal = document.getElementById('success-modal');
            const details = document.getElementById('transaction-details');
            
            details.innerHTML = `
                <p><strong>Kode Transaksi:</strong> ${data.transaction_code}</p>
                <p><strong>Total:</strong> Rp ${new Intl.NumberFormat('id-ID').format(data.total_amount)}</p>
                <p><strong>Dibayar:</strong> Rp ${new Intl.NumberFormat('id-ID').format(data.paid_amount)}</p>
                <p><strong>Kembalian:</strong> Rp ${new Intl.NumberFormat('id-ID').format(data.change_amount)}</p>
            `;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Close success modal
        function closeSuccessModal() {
            const modal = document.getElementById('success-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Reset form
        function resetForm() {
            document.getElementById('customer-name').value = '';
            document.getElementById('customer-phone').value = '';
            document.getElementById('paid-amount').value = '';
            document.getElementById('discount-amount').value = '0';
            document.getElementById('tax-amount').value = '0';
            document.getElementById('notes').value = '';
            document.getElementById('payment-method').value = 'cash';
        }

        // Show notification
        function showNotification(message, type) {
            if (type === 'success') {
                window.showNotification('success', 'Berhasil!', message);
            } else {
                window.showNotification('error', 'Gagal!', message);
            }
        }

        // Initialize cart display
        updateCartDisplay();
    </script>
</x-app-layout> 