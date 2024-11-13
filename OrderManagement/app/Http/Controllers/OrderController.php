<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('client')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        $order_num =  Order::max('id') + 1;
        return view('orders.create', compact('clients','products','order_num'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            // Create the new order with client_id and order_num
            $order = Order::create([
                'client_id' => $request->client_id,
                'order_number' => $request->order_number,
            ]);

            // Attach products to the order with their quantities
            foreach ($request->products as $productData) {
                $order->products()->attach($productData['id'], ['quantity' => $productData['quantity']]);
            }

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred while creating the order.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $clients = Client::all();
        $products = Product::all();
        // Calculate total price
        $total = $order->products->sum(function ($product) {
            return $product->pivot->quantity * $product->price; // quantity * price
        });
        return view('orders.edit', compact('clients','products','order','total'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {

            $order->update([
                'client_id' => $request->client_id,
            ]);

            $order->products()->detach();

            // Attach products to the order with their quantities
            foreach ($request->products as $productData) {
                $order->products()->attach($productData['id'], ['quantity' => $productData['quantity']]);
            }

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred while creating the order.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Generate PDF for order with product and client info.
     */
    public function generatePDF(Order $order)
    {
        // Calculate total price
        $total = $order->products->sum(function ($product) {
            return $product->pivot->quantity * $product->price; // quantity * price
        });
        // Load a view with the order data
        $pdf = Pdf::loadView('orders.pdf', compact('order','total'));

        // Return the generated PDF as a response to the browser
        return $pdf->download('order-' . $order->id . '.pdf');
    }

}
