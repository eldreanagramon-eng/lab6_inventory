<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Product</label>
                        <select name="product_id" class="w-full border-gray-300 rounded" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Current: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Transaction Type</label>
                        <select name="type" class="w-full border-gray-300 rounded" required>
                            <option value="stock_in">Stock In (Add)</option>
                            <option value="stock_out">Stock Out (Remove)</option>
                            <option value="adjustment">Adjustment</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Quantity</label>
                        <input type="number" name="quantity" class="w-full border-gray-300 rounded" min="1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Reference Number (Optional)</label>
                        <input type="text" name="reference_number" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Notes (Optional)</label>
                        <textarea name="notes" class="w-full border-gray-300 rounded"></textarea>
                    </div>

                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                        Save Transaction
                    </button>
                    <a href="{{ route('transactions.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>