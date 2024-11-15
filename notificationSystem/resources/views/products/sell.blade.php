@extends('layouts.app')

@section('content')
    <a href="{{ route('products.index') }}" class="my-3 underline decoration-1 text-blue-500 font-bold inline-block text-xl py-2  rounded ">Back</a>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Sell quantity of : {{ $product->name }}</h2>

        <!-- Product Create Form -->
        <form action="{{ route('products.sell', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Sell</label>
                <input type="number" id="quantity" name="quantity" min="1" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter qte of the product you want to buy" required value="{{ old('quantity') }}">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Sell</button>
            </div>
        </form>
    </div>
@endsection
