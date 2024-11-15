<?php

namespace App\Http\Controllers;

use App\Events\ProductThresholdReached;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\StockThresholdNotification;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10); // using eager loading
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        $product = Product::create($request->validated());

        $this->lowStock($product);

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        $this->lowStock($product);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product has been deleted');
    }

    public function buyView(Product $product)
    {
        return view('products.buy', compact('product'));
    }
    public function buy(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $product->buy($request->quantity);
            $this->lowStock($product);
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', $e->getMessage());
        }
    }


    public function sellView(Product $product)
    {
        return view('products.sell', compact('product'));
    }

    public function sell(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $product->sell($request->quantity);
            $this->lowStock($product);
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', $e->getMessage());
        }
    }

    private function lowStock(Product $product){
        if ($product->quantity_in_stock <= $product->minimum_threshold) {
             $adminUser = User::find(1); // I use this user as admin
             $adminUser->notify(new StockThresholdNotification($product));

            event(new ProductThresholdReached($product));
        }
    }
}
