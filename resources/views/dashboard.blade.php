<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-sm">Total Products</div>
                    <div id="total_products" class="text-2xl font-bold">0</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-sm">Low Stock Items</div>
                    <div id="low_stock" class="text-2xl font-bold text-yellow-600">0</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-sm">Out of Stock</div>
                    <div id="out_of_stock" class="text-2xl font-bold text-red-600">0</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-sm">Total Inventory Value</div>
                    <div id="total_value" class="text-2xl font-bold text-green-600">$0.00</div>
                </div>
            </div>

            <!-- RECENT TRANSACTIONS -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Recent Transactions <span id="last_updated" class="text-xs text-gray-400 font-normal"></span></h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Product</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="recent_transactions">
                        <!-- Data will be injected here via AJAX -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- AJAX POLLING JAVASCRIPT -->
    <script>
        async function fetchDashboardStats() {
            try {
                const response = await fetch('/api/dashboard/stats');
                const data = await response.json();

                document.getElementById('total_products').innerText = data.total_products;
                document.getElementById('low_stock').innerText = data.low_stock;
                document.getElementById('out_of_stock').innerText = data.out_of_stock;
                document.getElementById('total_value').innerText = '$' + parseFloat(data.total_value).toFixed(2);

                const tbody = document.getElementById('recent_transactions');
                tbody.innerHTML = ''; 
                
                data.recent_transactions.forEach(tx => {
                    const typeColor = tx.type === 'stock_in' ? 'text-green-600' : 'text-red-600';
                    tbody.innerHTML += `
                        <tr class="border-b">
                            <td class="py-2">${tx.product.name}</td>
                            <td class="py-2 font-bold ${typeColor}">${tx.type.replace('_', ' ')}</td>
                            <td class="py-2">${tx.quantity}</td>
                        </tr>
                    `;
                });

                document.getElementById('last_updated').innerText = 'Last updated: ' + new Date().toLocaleTimeString();

            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        }

        fetchDashboardStats();
        setInterval(fetchDashboardStats, 30000); // Updates every 30 seconds
    </script>
</x-app-layout>