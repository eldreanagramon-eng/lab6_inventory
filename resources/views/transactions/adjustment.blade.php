<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Adjustment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('transactions.adjustment.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Product</label>
                        <select name="product_id" id="product_id" class="w-full border-gray-300 rounded" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-qty="{{ $product->quantity }}">
                                    {{ $product->name }} (SKU: {{ $product->sku }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Current System Quantity</label>
                        <input type="text" id="current_qty" class="w-full border-gray-300 rounded bg-gray-100" readonly value="Select a product first">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Physical Count (Actual Stock)</label>
                        <input type="number" name="physical_count" class="w-full border-gray-300 rounded" min="0" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Reason for Adjustment</label>
                        <select name="notes" class="w-full border-gray-300 rounded" required>
                            <option value="Physical count discrepancy">Physical count discrepancy</option>
                            <option value="Damaged goods">Damaged goods</option>
                            <option value="Theft/Loss">Theft/Loss</option>
                            <option value="System error">System error</option>
                        </select>
                    </div>

                    <!-- THE BUTTON IS NOW FIXED HERE -->
                    <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 24px; border-radius: 6px; font-weight: bold; cursor: pointer; border: none;">
                        Process Adjustment
                    </button>
                    <a href="{{ route('transactions.index') }}" style="margin-left: 16px; color: #4b5563; text-decoration: underline;">Cancel</a>
                </form>

            </div>
        </div>
    </div>

    <!-- Small JS to show current quantity when product is selected -->
    <script>
        document.getElementById('product_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var qty = selectedOption.getAttribute('data-qty');
            document.getElementById('current_qty').value = qty ? qty : 'Select a product first';
        });
    </script>
</x-app-layout>