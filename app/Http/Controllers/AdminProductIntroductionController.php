<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductIntroduction;
use Illuminate\Support\Facades\Storage;

class AdminProductIntroductionController extends Controller
{
    /**
     * Show product introduction management page
     */
    public function index()
    {
        $introduction = ProductIntroduction::getActive();
        return view('admin.product-introduction.index', compact('introduction'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $introduction = ProductIntroduction::findOrFail($id);
        return view('admin.product-introduction.edit', compact('introduction'));
    }

    /**
     * Update product introduction
     */
    public function update(Request $request, $id)
    {
        $introduction = ProductIntroduction::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'feature_1_title' => 'nullable|string|max:255',
            'feature_1_description' => 'nullable|string',
            'feature_2_title' => 'nullable|string|max:255',
            'feature_2_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($introduction->image_path) {
                Storage::disk('public')->delete($introduction->image_path);
            }
            
            $imagePath = $request->file('image')->store('product-introductions', 'public');
            $validated['image_path'] = $imagePath;
        }

        $introduction->update($validated);

        return redirect()->route('admin.product-introduction.index')
            ->with('success', 'Pengenalan produk berhasil diperbarui!');
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.product-introduction.create');
    }

    /**
     * Store new product introduction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'feature_1_title' => 'nullable|string|max:255',
            'feature_1_description' => 'nullable|string',
            'feature_2_title' => 'nullable|string|max:255',
            'feature_2_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product-introductions', 'public');
            $validated['image_path'] = $imagePath;
        }

        ProductIntroduction::create($validated);

        return redirect()->route('admin.product-introduction.index')
            ->with('success', 'Pengenalan produk berhasil dibuat!');
    }

    /**
     * Set as active
     */
    public function setActive($id)
    {
        $introduction = ProductIntroduction::findOrFail($id);
        
        // Deactivate all
        ProductIntroduction::where('is_active', true)->update(['is_active' => false]);
        
        // Activate selected
        $introduction->update(['is_active' => true]);

        return redirect()->route('admin.product-introduction.index')
            ->with('success', 'Pengenalan produk berhasil diaktifkan!');
    }

    /**
     * Delete product introduction
     */
    public function destroy($id)
    {
        $introduction = ProductIntroduction::findOrFail($id);
        
        if ($introduction->is_active) {
            return redirect()->route('admin.product-introduction.index')
                ->with('error', 'Tidak dapat menghapus pengenalan produk yang sedang aktif!');
        }

        // Delete image if exists
        if ($introduction->image_path) {
            Storage::disk('public')->delete($introduction->image_path);
        }

        $introduction->delete();

        return redirect()->route('admin.product-introduction.index')
            ->with('success', 'Pengenalan produk berhasil dihapus!');
    }
}
