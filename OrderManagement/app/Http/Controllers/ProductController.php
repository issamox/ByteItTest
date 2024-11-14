<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        // Start a query to get products
        $query = Product::query();

        // Filter by category if a category is selected
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range if both min and max prices are provided
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Get the filtered products with pagination
        $products = $query->paginate(10);

        return view('products.index', compact('products','categories'));
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
         Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
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
    public function update(StoreProductRequest $request, Product $product)
    {
        $imagePath = $product->image; // Keep the existing image if no new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image) {
                Storage::delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Update the product data
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');

    }

}
