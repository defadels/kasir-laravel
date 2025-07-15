<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> --}}
                        <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-9 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        🏠 {{ __('Dashboard') }}
                    </x-nav-link>

                    @can('access-pos')
                        <x-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.*')">
                            🛒 Kasir POS
                        </x-nav-link>
                    @endcan

                    @can('view-products')
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                            📦 Produk
                        </x-nav-link>
                    @endcan

                    @can('view-categories')
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                            🏷️ Kategori
                        </x-nav-link>
                    @endcan

                    @can('view-transactions')
                        <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                            📊 Riwayat Transaksi
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Stock Alert Indicator -->
                @can('view-stock-alerts')
                    <div class="mr-3">
                        <button id="stock-alert-btn" class="relative p-2 text-gray-500 hover:text-gray-700">
                            <span class="text-lg">⚠️</span>
                            <span id="stock-alert-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1 hidden">0</span>
                        </button>
                    </div>
                @endcan

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <span class="mr-2">{{ auth()->user()->hasRole('owner') ? '👑' : '👤' }}</span>
                                <div>{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-400 block">
                                    {{ auth()->user()->hasRole('owner') ? 'Owner' : 'Kasir' }}
                                </div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            ⚙️ {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                🚪 {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @can('access-pos')
                <x-responsive-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.*')">
                    🛒 Kasir POS
                </x-responsive-nav-link>
            @endcan

            @can('view-products')
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    📦 Produk
                </x-responsive-nav-link>
            @endcan

            @can('view-categories')
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    🏷️ Kategori
                </x-responsive-nav-link>
            @endcan

            @can('view-transactions')
                <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                    📊 Riwayat Transaksi
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 flex items-center">
                    <span class="mr-2">{{ auth()->user()->hasRole('owner') ? '👑' : '👤' }}</span>
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }} - {{ auth()->user()->hasRole('owner') ? 'Owner' : 'Kasir' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    ⚙️ {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        🚪 {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- Stock Alert Modal -->
    <div id="stock-alert-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4 max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">⚠️ Peringatan Stok</h3>
                <button onclick="closeStockAlertModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="stock-alert-content">
                <!-- Content will be filled by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Load stock alerts on page load
        document.addEventListener('DOMContentLoaded', function() {
            @can('view-stock-alerts')
                loadStockAlerts();
                
                // Refresh alerts every 5 minutes
                setInterval(loadStockAlerts, 5 * 60 * 1000);
            @endcan
        });

        @can('view-stock-alerts')
        function loadStockAlerts() {
            fetch('{{ route("dashboard.stock-alerts") }}')
                .then(response => response.json())
                .then(data => {
                    const alertCount = data.length;
                    const countElement = document.getElementById('stock-alert-count');
                    const alertBtn = document.getElementById('stock-alert-btn');
                    
                    if (alertCount > 0) {
                        countElement.textContent = alertCount;
                        countElement.classList.remove('hidden');
                        alertBtn.onclick = showStockAlertModal;
                        alertBtn.classList.add('cursor-pointer');
                    } else {
                        countElement.classList.add('hidden');
                        alertBtn.onclick = null;
                        alertBtn.classList.remove('cursor-pointer');
                    }
                })
                .catch(error => console.log('Error loading stock alerts:', error));
        }

        function showStockAlertModal() {
            fetch('{{ route("dashboard.stock-alerts") }}')
                .then(response => response.json())
                .then(data => {
                    const content = document.getElementById('stock-alert-content');
                    
                    if (data.length === 0) {
                        content.innerHTML = '<p class="text-green-600 text-center py-4">✅ Semua produk stok aman</p>';
                    } else {
                        let html = '<div class="space-y-3">';
                        data.forEach(product => {
                            const statusClass = product.status === 'out_of_stock' ? 'text-red-600' : 'text-yellow-600';
                            const statusText = product.status === 'out_of_stock' ? 'Habis' : 'Rendah';
                            
                            html += `
                                <div class="border-b border-gray-100 pb-3">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-sm text-gray-900">${product.name}</h4>
                                            <p class="text-xs text-gray-500">SKU: ${product.sku} | ${product.category}</p>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-800">${statusText}</span>
                                    </div>
                                    <div class="text-right mt-1">
                                        <span class="font-medium ${statusClass}">
                                            ${product.current_stock} / ${product.min_stock}
                                        </span>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                        content.innerHTML = html;
                    }
                    
                    document.getElementById('stock-alert-modal').classList.remove('hidden');
                    document.getElementById('stock-alert-modal').classList.add('flex');
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('stock-alert-content').innerHTML = 
                        '<p class="text-red-600 text-center py-4">❌ Error loading stock alerts</p>';
                });
        }

        function closeStockAlertModal() {
            document.getElementById('stock-alert-modal').classList.add('hidden');
            document.getElementById('stock-alert-modal').classList.remove('flex');
        }
        @endcan
    </script>
</nav>
