@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-2xl font-bold">Product List</h1>

    <!--  create a new product -->
    <div class="flex justify-between items-center">
        <a href="{{ route('products.create') }}" class="bg-green-500 text-white my-5 px-4 py-2 inline-block rounded hover:bg-yellow-600">Create New Product</a>
        <a href="{{ route('products.export') }}" class="bg-blue-500 text-white my-5 px-4 py-2 inline-block rounded hover:bg-yellow-600">Export Products</a>
    </div>


    <!-- Products Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <h2 class="text-2xl font-bold mb-6">Product List</h2>


        <table class="min-w-full table-auto">
            <thead class="bg-blue-600 text-white">
            <tr>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">quantity in stock</th>
                <th class="py-3 px-6 text-left">minimum threshold</th>
                <th class="py-3 px-6 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $product->name }}</td>
                    <td class="py-3 px-6">{{ $product->quantity_in_stock }}</td>
                    <td class="py-3 px-6">{{ $product->minimum_threshold }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded ml-2 hover:bg-red-600">Delete</button>
                        </form>

                        <a href="{{ route('products.buy', $product->id) }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Buy</a>
                        <a href="{{ route('products.sell', $product->id) }}" class="bg-pink-500 text-white py-2 px-4 rounded hover:bg-pink-600">Sell</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mx-auto mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
