@extends('layouts.app')

@section('content')
    <a href="{{ route('products.index') }}" class="my-3 underline decoration-1 text-blue-500 font-bold inline-block text-xl py-2  rounded ">Back</a>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Product : {{ $product->name }} </h2>

        <!-- Product Create Form -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" id="name" name="name" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter product name" required value="{{ $product->name }}">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Product category</label>
                <select name="category_id" id="category_id" class="w-full w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"  required>
                    <option value="" >Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected( $category->id == $product->category->id ) > {{ $category->name }} </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="quantity_in_stock" class="block text-sm font-medium text-gray-700">Quantity in stock</label>
                <input type="number" id="quantity_in_stock" name="quantity_in_stock" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter product Qte" required value="{{ $product->quantity_in_stock }}">
                @error('quantity_in_stock')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="minimum_threshold" class="block text-sm font-medium text-gray-700">Minimum threshold</label>
                <input type="number" id="minimum_threshold" name="minimum_threshold" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter product mini threshold" required value="{{ $product->minimum_threshold }}">
                @error('minimum_threshold')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Update Product</button>
            </div>
        </form>
    </div>
@endsection
