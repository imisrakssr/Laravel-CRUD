<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index(Request $request)
    {
        // Handle sorting
        $sort_by = $request->get('sort_by', 'name');
        $sort_order = $request->get('sort_order', 'asc');

        // Handle search
        $search = $request->get('search', '');

        // Query with sorting and searching
        $products = Product::where('product_id', 'like', "%$search%")
                           ->orWhere('description', 'like', "%$search%")
                           ->orderBy($sort_by, $sort_order)
                           ->paginate(10);

        return view('products.index', compact('products', 'sort_by', 'sort_order', 'search'));
    }

    // Show the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a newly created product in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|unique:products|max:255',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->product_id = $validated['product_id'];
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->stock = $validated['stock'] ?? null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index');
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update the specified product in the database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|max:255|unique:products,product_id,' . $id,
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->product_id = $validated['product_id'];
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->stock = $validated['stock'] ?? null;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image from storage
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index');
    }

    // Remove the specified product from the database
    public function destroy($id)
        {
    $product = Product::findOrFail($id);
    // Delete the product image if it exists
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }


    // Show the specified product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
}
