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

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Date</th>
                            <th class="py-2">Product</th>
                            <th class="py-2">Type</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                            <td class="py-2">{{ $transaction->product->name }}</td>
                            <td class="py-2">
                                @if($transaction->type === 'stock_in')
                                    <span class="text-green-600 font-bold">Stock In</span>
                                @elseif($transaction->type === 'stock_out')
                                    <span class="text-red-600 font-bold">Stock Out</span>
                                @else
                                    <span class="text-yellow-600 font-bold">Adjustment</span>
                                @endif
                            </td>
                            <td class="py-2">{{ $transaction->quantity }}</td>
                            <td class="py-2">{{ $transaction->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>