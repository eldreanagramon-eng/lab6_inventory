<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Products') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                @endif
                <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Product</a>
                <table class="w-full text-left">
                    <thead><tr class="border-b"><th class="py-2">Name</th><th class="py-2">SKU</th><th class="py-2">Qty</th><th class="py-2">Actions</th></tr></thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-b">
                            <td class="py-2"><a href="{{ route('products.show', $product) }}" class="text-blue-600 font-bold hover:underline">{{ $product->name }}</a></td>
                            <td class="py-2">{{ $product->sku }}</td>
                            <td class="py-2">{{ $product->quantity }}</td>
                            <td class="py-2"><a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:underline">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>