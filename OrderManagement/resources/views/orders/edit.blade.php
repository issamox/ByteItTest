@extends('layouts.app')

@section('content')

    <div class="mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Update Order : #{{ $order->order_number  }} </h2>

        <!-- Order Create Form -->
        <form action="{{ route('orders.update' , $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-3 gap-6">
                <div class="mb-4">
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client Name </label>

                    <select class="search-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" name="client_id" id="client_id">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected( $client->id == $order->client_id )>{{ $client->name }}</option>
                        @endforeach
                    </select>

                    @error('client_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date </label>
                    <input type="date" id="name" name="name" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d')  }}">

                    @error('order_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="order_number" class="block text-sm font-medium text-gray-700">Order number </label>
                    <input type="text" id="order_number" name="order_number" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" readonly value="{{ $order->order_number  }}">

                    @error('order_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <!-- Products Table -->
            <table class="min-w-full table-auto text-center" id="product-table">
                <thead class="bg-gray-600 text-white">
                <tr>
                    <th class="py-3 px-6  w-[20%]">Product</th>
                    <th class="py-3 px-6  w-[20%]">Price</th>
                    <th class="py-3 px-6  w-[20%]">Quantity</th>
                    <th class="py-3 px-6  w-[20%]">Subtotal</th>
                    <th class="py-3 px-6  w-[20%]">Action</th>
                </tr>
                </thead>
                <tbody class="mt-4">
                @forelse($order->products as $key => $orderProduct)
                    <tr class="product-row">
                        <td colspan="w-[20%]">
                            <select name="products[{{$key}}][id]" class="product-select w-full"  required>
                                <option value="" data-price="0">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" @selected( $orderProduct->id == $product->id ) > {{ $product->name }} </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="w-[20%]">$<span class="price-value">{{ number_format($orderProduct->price,2) }}</span></td>
                        <td class="w-[20%]"><input type="number" name="products[{{$key}}][quantity]" class="quantity w-full text-center mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" min="1" value="{{ $orderProduct->pivot->quantity ?? 1 }}"  required></td>
                        <td class="w-[20%]">$<span class="subtotal w-full">{{ number_format($orderProduct->price * $orderProduct->pivot->quantity,2) }}</span></td>
                        <td class="w-[20%]"><button type="button" class="remove-product bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600">Remove</button></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Products founds !</td>
                    </tr>
                @endforelse

                </tbody>
                <tfoot class="h-[80px]">
                <tr>
                    <td colspan="3"></td>
                    <td>
                        <strong>Total:</strong>
                    </td>
                    <td>
                        <strong>$<span id="total-price">{{ number_format($total,2) }}</span></strong>
                    </td>
                </tr>
                </tfoot>
            </table>

            <!-- Add Product Button -->
            <div class="flex">
                <button type="button" id="add-product" class="bg-green-500 text-white py-2 px-6 rounded-lg hover:bg-green-600">Add Another Product</button>
            </div>




            <div class="flex justify-end mt-12">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Update Order</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 on the first product dropdown
            $('.product-select').select2();

            // Counter to keep track of product fields
            let productCount = {{ count( $order->products ) }};

            // Function to calculate total price
            function calculateTotal() {
                let total = 0;

                $('#product-table .product-row').each(function() {
                    const price = parseFloat($(this).find('.price-value').text()) || 0;
                    const quantity = parseInt($(this).find('.quantity').val()) || 1;
                    const subtotal = price * quantity;
                    $(this).find('.subtotal').text(subtotal.toFixed(2));
                    total += subtotal;
                });

                $('#total-price').text(total.toFixed(2));
            }

            // Add Product Button Click Event
            $('#add-product').on('click', function() {
                // Append a new product row
                $('#product-table tbody').append(`
            <tr class="product-row">
                <td class="w-[20%]">
                    <select name="products[${productCount}][id]" class="product-select w-full" required>
                        <option value="" data-price="0">Select a product</option>
                        @foreach($products as $product) <option value="{{ $product->id }}" data-price="{{ $product->price }}"> {{ $product->name }}</option> @endforeach
                </select>
            </td>
            <td class="w-[20%]">$<span class="price-value">0.00</span></td>
            <td class="w-[20%]"><input type="number" name="products[${productCount}][quantity]" class="quantity w-full text-center mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" min="1" value="1" required></td>
                <td>$<span class="subtotal w-full">0.00</span></td>
                <td><button type="button" class="remove-product bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600">Remove</button></td>
            </tr>
        `);

                // Initialize Select2 on the new product select
                $('.product-select').select2();

                // Increment the counter
                productCount++;
                calculateTotal();
            });

            // Handle product selection change
            $(document).on('change', '.product-select', function() {
                const selectedOption = $(this).find('option:selected');
                const price = parseFloat(selectedOption.data('price')) || 0;
                $(this).closest('.product-row').find('.price-value').text(price.toFixed(2));
                calculateTotal();
            });

            // Handle quantity input change
            $(document).on('input', '.quantity', function() {
                calculateTotal();
            });

            // Remove Product Button Click Event
            $(document).on('click', '.remove-product', function() {
                $(this).closest('.product-row').remove();
                calculateTotal();
            });
        });
    </script>
@endsection
