<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Product') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <label class="block font-bold mb-2">Name</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">SKU</label>
                    <input type="text" name="sku" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">Quantity</label>
                    <input type="number" name="quantity" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">Reorder Level</label>
                    <input type="number" name="reorder_level" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border-gray-300 rounded mb-4" required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>