<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <h3 class="text-lg font-bold mb-2">Inventory Valuation</h3>
                <p class="text-3xl text-green-600 font-bold">${{ number_format($totalValue, 2) }}</p>
                <p class="text-gray-500 text-sm">Total value of all current stock</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Low Stock Report -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold mb-4 text-red-600">Low Stock Report</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Product</th>
                                <th class="py-2">Qty Left</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr class="border-b">
                                    <td class="py-2">{{ $product->name }}</td>
                                    <td class="py-2 font-bold text-red-500">{{ $product->quantity }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="py-4 text-gray-500">All stock levels are healthy.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Stock Movement Report -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold mb-4">Stock Movement Report</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Date</th>
                                <th class="py-2">Product</th>
                                <th class="py-2">Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMovements as $tx)
                                <tr class="border-b">
                                    <td class="py-2 text-sm">{{ $tx->created_at->format('M d') }}</td>
                                    <td class="py-2 text-sm">{{ $tx->product->name }}</td>
                                    <td class="py-2 text-sm font-bold {{ $tx->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $tx->quantity > 0 ? '+' : '' }}{{ $tx->quantity }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>