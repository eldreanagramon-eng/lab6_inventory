<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->name }} History</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <table class="w-full text-left">
                    <thead><tr class="border-b"><th class="py-2">Date</th><th class="py-2">Type</th><th class="py-2">Qty</th><th class="py-2">User</th></tr></thead>
                    <tbody>
                        @foreach($product->transactions as $tx)
                        <tr class="border-b">
                            <td class="py-2">{{ $tx->created_at->format('M d, Y') }}</td>
                            <td class="py-2">{{ $tx->type }}</td>
                            <td class="py-2">{{ $tx->quantity }}</td>
                            <td class="py-2">{{ $tx->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>