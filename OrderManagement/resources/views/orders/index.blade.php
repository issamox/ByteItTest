@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center text-2xl font-bold">Orders List</h1>

        <!--  create a new order -->
        <a href="{{ route('orders.create') }}" class="bg-green-500 text-white my-5 px-4 py-2 inline-block rounded hover:bg-yellow-600">Create New Order</a>

        <!-- Clients Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-bold mb-6">Orders List</h2>

            <table class="min-w-full table-auto">
                <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Client</th>
                    <th class="py-3 px-6 text-left">Order date</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $key => $order)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $key + 1  }}</td>
                        <td class="py-3 px-6">{{ $order->client->name }}</td>
                        <td class="py-3 px-6">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y')  }}</td>
                        <td class="py-3 px-6">{{ $order->status }}</td>


                        <td class="py-3 px-6">
                            <a href="{{ route('orders.pdf', $order->id) }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Download PDF</a>
                            <a href="{{ route('orders.edit', $order->id) }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded ml-2 hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3 px-6">No orders available.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mx-auto mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
