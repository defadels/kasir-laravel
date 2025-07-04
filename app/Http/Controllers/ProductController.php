<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-products')->only(['index', 'show']);
        $this->middleware('permission:create-products')->only(['create', 'store']);
        $this->middleware('permission:edit-products')->only(['edit', 'update']);
        $this->middleware('permission:delete-products')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('category', function($cat) use ($search) {
                      $cat->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Filter by low stock
        if ($request->has('low_stock') && $request->low_stock) {
            $query->lowStock();
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($data['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['track_stock'] = $request->has('track_stock');

        Product::create($data);

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'transactionDetails.transaction');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $imageName = Str::slug($data['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Set boolean values
        $data['is_active'] = $request->has('is_active');
        $data['track_stock'] = $request->has('track_stock');

        $product->update($data);

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product has transactions
        if ($product->transactionDetails()->count() > 0) {
            return redirect()->route('products.index')
                            ->with('error', 'Produk tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Update stock for a product
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'action' => 'required|in:add,subtract,set'
        ]);

        $currentStock = $product->stock;
        $newStock = $request->stock;

        switch ($request->action) {
            case 'add':
                $product->stock = $currentStock + $newStock;
                break;
            case 'subtract':
                if ($currentStock >= $newStock) {
                    $product->stock = $currentStock - $newStock;
                } else {
                    return redirect()->back()
                                    ->with('error', 'Stok tidak mencukupi untuk dikurangi.');
                }
                break;
            case 'set':
                $product->stock = $newStock;
                break;
        }

        $product->save();

        return redirect()->back()
                        ->with('success', 'Stok produk berhasil diperbarui.');
    }
}
