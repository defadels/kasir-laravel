<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-categories')->only(['index', 'show']);
        $this->middleware('permission:create-categories')->only(['create', 'store']);
        $this->middleware('permission:edit-categories')->only(['edit', 'update']);
        $this->middleware('permission:delete-categories')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $categories = $query->latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($data['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Set boolean value
        $data['is_active'] = $request->has('is_active');

        // Auto generate slug
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->active()->latest();
        }]);
        
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $image = $request->file('image');
            $imageName = Str::slug($data['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Set boolean value
        $data['is_active'] = $request->has('is_active');

        // Update slug if name changed
        if ($category->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                            ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        // Delete image if exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil dihapus.');
    }
}
