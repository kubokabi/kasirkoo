<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;

class Categories extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Jika ada parameter pencarian, filter data berdasarkan nama kategori
        $categories = $query
            ? Category::where('name', 'LIKE', "%$query%")->latest()->get()
            : Category::latest()->get();

        $active =  'dashboard';
        return Inertia::render('Categories/Index', [
            'kategori' => $categories,
            'activeCategories' => $active,
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'description' => 'required',
        ]);

        $imagePath = $request->file('image')->store('/', 'public_images');

        // Create post
        $data = Category::create([
            'image' => $imagePath,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($data) {
            return redirect()->route('categories.index')->with('message', 'Category added successfully!');
        }
    }

    public function edit(Category $Category)
    {
        return Inertia::render('Categories/Edit', [
            'ktg' => $Category
        ]);
    }

    public function update(Request $request, Category $Category)
    {
        // Set validation rules
        $request->validate([
            'name' => 'required|unique:categories,name,' . $Category->id,
            'description' => 'required',
        ]);

        // Get existing image path
        $imagePath = public_path('images/' . $Category->image);

        // Update post data
        $Category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Validate and store the new image
            $newImagePath = $request->file('image')->store('/', 'public_images');

            // Periksa apakah file ada sebelum menghapus
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Update the image path in the database
            $Category->update(['image' => $newImagePath]);
        }

        return redirect()->route('categories.index')->with('message', 'Categories updated successfully!');
    }

    public function destroy($id)
    {
        // Find category by ID
        $category = Category::findOrFail($id);

        // Delete the associated image file
        if ($category->image) {
            $imagePath = public_path('images/' . $category->image);

            // Periksa apakah file ada sebelum menghapus
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the category
        $category->delete();
    }
}
