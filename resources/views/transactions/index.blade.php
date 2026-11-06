<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('transactions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Record New Transaction
                    </a>
                </div>

                <!-- FILTER FORM (Part 3 & 5 requirement) -->
                <form action="{{ route('transactions.index') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg flex flex-wrap gap-4 items-end border border-gray-200">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Product</label>
                        <select name="product_id" class="border-gray-300 rounded text-sm w-40">
                            <option value="">All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Type</label>
                        <select name="type" class="border-gray-300 rounded text-sm w-32">
                            <option value="">All Types</option>
                            <option value="stock_in" {{ request('type') == 'stock_in' ? 'selected' : '' }}>Stock In</option>
                            <option value="stock_out" {{ request('type') == 'stock_out' ? 'selected' : '' }}>Stock Out</option>
                            <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="border-gray-300 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="border-gray-300 rounded text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm font-bold hover:bg-gray-900">Filter</button>
                        <a href="{{ route('transactions.index') }}" class="text-sm text-gray-600 hover:underline py-2">Clear</a>
                    </div>
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="py-2 px-3">Date</th>
                            <th class="py-2 px-3">Product</th>
                            <th class="py-2 px-3">Type</th>
                            <th class="py-2 px-3">Quantity</th>
                            <th class="py-2 px-3">Reference</th>
                            <th class="py-2 px-3">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                            <td class="py-2 px-3">
                                <!-- CLICKABLE PRODUCT LINK (Part 5 requirement) -->
                                <a href="{{ route('products.show', $transaction->product) }}" class="text-blue-600 hover:underline font-semibold">
                                    {{ $transaction->product->name }}
                                </a>
                            </td>
                            <td class="py-2 px-3">
                                @if($transaction->type === 'stock_in')
                                    <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded text-xs">Stock In</span>
                                @elseif($transaction->type === 'stock_out')
                                    <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded text-xs">Stock Out</span>
                                @else
                                    <span class="text-yellow-600 font-bold bg-yellow-100 px-2 py-1 rounded text-xs">Adjustment</span>
                                @endif
                            </td>
                            <td class="py-2 px-3 font-bold">{{ $transaction->quantity }}</td>
                            <td class="py-2 px-3 text-gray-500">{{ $transaction->reference_number ?? 'N/A' }}</td>
                            <td class="py-2 px-3">{{ $transaction->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No transactions found matching your filters.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>