<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Product') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="block font-bold mb-2">Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">SKU</label>
                    <input type="text" name="sku" value="{{ $product->sku }}" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">Quantity</label>
                    <input type="number" name="quantity" value="{{ $product->quantity }}" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">Reorder Level</label>
                    <input type="number" name="reorder_level" value="{{ $product->reorder_level }}" class="w-full border-gray-300 rounded mb-4" required>
                    <label class="block font-bold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full border-gray-300 rounded mb-4" required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>